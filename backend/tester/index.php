<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product API Tester - Modul 11B</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <!-- Header Section -->
    <header class="app-header">
        <div class="header-title">
            <h1>Product API Tester</h1>
            <p>Pengujian Endpoint API Berbasis JSON dan HTTP Method (Tanpa AJAX)</p>
        </div>
        <div class="header-meta">
            <span class="tag-badge">Modul 11B</span>
            <span class="tag-badge">PHP + MySQL</span>
        </div>
    </header>

    <!-- Main Grid -->
    <div class="grid-container">

        <!-- 1. GET ENDPOINTS CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Data Produk</h2>
            </div>

            <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 14px;">
                Lihat data yang dikembalikan backend dalam format JSON:
            </p>

            <div class="quick-links">
                <a class="btn btn-outline" href="../api/tasks/read.php" target="_blank">
                    Semua Produk
                </a>
                <a class="btn btn-outline" href="../api/hello.php" target="_blank">
                    Hello API
                </a>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 16px 0;">

            <label class="form-label" for="detail-id">Detail Produk berdasarkan ID:</label>
            <form class="inline-form" action="../api/tasks/detail.php" method="GET" target="_blank">
                <input class="form-input" type="number" id="detail-id" name="id" value="1" placeholder="ID" min="1" required>
                <button class="btn btn-primary" type="submit">Cek Detail</button>
            </form>
        </section>

        <!-- 2. CREATE PRODUCT CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Tambah Produk</h2>
            </div>

            <form action="../api/tasks/create.php" method="POST" target="_blank">
                <div class="form-group">
                    <label class="form-label" for="create-title">Nama Produk <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" id="create-title" name="title" placeholder="Contoh: Laptop ASUS ROG" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-category">Kategori</label>
                    <select class="form-select" id="create-category" name="category">
                        <option value="Elektronik">Elektronik</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Furniture">Furniture</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-price">Harga (Rp)</label>
                    <input class="form-input" type="number" id="create-price" name="price" placeholder="Contoh: 15000000" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-stock">Stok</label>
                    <input class="form-input" type="number" id="create-stock" name="stock" placeholder="Contoh: 10" required>
                </div>

                <button class="btn btn-primary btn-block" type="submit">
                    Tambah Produk
                </button>
            </form>
        </section>

        <!-- 3. UPDATE PRODUCT CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Update Produk</h2>
            </div>

            <form action="../api/tasks/update.php" method="POST" target="_blank">
                <div class="form-group">
                    <label class="form-label" for="update-id">ID Produk Target <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" type="number" id="update-id" name="id" placeholder="ID produk yang akan diubah" min="1" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="update-title">Nama Baru <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" id="update-title" name="title" placeholder="Nama produk baru..." required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="update-price">Harga Baru (Rp)</label>
                    <input class="form-input" type="number" id="update-price" name="price" placeholder="Harga baru...">
                </div>

                <div class="form-group">
                    <label class="form-label" for="update-stock">Stok Baru</label>
                    <input class="form-input" type="number" id="update-stock" name="stock" placeholder="Stok baru...">
                </div>

                <button class="btn btn-primary btn-block" type="submit">
                    Update Produk
                </button>
            </form>
        </section>

        <!-- 4. DELETE PRODUCT CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Hapus Produk</h2>
            </div>

            <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 14px;">
                Hapus data produk dari database berdasarkan ID.
            </p>

            <form action="../api/tasks/delete.php" method="POST" target="_blank">
                <div class="form-group">
                    <label class="form-label" for="delete-id">ID Produk <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" type="number" id="delete-id" name="id" placeholder="Masukkan ID yang akan dihapus" min="1" required>
                </div>

                <button class="btn btn-danger btn-block" type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?');">
                    Hapus Produk
                </button>
            </form>
        </section>

    </div>

    <!-- Info Footer -->
    <footer class="info-box">
        <strong>Catatan Pengujian:</strong> Setiap form melakukan submit langsung ke endpoint server dengan <code>target="_blank"</code> untuk menampilkan output JSON dan status code di tab baru.
    </footer>

</div>
</body>
</html>
