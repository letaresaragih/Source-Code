# Account Detail API

Fitur ini digunakan untuk melihat detil informasi rekening (*account*) dari nasabah.
**URI Pattern**:
```
GET /accounts/{username}
```
**Request Requirements**:
Setiap *request* harus menyertakan *authorization token* dan sebuah parameter (*username*) dari rekening yang ingin didapatkan detil informasinya.
Berikut ini adalah contoh sebuah *request* yang valid:
```
GET http://localhost/accounts/wirosableng HTTP/1.1
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

```

**Response**:
*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization token* tidak valid, maka akan dikembalikan pesan kesalahan (403). Sebaliknya (200), ketika *authorization token* valid maka:
    - jika *authorization token* dan parameter *username* merupakan satu rekening, maka informasi yang akan dikembalikan antara lain *username*, *full_name*, *balance*, *address*, *phone*, dan *email*.
    - sebaliknya, jika *authorization token* dan parameter *username* bukan berasal dari satu rekening, maka informasi yang akan dikembalikan antara lain *username*, *full_name*, *address*, *phone*, dan *email*.

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* dan parameter *username* berasal dari satu rekening.
```
HTTP/1.1 200 OK
Host: localhost
Date: Sun, 05 Jan 2020 07:32:21 GMT
Connection: close
X-Powered-By: PHP/7.3.8
Cache-Control: no-cache, private
Date: Sun, 05 Jan 2020 07:32:21 GMT
Content-Type: application/json
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE
Access-Control-Allow-Credentials: true
Access-Control-Max-Age: 86400
Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With

{
   "code": 200,
   "message": "success",
   "data":    {
      "username": "wirosableng",
      "full_name": "Wiro Sableng",
      "balance": "989.90",
      "address": "Jl. Dunia Persilatan No. 9",
      "phone": "085262211212",
      "email": "wiro@sigurita.com",
      "account_uri": "/accounts/wirosableng",
      "transactions_uri": "/transactions"
   }
}

```
