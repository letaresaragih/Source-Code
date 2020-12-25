<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Payload;

class TransactionController extends Controller
{

    /**
     * Retrieve all transactions related to the authorized user.
     * This API accepts requests with valid authorization token.
     *
     * @param  Request  $request
     * @return Response
     */
    public function list(Request $request)
    {
        // create the response payload with default HTTP response code 200
        $resPayload = new Payload(JsonResponse::HTTP_OK);
        $continue = true;

        $token = $this->getToken($request);
        // check the token validity
        if (!$token) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'incorrent request.';
            $continue = false;
        }

        $account = null;
        // retrieve the account based on the given token
        if ($continue) {
            $account = DB::table('account')
            ->where('token', $token)
            ->first();
        }

        // check the account
        if (!$account) {
            $resPayload->code = JsonResponse::HTTP_UNAUTHORIZED;
            $resPayload->message = 'authorization failed.';
            $continue = false;
        }

        // retrive all transactions related to the account
        $transactions = new \Illuminate\Support\Collection();
        if ($continue) {
            $transactions = DB::table('transaction')
            ->where(function ($query) use ($account) {
                $query->where('sender', $account->username)
                      ->orWhere('recipient', $account->username);
            })->orderBy('issued_at', 'desc')
            ->get();

            // HATEOAS
            $transactions->each(function ($transaction, $key) {
                $transaction->transaction_uri = "/transactions/{$transaction->id}";
                $transaction->sender_uri = "/accounts/{$transaction->sender}";
                $transaction->receiver_uri = "/accounts/{$transaction->recipient}";
            });
        }
        
        if ($continue) {
            $resPayload->data = $transactions;
        }
        
        // create the response object based on the response payload
        $response = new JsonResponse($resPayload, $resPayload->code);

        return($response);
    }

    /**
     * Retrieve a transaction with the given id. Only accounts involved in the transaction may use this API.
     * This API accepts a request with valid authorization token.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function detail(Request $request, string $id)
    {
        // create the response payload with default HTTP response code 200
        $resPayload = new Payload(JsonResponse::HTTP_OK);
        $continue = true;

        $token = $this->getToken($request);
        // check the token validity
        if (!$token) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'incorrent request.';
            $continue = false;
        }

        $account = null;
        // retrieve the account based on the given token
        if ($continue) {
            $account = DB::table('account')
            ->where('token', $token)
            ->first();
        }

        // check the account
        if (!$account) {
            $resPayload->code = JsonResponse::HTTP_UNAUTHORIZED ;
            $resPayload->message = 'authorization failed.';
            $continue = false;
        }

        $transaction = null;
        // find a transaction with the given id (parameter)
        // since the target transaction is unique, we limit the search to the first occurance
        if ($continue) {
            $transaction = DB::table('transaction')
            ->where('id', $id)
            ->where(function ($query) use ($account) {
                $query->where('sender', $account->username)
                      ->orWhere('recipient', $account->username);
            })->first();
        }

        if (!$transaction) {
            $resPayload->code = JsonResponse::HTTP_NOT_FOUND;
            $resPayload->message = 'not found.';
            $continue = false;
        }
        
        // HATEOAS
        if ($continue) {
            $transaction->transaction_uri = "/transactions/{$transaction->id}";
            $transaction->sender_uri = "/accounts/{$transaction->sender}";
            $transaction->receiver_uri = "/accounts/{$transaction->recipient}";

            $resPayload->data = $transaction;
        }
        
        // create the response object based on the response payload
        $response = new JsonResponse($resPayload, $resPayload->code);

        return($response);
    }

    /**
     * Issue a new transaction.
     * This API accepts a request with valid authorization token with JSON formatted (transaction) data.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function issue(Request $request)
    {
        // create the response payload with default HTTP response 201
        $resPayload = new Payload(JsonResponse::HTTP_CREATED);
        $continue = true;

        $token = $this->getToken($request);
        // check the token validity
        if (!$token) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'incorrent request.';
            $continue = false;
        }

        // check the format of the request payload
        if ($continue && !$request->isJson()) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'unsupported format.';
        }

        if ($continue) {
            $sender = DB::table('account')
            ->where('token', $token)
            ->first();
        
            $recipient = DB::table('account')
            ->where('username', $request->input('recipient'))
            ->first();
        
            $amount = $request->input('amount');
            // checking both the sender, the recipient, and the amount.
            if (!$sender || !$recipient || $amount <= 0.00) {
                $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
                $resPayload->message = 'unable to complete the transaction.';
            }

            // building up the transaction data
            $transaction = [
                'id' => Str::random(40), // use random string as the transaction id
                'sender' => $sender->username,
                'recipient' => $recipient->username,
                'amount' => $amount,
                'notes' => $request->input('notes'),
                'status' => 'failed', // this status will be updated later
                'issued_at' => date("Y-m-d H:i:s")
            ];

            // check the amount validity
            if ($sender->balance - $amount > 0) {
                $sender->balance -= $amount;
                $recipient->balance += $amount;
                $transaction['status'] = 'success';
            }

            try {
                // protect the issuing process in a transaction
                DB::transaction(function () use ($sender, $recipient, $transaction) {
                    $updateSender = true;
                    $updateRecipient = true;

                    if ($transaction['status'] == 'success') {
                        $updateSender =
                        DB::table('account')
                        ->where('token', $sender->token)
                        ->update(['balance' => $sender->balance]);
                
                        $updateRecipient =
                        DB::table('account')
                        ->where('token', $recipient->token)
                        ->update(['balance' => $recipient->balance]);
                    }

                    $insertTransaction =
                        DB::table('transaction')
                        ->insert($transaction);
                    
                    if (!$updateSender || !$updateRecipient || !$insertTransaction) {
                        throw new \Exception('Fail to create transaction');
                    }
                });

                // HATEOAS
                $transaction['transaction_uri'] = "/transactions/{$transaction['id']}";
                $transaction['sender_uri'] = "/accounts/{$sender->username}";
                $transaction['receiver_uri'] = "/accounts/{$recipient->username}";
            
                $resPayload->data = $transaction;
            } catch (\Exception $exception) {
                // something goes wrong
                $resPayload->code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
                $resPayload->message = $exception->getMessage();
            }
        }

        // create the response object based on the response payload
        $response = new JsonResponse($resPayload, $resPayload->code);

        return($response);
    }
}
