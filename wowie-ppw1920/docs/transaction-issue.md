# Issuing New Tranaction API

Fitur ini digunakan untuk menerbitkan (*issue*) atau membuat sebuah transaksi baru. Sebuah transaksi melibatkan dua rekening dengan **nilai (*amount*) > 0.00 USD**.

**URI Pattern**:
```
POST /transactions/issue
```

**Request Requirements**:
Setiap *request* harus menyertakan *authorization token* dan *payload* dalam format JSON. *Payload* berisi data terkait transaksi, di antaranya *recipient*, *amount*, dan *notes*.
Berikut ini adalah contoh sebuah *request* yang valid:
```
POST http://localhost/transactions/issue HTTP/1.1
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Content-Type: application/json
Content-Length: 82
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

{
   "recipient": "jaksem",
   "amount": 10.1,
   "notes": "Beli Kembang Layang"
}

```

**Response**:

*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization token* tidak valid, maka akan dikembalikan pesan kesalahan (403).
- Sebaliknya (201), ketika *authorization token* valid maka akan dikembalikan semua transaksi yang melibatkan rekening (*account*), dapar sebagai pengirim (*sender*) atau penerima (*recipient*).

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* valid.
```
HTTP/1.1 201 OK
Host: localhost
Date: Sun, 05 Jan 2020 08:25:46 GMT
Connection: close
X-Powered-By: PHP/7.3.8
Cache-Control: no-cache, private
Date: Sun, 05 Jan 2020 08:25:46 GMT
Content-Type: application/json
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE
Access-Control-Allow-Credentials: true
Access-Control-Max-Age: 86400
Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With

{
   "code": 201,
   "message": "success",
   "data":    {
      "id": "KvNdWBT3BI79NfqTwxmVR2k4GonhZBpzHDlkZbru",
      "sender": "wirosableng",
      "recipient": "jaksem",
      "amount": 10.1,
      "notes": "Beli Kembang Layang",
      "status": "success",
      "issued_at": "2020-01-05 08:25:46",
      "transaction_uri": "/transactions/KvNdWBT3BI79NfqTwxmVR2k4GonhZBpzHDlkZbru",
      "sender_uri": "/accounts/wirosableng",
      "receiver_uri": "/accounts/jaksem"
   }
}

```
