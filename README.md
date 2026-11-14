# Web Programming 1 - Modul 11B
## API Fundamentals: JSON Endpoint dengan PHP + MySQL

Repositori ini berisi implementasi praktikum **Web Programming 1 (Modul 11B)** mengenai pembuatan JSON Endpoint / API sederhana menggunakan PHP Native dan MySQLi, disertai antarmuka pengujian (HTML Form Tester) yang terpisah.

---

### Struktur Direktori Proyek

```text
task-api-lab/
├── database.sql               # Skema database api_lab dan tabel tasks
├── config/
│   ├── koneksi.php            # Konfigurasi koneksi MySQLi (utf8mb4)
│   └── response.php           # Helper standarisasi JSON response & HTTP status
├── api/
│   ├── hello.php              # Endpoint pengetesan status API
│   └── tasks/
│       ├── read.php           # Endpoint GET semua task
│       ├── detail.php         # Endpoint GET detail task berdasarkan ID
│       ├── create.php         # Endpoint POST pembuatan task baru
│       ├── update.php         # Endpoint POST pembaruan task
│       └── delete.php         # Endpoint POST penghapusan task
├── tester/
│   ├── index.php              # Halaman form pengujian API (tanpa AJAX)
│   └── style.css              # Stylesheet terpisah (clean & responsif)
└── README.md
```

---

### Output Praktik

Praktikum ini menghasilkan serangkaian endpoint API dengan HTTP Request-Response contract yang terstandarisasi:

| Endpoint | Method | Input / Parameter | Status Code | Keterangan Response |
| :--- | :---: | :--- | :---: | :--- |
| `/api/hello.php` | `GET` | - | `200 OK` | Informasi status API |
| `/api/tasks/read.php` | `GET` | - | `200 OK` | Array seluruh data task |
| `/api/tasks/detail.php` | `GET` | Query `id` | `200 OK` | Objek detail task sesuai ID |
| `/api/tasks/create.php` | `POST` | `title`, `description`, `status` | `201 Created` | ID task baru yang dibuat |
| `/api/tasks/update.php` | `POST` | `id`, `title`, `description`, `status` | `200 OK` | Konfirmasi task berhasil diperbarui |
| `/api/tasks/delete.php` | `POST` | `id` | `200 OK` | Konfirmasi task berhasil dihapus |

Setiap endpoint juga mengembalikan response error terstruktur:
* `400 Bad Request`: Input tidak valid (misal: ID tidak valid, judul kosong, status bukan `pending`/`done`).
* `404 Not Found`: Data task yang dicari/diupdate/dihapus tidak ditemukan di database.
* `405 Method Not Allowed`: Pemanggilan endpoint menggunakan HTTP method yang tidak diizinkan.
* `500 Internal Server Error`: Kegagalan eksekusi query pada database.

---

### Improvement Backend

1. **Modular JSON Response Helper (`config/response.php`)**:
   * Membungkus fungsi `sendJson($statusCode, $success, $message, $data)` untuk memastikan seluruh endpoint mengirimkan struktur JSON yang seragam (`success`, `message`, `data`).
   * Mengatur header `Content-Type: application/json; charset=utf-8` dan HTTP status code secara otomatis serta menghentikan script (`exit`).
2. **Prepared Statements (MySQLi)**:
   * Seluruh query parameter pada operasi `detail.php`, `create.php`, `update.php`, dan `delete.php` menggunakan `prepare()` dan `bind_param()` untuk mencegah celah keamanan *SQL Injection*.
3. **HTTP Method Guarding**:
   * Setiap endpoint memeriksa `$_SERVER["REQUEST_METHOD"]` dan menolak method yang tidak sesuai dengan mengembalikan status `405 Method Not Allowed`.
4. **Validasi Input & Whitelist**:
   * Memvalidasi input wajib, sanitasi string dengan `trim()`, dan validasi status menggunakan whitelist (`['pending', 'done']`).
5. **Verifikasi Keberadaan Data (Pre-check)**:
   * Pada endpoint `update.php` dan `delete.php`, server memeriksa terlebih dahulu apakah ID task ada sebelum menjalankan query modifikasi, mengembalikan `404 Not Found` jika tidak ada.

---

### Improvement Frontend (Tester)

1. **Pemisahan Kode & Stylesheet**:
   * CSS dipisahkan secara modular ke file [tester/style.css](tester/style.css), menjaga file HTML tetap bersih, terstruktur, dan mudah dipelihara.
2. **Desain Clean & Minimalis**:
   * Menghilangkan emoji dan teks teknis yang berlebihan pada UI untuk menciptakan antarmuka yang profesional dan rapi.
3. **Konsistensi Warna & Elemen Interaktif**:
   * Menstandarisasi tombol aksi utama (seperti *Cek Detail*, *Tambah Task*, dan *Update Task*) menggunakan warna `#3b82f6` dengan efek hover `#2563eb`.
4. **Layout Responsif Berbasis Kartu**:
   * Menggunakan CSS Grid dengan pengelompokan operasi kartu (*Read*, *Tambah*, *Update*, *Hapus*) yang responsif di berbagai ukuran layar.
5. **Testing Tab Terpisah (`target="_blank"`)**:
   * Form pengujian langsung mengirim request ke endpoint dan membuka response JSON di tab baru tanpa me-reload atau meninggalkan halaman tester.

---

### Panduan Instalasi & Menjalankan

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/ratikapitrianifict/pemweb11.git
   ```
2. **Import Database**:
   * Buka phpMyAdmin di Laragon.
   * Import file `database.sql` atau eksekusi query pembuatan database `api_lab` dan tabel `tasks`.
3. **Akses Pengujian**:
   * Buka browser dan arahkan ke: `http://localhost/task-api-lab/tester/`
