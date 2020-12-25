# Update Account API

Fitur ini digunakan untuk mengubah sebagian dari detil informasi rekening (*account*) nasabah. Detil yang dapat dimodifikasi antara lain *address*, *phone*, dan *email*, selain itu tidak diizinkan.

**URI Pattern**:
```
PATCH /accounts
```

**Request Requirements**:
Setiap *request* harus menyertakan *authorization token* dari rekening yang ingin dimodifikasi detil informasinya dan sebuah *payload* dalam format JSON. *Payload* berisi detil data yang akan dimodifikasi.

Berikut ini adalah contoh sebuah *request* yang valid:
```
PATCH http://localhost/accounts HTTP/1.1
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Content-Type: application/json
Content-Length: 108
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

{
   "address": "Jl. Dunia Persilatan No. 99",
   "phone": "085262211213",
   "email": "wiro@sigurita.com"
}


```

**Response**:
*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization token* tidak valid, maka akan dikembalikan pesan kesalahan (401).
- Sebaliknya (200), ketika *authorization token* valid dan operasi modifikasi berjalan dengan baik, maka akan dikembalikan detil informasi *account* yang baru.

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* valid dengan modifikasi dilakukan pada atribut *address* dan *phone*.
```
HTTP/1.1 200 OK
Host: localhost
Date: Mon, 06 Jan 2020 02:23:23 GMT
Connection: close
X-Powered-By: PHP/7.3.8
Cache-Control: no-cache, private
Date: Mon, 06 Jan 2020 02:23:23 GMT
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
      "balance": "969.70",
      "address": "Jl. Dunia Persilatan No. 99",
      "phone": "085262211213",
      "email": "wiro@sigurita.com",
      "account_uri": "/accounts/wirosableng",
      "transactions_uri": "/transactions"
   }
}

```
