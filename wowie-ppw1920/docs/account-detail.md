# Profile Detail API

Fitur ini digunakan untuk melihat detil informasi profile dari pengguna (user).
**URI Pattern**:
```
GET /customers/{id}/profile-data
```
**Request Requirements**:
Setiap *request* harus menggunakan credential authentication dan sebuah parameter (*user id*) dari profile yang ingin didapatkan detil informasinya.
Berikut ini adalah contoh sebuah *request* yang valid:
```
GET http://localhost/customers/1/profile-data
Accept-Encoding: gzip,deflate
Authorization: Bearer Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF
Host: localhost
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.1.1 (java 1.5)

```

**Response**:
*Response* diberikan dalam format JSON dengan ketentuan sebagai berikut:
- Jika *authorization credential* tidak valid, maka akan dikembalikan pesan kesalahan (403). Sebaliknya (200), ketika *authorization token* valid maka:
    - jika *authorization credential* dan parameter *user id* merupakan satu user yang sama, maka informasi yang akan dikembalikan antara lain *name*, *femail*, *birth date*, *address*, dan *phone*
    - sebaliknya, jika *authorization token* dan parameter *user id* bukan berasal dari satu user, maka informasi yang akan dikembalikan adalah 

Berikut ini adalah contoh *response* yang diberikan ketika *authorization token* dan parameter *user id* terdaftar pada database.
```
HTTP 200 OK
Allow: GET, OPTIONS
Content-Type: application/json
Vary: Accept

{
    "name": "Jennie Simatupang",
    "birth": "2000-09-24",
    "email": "jenniebaik@gmail.com",
    "address": "Tebing Tinggi, Sumatera Utara",
    "phone_number": "081233127865"
}

```
