# Add Address API

Fitur ini digunakan untuk menambahkan alamat dengan *id* tertentu yang disertakan dalam bentuk parameter.

**URI Pattern**:
```
GET /customers/{id}/add-address
```

**Request Requirements**:

Setiap *request* harus menyertakan *authorization credential* dan *id* dari profile yang ingin ditambahkan alamatnya.

Berikut ini adalah contoh sebuah *request* yang valid:
```
GET http://localhost/customers/{id}/add-addres
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Content-Type: application/json
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

```

**Response**:

*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization credential* tidak merujuk pada user yang terdaftar maka akan dikembalikan pesan kesalahan (403).
- Sebaliknya (200), data alamat dari user akan ditambahkan.

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* berasal dari *account* yang terlibat pada transaksi.
```


```
