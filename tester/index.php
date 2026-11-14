<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task API Tester - Modul 11B</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <!-- Header Section -->
    <header class="app-header">
        <div class="header-title">
            <h1>Task API Tester</h1>
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
                <h2 class="card-title">Data Task</h2>
            </div>

            <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 14px;">
                Lihat data yang dikembalikan backend dalam format JSON:
            </p>

            <div class="quick-links">
                <a class="btn btn-outline" href="../api/tasks/read.php" target="_blank">
                    Semua Task
                </a>
                <a class="btn btn-outline" href="../api/hello.php" target="_blank">
                    Hello API
                </a>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 16px 0;">

            <label class="form-label" for="detail-id">Detail Task berdasarkan ID:</label>
            <form class="inline-form" action="../api/tasks/detail.php" method="GET" target="_blank">
                <input class="form-input" type="number" id="detail-id" name="id" value="1" placeholder="ID" min="1" required>
                <button class="btn btn-primary" type="submit">Cek Detail</button>
            </form>
        </section>

        <!-- 2. CREATE TASK CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Tambah Task</h2>
            </div>

            <form action="../api/tasks/create.php" method="POST" target="_blank">
                <div class="form-group">
                    <label class="form-label" for="create-title">Judul Task <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" id="create-title" name="title" placeholder="Contoh: Belajar REST API" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-desc">Deskripsi</label>
                    <textarea class="form-textarea" id="create-desc" name="description" placeholder="Deskripsi tugas..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-status">Status</label>
                    <select class="form-select" id="create-status" name="status">
                        <option value="pending">pending</option>
                        <option value="done">done</option>
                    </select>
                </div>

                <button class="btn btn-primary btn-block" type="submit">
                    Tambah Task
                </button>
            </form>
        </section>

        <!-- 3. UPDATE TASK CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Update Task</h2>
            </div>

            <form action="../api/tasks/update.php" method="POST" target="_blank">
                <div class="form-group">
                    <label class="form-label" for="update-id">ID Task <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" type="number" id="update-id" name="id" placeholder="ID task yang akan diubah" min="1" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="update-title">Judul Baru <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" id="update-title" name="title" placeholder="Judul baru..." required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="update-desc">Deskripsi Baru</label>
                    <textarea class="form-textarea" id="update-desc" name="description" placeholder="Deskripsi baru..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="update-status">Status Baru</label>
                    <select class="form-select" id="update-status" name="status">
                        <option value="pending">pending</option>
                        <option value="done">done</option>
                    </select>
                </div>

                <button class="btn btn-primary btn-block" type="submit">
                    Update Task
                </button>
            </form>
        </section>

        <!-- 4. DELETE TASK CARD -->
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Hapus Task</h2>
            </div>

            <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 14px;">
                Hapus data task dari database berdasarkan ID.
            </p>

            <form action="../api/tasks/delete.php" method="POST" target="_blank">
                <div class="form-group">
                    <label class="form-label" for="delete-id">ID Task <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" type="number" id="delete-id" name="id" placeholder="Masukkan ID yang akan dihapus" min="1" required>
                </div>

                <button class="btn btn-danger btn-block" type="submit" onclick="return confirm('Yakin ingin menghapus task ini?');">
                    Hapus Task
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

