# Modify Profile API

Fitur ini digunakan untuk mengubah sebagian dari detil informasi profile user. Detil yang dapat dimodifikasi antara lain *name*, *birth*, *address*, *phone*, dan *email*

**URI Pattern**:
```
PATCH /customers/{id}/edit-profile
```

**Request Requirements**:
Setiap *request* harus menyertakan *authorization credential* dari profile yang ingin dimodifikasi detil informasinya dan sebuah *payload* dalam format JSON. *Payload* berisi detil data yang akan dimodifikasi.

Berikut ini adalah contoh sebuah *request* yang valid:
```
PATCH http://localhost/customers/{id}/edit-profile
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
- Jika *authorization credential* tidak valid, maka akan dikembalikan pesan kesalahan (403).
- Sebaliknya (200), ketika *authorization credential* valid dan operasi modifikasi berjalan dengan baik, maka akan dikembalikan detil informasi *profile* yang baru.

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* valid dengan modifikasi dilakukan pada atribut *address* dan *phone*.
```
HTTP 200 OK
Allow: OPTIONS, PATCH, GET
Content-Type: application/json
Vary: Accept

{
    "id": 1,
    "name": "Jennie Baik Sekali",
    "birth": "2000-09-24",
    "email": "jenniebaik@gmail.com",
    "address": "Tebing Tinggi, Sumatera Utara",
    "phone_number": "081233127865"
}
```
