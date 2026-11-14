# Web Programming 1 - Lab Project
## Fullstack Architecture: Backend (JSON API & MySQL) & Frontend (Tailwind CSS + Bootstrap 5 Product Dashboard)

Repositori ini berisi integrasi tugas praktikum **Web Programming 1** yang telah dipisahkan secara modular ke dalam arsitektur **Backend** (Modul 11B - API Fundamentals) dan **Frontend** dengan 2 pilihan implementasi: **Tailwind CSS** (Modul 11D - Responsive Product Dashboard) serta **Bootstrap 5**.

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
├── frontend/                              # MODUL 11D & FRONTEND IMPLEMENTATIONS
│   ├── index.php                          # Tailwind CSS Product Dashboard (Modul 11D)
│   ├── bootstrap.php                      # Bootstrap 5 Product Dashboard
│   └── app.js                             # AJAX Client (fetch) terhubung ke API backend
│
├── database.sql                           # Salinan skema database root
├── index.php                              # Portal landing page navigasi utama
├── README.md                              # Dokumentasi lengkap proyek
└── .gitignore                             # Berkas pengecualian Git
```

---

### Data Produk (Modul 11D)

Proyek ini menggunakan data nyata katalog produk sesuai Modul 11D (laptop, mouse, keyboard, monitor, dll.):

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

#### 1. Frontend: Tailwind CSS Product Dashboard (`frontend/index.php`) - Modul 11D
* **Navbar Utilities (Checkpoint 8)**: Navigasi responsif dengan brand `ProductLab` dan tab Katalog / Inventaris / Tambah Produk.
* **Flexbox Dashboard Header (Checkpoint 4 & 7)**: Judul dashboard dan tombol aksi `+ Tambah Produk Baru`.
* **Grid Statistik (Checkpoint 5)**: Total Produk, Total Stok Siap, dan Kategori terhitung otomatis.
* **Product Cards (Checkpoint 6)**: Tampilan kartu produk modern dengan gambar cover produk nyata, kategori badge, format Rupiah, dan tombol `Detail Produk`.
* **Responsive Table (Checkpoint 9)**: Tabel inventaris terbungkus `overflow-x-auto` menampilkan kolom Product, Category, Price, Stock, dan Aksi Hapus.
* **Add Product Form (Checkpoint 10)**: Formulir penambahan produk dengan input Name, Category, Price, Stock, Image URL, dan Deskripsi.
* **Integrasi AJAX Dinamis (`frontend/app.js`)**: Memuat data katalog, filter kategori, pencarian inventaris, tambah produk, dan hapus data via API tanpa reload halaman.

#### 2. Frontend: Bootstrap 5 Product Dashboard (`frontend/bootstrap.php`)
* **Bootstrap 5 UI Components**: Grid system (`row`, `col-md-*`), Cards, Modals, Navbar, Badges, Tables, dan Alert dinamis.
* **Tokopedia Clean Theme**: Aksen hijau Tokopedia (`#03AC0E`), kartu putih clean berbayang halus, dan tanpa emoji.
* **Fitur Terintegrasi AJAX**:
  - Filter kategori instan (Semua, Elektronik, Aksesoris).
  - Modal detail produk interaktif (Bootstrap Modal API).
  - Form tambah produk langsung kirim via `fetch()`.
  - Hapus produk langsung dengan notifikasi Toast/Alert Bootstrap.

#### 3. Backend: REST API Endpoints (`backend/api/`) - Modul 11B
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
   * **Portal Navigasi Utama**: `http://localhost/task-api-lab/`
   * **Frontend Versi Tailwind CSS**: `http://localhost/task-api-lab/frontend/index.php`
   * **Frontend Versi Bootstrap 5**: `http://localhost/task-api-lab/frontend/bootstrap.php`
   * **Backend API Tester**: `http://localhost/task-api-lab/backend/tester/index.php`
