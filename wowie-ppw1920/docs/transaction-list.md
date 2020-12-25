# Listing Tranactions API

Fitur ini digunakan untuk me-*retrieve* semua transaksi yang melibatkan akun tertentu. Keterlibatan dapat sebagai pengirim (*sender*) atau penerima (*recipient*).

**URI Pattern**:
```
GET /transactions
```

**Request Requirements**:
Setiap *request* harus menyertakan *authorization token*.
Berikut ini adalah contoh sebuah *request* yang valid:
```
GET http://localhost/transactions HTTP/1.1
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Content-Type: application/json
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

```

**Response**:

*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization token* tidak valid, maka akan dikembalikan pesan kesalahan (401).
- Sebaliknya (200), ketika *authorization token* valid maka akan dikembalikan semua transaksi yang melibatkan rekening (*account*), dapar sebagai pengirim (*sender*) atau penerima (*recipient*).

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* valid.
```
HTTP/1.1 200 OK
Host: localhost
Date: Sun, 05 Jan 2020 08:13:32 GMT
Connection: close
X-Powered-By: PHP/7.3.8
Cache-Control: no-cache, private
Date: Sun, 05 Jan 2020 08:13:32 GMT
Content-Type: application/json
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE
Access-Control-Allow-Credentials: true
Access-Control-Max-Age: 86400
Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With

{
   "code": 200,
   "message": "success",
   "data":    [
            {
         "id": "DxBXUgEazIUdzlVjMyptRhfUJo96Gm925RvNnU11",
         "sender": "wirosableng",
         "recipient": "jaksem",
         "amount": "10.10",
         "notes": "Beli Kembang Layang",
         "status": "success",
         "issued_at": "2020-01-04 11:05:11",
         "transaction_uri": "/transactions/DxBXUgEazIUdzlVjMyptRhfUJo96Gm925RvNnU11",
         "sender_uri": "/accounts/wirosableng",
         "receiver_uri": "/accounts/jaksem"
      },
            {
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
   ]
}


```
