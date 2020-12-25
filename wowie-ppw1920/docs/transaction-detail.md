# Tranaction Detail API

Fitur ini digunakan untuk me-*retrieve* sebuah transaksi dengan *id* tertentu yang disertakan dalam bentuk parameter.

**URI Pattern**:
```
GET /transactions/{id}
```

**Request Requirements**:

Setiap *request* harus menyertakan *authorization token* dan *id* dari transaksi yang ingin di-*retrieve*.

Berikut ini adalah contoh sebuah *request* yang valid:
```
GET http://localhost/transactions/DIWpNziY7Uo9Tp66EGJ8PF7wQzW4wFiyHTv0L1wI HTTP/1.1
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Content-Type: application/json
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

```

**Response**:

*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization token* bukan tidak merujuk pada akun yang terlibat pada transaksi (sebagai *sender* atau *recipient*) maka akan dikembalikan pesan kesalahan (401).
- Sebaliknya (200), data transaksi akan diberikan.

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* berasal dari *account* yang terlibat pada transaksi.
```
HTTP/1.1 200 OK
Host: localhost
Date: Sun, 05 Jan 2020 12:58:11 GMT
Connection: close
X-Powered-By: PHP/7.3.8
Cache-Control: no-cache, private
Date: Sun, 05 Jan 2020 12:58:11 GMT
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
      "id": "DIWpNziY7Uo9Tp66EGJ8PF7wQzW4wFiyHTv0L1wI",
      "sender": "jaksem",
      "recipient": "wirosableng",
      "amount": "22.50",
      "notes": "Jajan di Lbn. Silintong",
      "status": "success",
      "issued_at": "2019-12-21 03:40:09",
      "transaction_uri": "/transactions/DIWpNziY7Uo9Tp66EGJ8PF7wQzW4wFiyHTv0L1wI",
      "sender_uri": "/accounts/jaksem",
      "receiver_uri": "/accounts/wirosableng"
   }
}

```
