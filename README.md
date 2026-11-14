# Web Programming 1 - Lab Project
## Fullstack Architecture: Backend (JSON API & MySQL) & Frontend (Tailwind CSS Product Dashboard)

Repositori ini berisi integrasi tugas praktikum **Web Programming 1** yang telah dipisahkan secara modular ke dalam arsitektur **Backend** (Modul 11B - API Fundamentals) dan **Frontend** (Modul 11D - Tailwind CSS Fundamentals: Responsive Product Dashboard).

---

### Struktur Direktori Proyek

```text
task-api-lab/
│
├── backend/                               # MODUL 11B: API Fundamentals
│   ├── api/
│   │   ├── hello.php                      # Endpoint status API (GET)
│   │   └── tasks/
│   │       ├── read.php                   # Endpoint GET seluruh produk
│   │       ├── detail.php                 # Endpoint GET detail produk (?id=)
│   │       ├── create.php                 # Endpoint POST buat produk baru
│   │       ├── update.php                 # Endpoint POST perbarui produk
│   │       └── delete.php                 # Endpoint POST hapus produk
│   ├── config/
│   │   ├── koneksi.php                    # Inisialisasi koneksi MySQLi (utf8mb4)
│   │   └── response.php                   # Helper modular sendJson() & HTTP status
│   ├── tester/
│   │   ├── index.php                      # Form pengujian API (clean UI, tanpa emoji)
│   │   └── style.css                      # Stylesheet terpisah form tester
│   └── database.sql                       # Skema database api_lab & data produk
│
├── frontend/                              # MODUL 11D: Tailwind CSS Product Dashboard
│   ├── index.html                         # Tailwind Product Dashboard (Modul 11D)
│   └── app.js                             # AJAX Client (fetch) terhubung ke API backend
│
├── database.sql                           # Salinan skema database root
├── index.php                              # Portal landing page navigasi utama
├── README.md                              # Dokumentasi lengkap proyek
└── .gitignore                             # Berkas pengecualian Git
```

---

### Data Produk (Modul 11D)

Proyek ini menggunakan data nyata katalog produk sesuai Modul 11D (bukan tugas/tugas kuliah umum):

| ID | Nama Produk | Kategori | Harga (Rp) | Stok | Deskripsi |
| :-: | :--- | :--- | :--- | :-: | :--- |
| 1 | Mechanical Keyboard | Elektronik | Rp550.000 | 8 | Keyboard mekanikal switch biru RGB responsif |
| 2 | Wireless Mouse | Elektronik | Rp180.000 | 12 | Mouse wireless 2.4GHz hemat daya |
| 3 | Laptop Stand | Aksesoris | Rp250.000 | 4 | Stand laptop aluminium kokoh |
| 4 | Gaming Laptop ROG | Elektronik | Rp18.500.000 | 3 | Laptop gaming Ryzen 9 RTX |
| 5 | MacBook Air M2 | Elektronik | Rp16.200.000 | 5 | Layar Liquid Retina M2 Midnight |
| 6 | Monitor UltraWide 29" | Elektronik | Rp3.200.000 | 6 | Monitor IPS 75Hz HDR FreeSync |

---

### Output Praktik & Fitur

#### 1. Frontend: Tailwind CSS Product Dashboard (Modul 11D)
* **Navbar Utilities (Checkpoint 8)**: Navigasi responsif dengan brand `ProductLab` dan tautan menu.
* **Flexbox Dashboard Header (Checkpoint 4 & 7)**: Judul dashboard dan tombol aksi `+ Tambah Product`.
* **Grid Statistik (Checkpoint 5)**: Total Product, Stock Ready, dan Categories yang terhitung otomatis.
* **Product Cards (Checkpoint 6)**: Tampilan kartu produk modern dengan gambar cover, kategori, nama, harga (Rupiah), dan tombol `Detail Product`.
* **Responsive Table (Checkpoint 9)**: Tabel inventaris terbungkus `overflow-x-auto` menampilkan kolom Product, Category, Price, Stock, dan Hapus.
* **Add Product Form (Checkpoint 10)**: Formulir penambahan produk dengan field Product Name, Category dropdown, Price, dan Stock.
* **Integrasi AJAX Dinamis (`frontend/app.js`)**: Memuat data, menambah data, dan menghapus data secara asinkron tanpa *full page reload*.

#### 2. Backend: REST API Endpoints (Modul 11B)
* `GET /backend/api/hello.php`: Cek status server API.
* `GET /backend/api/tasks/read.php`: Mengembalikan array seluruh katalog produk dari database.
* `GET /backend/api/tasks/detail.php?id={id}`: Mengembalikan data spesifik satu produk.
* `POST /backend/api/tasks/create.php`: Menyimpan produk baru (status `201 Created`).
* `POST /backend/api/tasks/update.php`: Memperbarui data produk.
* `POST /backend/api/tasks/delete.php`: Menghapus produk dari database.

---

### Panduan Menjalankan

1. **Setup Database**:
   * Pastikan Apache & MySQL aktif di Laragon.
   * Import file `backend/database.sql` ke database `api_lab`.
2. **Akses Aplikasi**:
   * **Frontend Dashboard**: `http://localhost/task-api-lab/frontend/`
   * **Portal Utama**: `http://localhost/task-api-lab/`
   * **Backend API Tester**: `http://localhost/task-api-lab/backend/tester/`
