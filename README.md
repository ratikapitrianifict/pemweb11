# Web Programming 1 - Lab Project
## Fullstack Architecture: Backend (JSON API & MySQL) & Frontend (Tailwind CSS Dashboard)

Repositori ini berisi integrasi tugas praktikum **Web Programming 1** yang telah dipisahkan secara modular ke dalam arsitektur **Backend** (Modul 11B - API Fundamentals) dan **Frontend** (Modul 11D - Tailwind CSS Fundamentals), dilengkapi portal navigasi terpadu.

---

### Struktur Direktori Proyek

```text
task-api-lab/
│
├── backend/                               # MODUL 11B: API Fundamentals
│   ├── api/
│   │   ├── hello.php                      # Endpoint status API (GET)
│   │   └── tasks/
│   │       ├── read.php                   # Endpoint GET seluruh task
│   │       ├── detail.php                 # Endpoint GET detail task (?id=)
│   │       ├── create.php                 # Endpoint POST buat task baru
│   │       ├── update.php                 # Endpoint POST perbarui task
│   │       └── delete.php                 # Endpoint POST hapus task
│   ├── config/
│   │   ├── koneksi.php                    # Inisialisasi koneksi MySQLi (utf8mb4)
│   │   └── response.php                   # Helper modular sendJson() & HTTP status
│   ├── tester/
│   │   ├── index.php                      # Form pengujian API (clean UI, tanpa emoji)
│   │   └── style.css                      # Stylesheet terpisah form tester
│   └── database.sql                       # Skema database api_lab & tabel tasks
│
├── frontend/                              # MODUL 11D: Tailwind CSS Fundamentals
│   └── index.html                         # Tailwind Product Dashboard responsif
│
├── database.sql                           # Salinan skema database root
├── index.php                              # Portal landing page navigasi utama
├── README.md                              # Dokumentasi lengkap proyek
└── .gitignore                             # Berkas pengecualian Git
```

---

### Output Praktik

#### 1. Backend: API Endpoints & Request-Response Contract (Modul 11B)
Seluruh endpoint di sisi backend menggunakan kontrak JSON murni dengan status code HTTP standar:

| Endpoint | Method | Parameter Input | Status Code | Keterangan Response |
| :--- | :---: | :--- | :---: | :--- |
| `/backend/api/hello.php` | `GET` | - | `200 OK` | Info status & versi API |
| `/backend/api/tasks/read.php` | `GET` | - | `200 OK` | Array seluruh record task |
| `/backend/api/tasks/detail.php` | `GET` | Query `id` | `200 OK` | Detail task spesifik sesuai ID |
| `/backend/api/tasks/create.php` | `POST` | `title`, `description`, `status` | `201 Created` | ID task baru yang berhasil dibuat |
| `/backend/api/tasks/update.php` | `POST` | `id`, `title`, `description`, `status` | `200 OK` | Pesan konfirmasi pembaruan |
| `/backend/api/tasks/delete.php` | `POST` | `id` | `200 OK` | Pesan konfirmasi penghapusan |

Setiap endpoint menangani error secara terstruktur:
* `400 Bad Request`: Field input wajib tidak diisi, ID tidak valid, atau nilai enum status tidak sesuai.
* `404 Not Found`: Task yang diminta tidak ditemukan di database.
* `405 Method Not Allowed`: Request menggunakan HTTP method yang tidak diizinkan.
* `500 Internal Server Error`: Terjadi kegagalan pada operasi query database.

#### 2. Frontend: Tailwind CSS Product Dashboard & AJAX Client (Modul 11A + 11D)
Dashboard modern berbasis utility-first Tailwind CSS (via Tailwind Play CDN) yang telah terhubung penuh ke Backend API menggunakan AJAX (`fetch()`):
* **Integrasi AJAX Dinamis (`frontend/app.js`)**:
  * Mengambil data secara asynchronous dari `/backend/api/tasks/read.php` untuk merender statistik, kartu produk, dan tabel inventaris tanpa page reload.
  * Form penambahan data mengirim request `POST` via AJAX ke `/backend/api/tasks/create.php` dan memperbarui tampilan secara real-time.
  * Aksi pengubahan status (`update.php`) dan penghapusan data (`delete.php`) dieksekusi secara instan via `fetch()`.
  * Modal detail menampilkan data spesifik dari `/backend/api/tasks/detail.php?id=...`.
* **Navbar**: Navigasi responsif dengan brand dan menu links.
* **Header & Action**: Judul dashboard, deskripsi, dan tombol navigasi form.
* **Grid Statistik**: Kartu ringkasan (*Total*, *Done*, *Pending*) yang ter-update otomatis.
* **Katalog Produk (Cards)**: Grid kartu produk dinamis dengan ID, judul, deskripsi, badge status, dan tombol aksi.
* **Tabel Inventaris**: Tabel data dengan aksi detail dan hapus per baris.
* **Form Tambah Produk**: Form input dengan state interaktif (`focus:ring-2`, `focus:border-blue-500`) dan notifikasi alert.

---

### Improvement Backend

1. **Helper JSON Terpusat (`backend/config/response.php`)**:
   * Fungsi `sendJson()` mengatur header `Content-Type: application/json; charset=utf-8` dan status code HTTP dinamis, menjamin konsistensi payload (`success`, `message`, `data`).
2. **Keamanan Prepared Statements**:
   * Menghindari serangan *SQL Injection* pada seluruh endpoint manipulasi data (`detail.php`, `create.php`, `update.php`, `delete.php`) menggunakan MySQLi prepared statements (`prepare()` dan `bind_param()`).
3. **HTTP Method Guard**:
   * Memvalidasi metode request pada setiap file PHP untuk mencegah bypass metode HTTP (`405 Method Not Allowed`).
4. **Validasi Input & Pre-checking**:
   * Sanitasi data dengan `trim()`, validasi status whitelist (`pending`, `done`), serta pengecekan keberadaan record sebelum eksekusi update/delete (`404 Not Found`).

---

### Improvement Frontend

1. **Pemisahan Modular Backend & Frontend**:
   * Folder terpisah memisahkan logika server-side (PHP/MySQL) dari presentasi client-side (HTML/Tailwind), meningkatkan skalabilitas proyek.
2. **UI Tester Bersih & Minimalis**:
   * Halaman tester bebas dari emoji dan teks teknis yang berlebihan, menggunakan aksen warna tombol `#3b82f6` yang konsisten.
3. **Pemisahan Stylesheet**:
   * CSS pada halaman tester dipisahkan ke [backend/tester/style.css](backend/tester/style.css) untuk kerapian kode.
4. **Pengujian Non-Blocking (`target="_blank"`)**:
   * Form pengujian membuka respon JSON di tab baru sehingga halaman tester tetap dapat digunakan secara terus-menerus.
5. **Portal Landing Page (`index.php`)**:
   * Dilengkapi halaman navigasi terpadu dengan desain Tailwind CSS untuk memudahkan akses ke dashboard frontend maupun tester backend.

---

### Panduan Menjalankan

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/ratikapitrianifict/pemweb11.git
   ```
2. **Setup Database**:
   * Pastikan Apache & MySQL aktif di Laragon.
   * Import file `backend/database.sql` ke database `api_lab`.
3. **Akses Aplikasi**:
   * **Portal Utama**: `http://localhost/task-api-lab/`
   * **Frontend Dashboard**: `http://localhost/task-api-lab/frontend/`
   * **Backend API Tester**: `http://localhost/task-api-lab/backend/tester/`
   * **Endpoint API Tasks**: `http://localhost/task-api-lab/backend/api/tasks/read.php`
