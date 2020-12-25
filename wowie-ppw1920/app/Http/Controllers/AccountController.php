<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Payload;

class AccountController extends Controller
{
    /**
     * View an account in detail.
     *
     * @param  Request  $request
     * @param  string   $username
     * @return Response
     */
    public function detail(Request $request, string $username)
    {
        // create the response payload with default HTTP response code 200
        $resPayload = new Payload(JsonResponse::HTTP_OK);
        $continue = true;

        // check the required parameter
        if (!$username) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'incorrent request.';
            $continue = false;
        }

        $targetAccount = null;
        // find the targeted account (based on the username parameter)
        if ($continue) {
            $targetAccount = DB::table('account')
            ->where('username', $username)
            ->first();
            
            if (!$targetAccount) {
                $resPayload->code = 400;
                $resPayload->message = 'incorrent request.';
                $continue = false;
            }
        }
        
        $account = null;
        // check the token validity
        if ($continue) {
            $token = $this->getToken($request);
            if ($token) {
                $account = DB::table('account')
                ->where('token', $token)
                ->first();
            }
        }

        if ($continue) {
            // HATEOAS
            $targetAccount->account_uri = "/accounts/{$targetAccount->username}";

            if ($account->token != $targetAccount->token) {
                unset($targetAccount->balance);
            } else {
                $targetAccount->transactions_uri = "/transactions";
            }
            unset($targetAccount->token);

            $resPayload->data = $targetAccount;
        }

        // create the response object based on the response payload
        $response = new JsonResponse($resPayload, $resPayload->code);

        return($response);
    }
    
    /**
     * Update an existing account.
     * This API accepts a request with valid authorization token with JSON formatted (updated) data.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        // create the response payload with default HTTP response code 200
        $resPayload = new Payload(JsonResponse::HTTP_OK);
        $continue = true;


        // check the token validity
        $token = $this->getToken($request);
        if (!$token) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'Bad request.';
            unset($resPayload->data);
            $continue = false;
        }

        // check the format of the request payload
        if ($continue && !$request->isJson()) {
            $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
            $resPayload->message = 'unsupported format.';
            $continue = false;
        }


        $targetAccount = null;
        // find the targeted account (based on token)
        if ($continue) {
            $targetAccount = DB::table('account')
            ->where('token', $token)
            ->first();
            
            if (!$targetAccount) {
                $resPayload->code = 401;
                $resPayload->message = 'failed';
                unset($resPayload->data);
                $continue = false;
            }
        }

        if ($continue) {
            
            $new_data=json_decode($request->getContent());
            // hanya alamat , phone , dan email selainnya diabaikan/tidak diizinkan
            if (isset($new_data->address) || isset($new_data->phone) || isset($new_data->email) ){
                $change_allowed = true;

            }else{
                $change_allowed = false;

            }

            if($change_allowed){
                if (isset($new_data->address)){
                    DB::table('account')->where('token', $token)->update(['address' => $new_data->address]);
    
                }
                
                if (isset($new_data->phone)){
                    DB::table('account')->where('token', $token)->update(['phone' => $new_data->phone]);
    
                }
    
    
                if (isset($new_data->email)){
                    DB::table('account')->where('token', $token)->update(['email' => $new_data->email]);
    
                }
                

            }else{
                $resPayload->code = 200;
                $resPayload->message = "request ok but no changes." ;
                

            }

            $targetAccount = DB::table('account')
                ->where('token', $token)
                ->first();
                $targetAccount->account_uri = "/accounts/{$targetAccount->username}";
                $targetAccount->transactions_uri = "/transactions";
                unset($targetAccount->token);
                $resPayload->data = $targetAccount;
    

            
        }


        // create the response object based on the response payload
        $response = new JsonResponse($resPayload, $resPayload->code);

        return($response);
    }



    //
    public function dokter(Request $request, string $dokter_id)
    {
        // create the response payload with default HTTP response code 200
        $resPayload = new Payload(JsonResponse::HTTP_OK);
        $continue = true;
        

        if($request->isMethod('post')){
            $new_data=json_decode($request->getContent());
            if(!isset($new_data->nama) || !isset($new_data->spesialis) || !isset($new_data->jenis_kelamin) || !isset($new_data->no_telepon) || !isset($new_data->alamat) ){
                $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
                $resPayload->message = 'incorrent request.';
                $continue = false;
            }
            
            
            if($continue){

                do {
                    $random_token = Str::random(32);
                    //check whether token exist
                    $targetAccount = null;
                    $targetAccount = DB::table('dokter')
                    ->where('token', $random_token)
                    ->first();
                }while($targetAccount);


                DB::table('dokter')->insert([
                    'nama' => $new_data->nama,
                    'spesialis' => $new_data->spesialis,
                    'jenis_kelamin' => $new_data->jenis_kelamin,
                    'no_telepon' => $new_data->no_telepon,
                    'alamat' => $new_data->alamat,
                    'auth_token' => $random_token
                ]);
                    
                $resPayload->code = JsonResponse::HTTP_OK;
                $resPayload->message = 'success';
                unset($resPayload->data);
            
            }
            

        }elseif($request->isMethod('get')){
            // check the required parameter
            if (!$dokter_id) {
                $resPayload->code = JsonResponse::HTTP_BAD_REQUEST;
                $resPayload->message = 'incorrent request.';
                $continue = false;
            }

            $targetAccount = null;
            // find the targeted account (based on the id parameter)
            if ($continue) {
                $targetAccount = DB::table('dokter')
                ->where('id', $dokter_id)
                ->first();
                if($targetAccount){
                    // HATEOAS
                    $targetAccount->account_uri = "/dokter/{$targetAccount->id}";
                    $resPayload->data = $targetAccount;    
                    $resPayload->code = JsonResponse::HTTP_OK;
                    $resPayload->message = 'success';
                    unset($targetAccount->auth_token);
                    unset($targetAccount->id);
                    $resPayload->data = $targetAccount;

                }else{
                    $resPayload->code = JsonResponse::HTTP_NOT_FOUND;
                    $resPayload->message = 'data not found.';
                    unset($resPayload->data);
                }

            }

        }
        

        

        // create the response object based on the response payload
        $response = new JsonResponse($resPayload, $resPayload->code);

        return($response);
    }
}
