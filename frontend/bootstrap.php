<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProductLab - Bootstrap 5 Product Dashboard</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --tokopedia-green: #03AC0E;
            --tokopedia-green-hover: #02960c;
            --tokopedia-green-light: #E8F5E9;
        }
        body {
            background-color: #F7F8FA;
            color: #212121;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .text-tokopedia { color: var(--tokopedia-green) !important; }
        .bg-tokopedia { background-color: var(--tokopedia-green) !important; color: #fff; }
        .bg-tokopedia-light { background-color: var(--tokopedia-green-light) !important; color: var(--tokopedia-green) !important; }
        .btn-tokopedia {
            background-color: var(--tokopedia-green);
            color: #ffffff;
            border: none;
            font-weight: 600;
        }
        .btn-tokopedia:hover {
            background-color: var(--tokopedia-green-hover);
            color: #ffffff;
        }
        .nav-pills .nav-link.active {
            background-color: var(--tokopedia-green) !important;
            font-weight: 600;
        }
        .nav-pills .nav-link {
            color: #495057;
            font-weight: 500;
        }
        .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            border-radius: 16px;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            border-color: var(--tokopedia-green) !important;
        }
        .product-img-wrapper {
            height: 200px;
            background-color: #f8f9fa;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }
        .product-img-wrapper img {
            max-height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body class="min-h-screen d-flex flex-column justify-content-between">

    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-3">
        <div class="container-xl">
            <a class="navbar-brand fw-bold text-tokopedia fs-4 d-flex align-items-center" href="#">
                ProductLab
                <span class="badge bg-secondary-subtle text-secondary ms-2 fs-6 fw-normal">Bootstrap 5</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="#" onclick="bsSwitchTab('products'); return false;">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#" onclick="bsSwitchTab('inventory'); return false;">Inventaris</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#" onclick="bsSwitchTab('form'); return false;">Tambah Produk</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="index.php" class="btn btn-outline-dark btn-sm rounded-3 px-3">
                        Buka Versi Tailwind
                    </a>
                    <a href="../backend/tester/index.php" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                        Backend Tester
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="container-xl py-4 flex-grow-1">

        <!-- Notification Alert -->
        <div id="bsAlertBox" class="alert d-none rounded-3 shadow-sm mb-4" role="alert"></div>

        <!-- Header Dashboard -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Product Dashboard (Bootstrap)</h1>
                <p class="text-secondary small mb-0">Kelola katalog produk e-commerce dan tabel stok berbasis Bootstrap 5 + AJAX REST API.</p>
            </div>
            <button onclick="bsSwitchTab('form')" class="btn btn-tokopedia rounded-3 px-4 py-2 shadow-sm">
                + Tambah Produk Baru
            </button>
        </div>

        <!-- Statistik Ringkasan (Bootstrap Row & Col) -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary small text-uppercase fw-semibold">Total Produk</span>
                            <h2 class="h3 fw-bold text-dark mt-1 mb-0" id="bsTotalProduct">-</h2>
                        </div>
                        <span class="badge bg-light text-secondary p-3 rounded-3 fw-bold">SKU</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary small text-uppercase fw-semibold">Total Stok Siap</span>
                            <h2 class="h3 fw-bold text-tokopedia mt-1 mb-0" id="bsTotalStock">-</h2>
                        </div>
                        <span class="badge bg-tokopedia-light p-3 rounded-3 fw-bold">QTY</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary small text-uppercase fw-semibold">Kategori Aktif</span>
                            <h2 class="h3 fw-bold text-dark mt-1 mb-0" id="bsTotalCategories">-</h2>
                        </div>
                        <span class="badge bg-light text-secondary p-3 rounded-3 fw-bold">CAT</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Switcher Nav-Pills (Memisahkan Produk, Inventaris, dan Form) -->
        <div class="card border-0 shadow-sm rounded-4 p-2 bg-white mb-4">
            <ul class="nav nav-pills gap-1">
                <li class="nav-item">
                    <button class="nav-link active rounded-3 px-4 py-2" id="bsBtnTabProducts" onclick="bsSwitchTab('products')">
                        Katalog Produk (E-Commerce)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link rounded-3 px-4 py-2" id="bsBtnTabInventory" onclick="bsSwitchTab('inventory')">
                        Tabel Inventaris &amp; Stok
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link rounded-3 px-4 py-2" id="bsBtnTabForm" onclick="bsSwitchTab('form')">
                        Form Tambah Produk
                    </button>
                </li>
            </ul>
        </div>

        <!-- TAB 1: KATALOG PRODUK -->
        <div id="bsTabProducts">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Daftar Produk</h5>
                <button onclick="bsLoadProducts()" class="btn btn-sm btn-link text-tokopedia text-decoration-none">
                    Refresh Data
                </button>
            </div>
            <div class="row g-4" id="bsProductsGrid">
                <!-- Cards dirender via AJAX -->
            </div>
        </div>

        <!-- TAB 2: INVENTARIS -->
        <div id="bsTabInventory" class="d-none">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom">
                    <div>
                        <h5 class="fw-bold mb-1">Inventaris Stok Produk</h5>
                        <p class="text-secondary small mb-0">Kelola dan pantau stok unit secara terpusat.</p>
                    </div>
                    <div style="max-width: 280px; width: 100%;">
                        <input type="text" id="bsSearchInput" oninput="bsSearchProducts(this.value)" class="form-control form-control-sm rounded-3" placeholder="Cari nama produk...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bsInventoryTableBody">
                            <!-- Rows dirender via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 3: FORM TAMBAH PRODUK -->
        <div id="bsTabForm" class="d-none">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5 bg-white mx-auto" style="max-width: 680px;">
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="fw-bold mb-1">Tambah Produk Baru</h5>
                    <p class="text-secondary small mb-0">Data akan tersimpan ke database MySQL via REST API AJAX (fetch).</p>
                </div>
                <form id="bsAddProductForm">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">NAMA PRODUK <span class="text-danger">*</span></label>
                        <input type="text" id="bsInputName" class="form-control rounded-3" placeholder="Contoh: Laptop ASUS ROG Strix" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold text-secondary">KATEGORI <span class="text-danger">*</span></label>
                            <select id="bsInputCategory" class="form-select rounded-3">
                                <option value="Elektronik">Elektronik</option>
                                <option value="Aksesoris">Aksesoris</option>
                                <option value="Furniture">Furniture</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold text-secondary">HARGA SATUAN (RP) <span class="text-danger">*</span></label>
                            <input type="number" id="bsInputPrice" class="form-control rounded-3" placeholder="18500000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">JUMLAH STOK <span class="text-danger">*</span></label>
                        <input type="number" id="bsInputStock" class="form-control rounded-3" placeholder="10" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">URL GAMBAR (OPSIONAL)</label>
                        <input type="url" id="bsInputImage" class="form-control rounded-3" placeholder="https://images.unsplash.com/...">
                        <div class="form-text small">Kosongkan untuk menggunakan gambar standar kategori secara otomatis.</div>
                    </div>
                    <button type="submit" class="btn btn-tokopedia w-100 py-2 rounded-3 shadow-sm">
                        Simpan Produk
                    </button>
                </form>
            </div>
        </div>

    </main>

    <!-- Modal Detail Produk (Bootstrap 5 Modal) -->
    <div class="modal fade" id="bsDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="bsDetailModalBody">
                    <!-- Dynamic via AJAX -->
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center small text-secondary">
        <div class="container">
            ProductLab - Bootstrap 5 &amp; AJAX REST API (Module 11D Comparison)
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Script untuk Bootstrap -->
    <script>
        const API_URL = '../backend/api/tasks';
        let bsProducts = [];
        let bsModalInstance = null;

        document.addEventListener('DOMContentLoaded', () => {
            bsModalInstance = new bootstrap.Modal(document.getElementById('bsDetailModal'));
            bsLoadProducts();
        });

        function formatRupiah(num) {
            const val = Number(num) || 0;
            return 'Rp' + val.toLocaleString('id-ID');
        }

        function bsSwitchTab(tabId) {
            document.getElementById('bsTabProducts').classList.add('d-none');
            document.getElementById('bsTabInventory').classList.add('d-none');
            document.getElementById('bsTabForm').classList.add('d-none');

            document.getElementById('bsBtnTabProducts').classList.remove('active');
            document.getElementById('bsBtnTabInventory').classList.remove('active');
            document.getElementById('bsBtnTabForm').classList.remove('active');

            if (tabId === 'products') {
                document.getElementById('bsTabProducts').classList.remove('d-none');
                document.getElementById('bsBtnTabProducts').classList.add('active');
            } else if (tabId === 'inventory') {
                document.getElementById('bsTabInventory').classList.remove('d-none');
                document.getElementById('bsBtnTabInventory').classList.add('active');
            } else if (tabId === 'form') {
                document.getElementById('bsTabForm').classList.remove('d-none');
                document.getElementById('bsBtnTabForm').classList.add('active');
            }
        }

        async function bsLoadProducts() {
            try {
                const res = await fetch(`${API_URL}/read.php`);
                const result = await res.json();
                if (result.success && Array.isArray(result.data)) {
                    bsProducts = result.data;
                    bsRenderAll(bsProducts);
                }
            } catch (err) {
                console.error(err);
                bsShowAlert('Gagal mengambil data dari server.', 'danger');
            }
        }

        function bsRenderAll(products) {
            // Stats
            const totalCount = products.length;
            const totalStock = products.reduce((acc, p) => acc + (Number(p.stock) || 0), 0);
            const categories = new Set(products.map(p => p.category || 'Elektronik')).size;

            document.getElementById('bsTotalProduct').textContent = totalCount;
            document.getElementById('bsTotalStock').textContent = totalStock;
            document.getElementById('bsTotalCategories').textContent = categories;

            // Render Cards
            const grid = document.getElementById('bsProductsGrid');
            if (products.length === 0) {
                grid.innerHTML = '<div class="col-12 text-center py-5 text-secondary">Belum ada produk.</div>';
            } else {
                grid.innerHTML = products.map(p => {
                    const img = p.image || 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&auto=format&fit=crop&q=80';
                    return `
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 product-card border bg-white shadow-xs">
                                <div class="product-img-wrapper border-bottom">
                                    <img src="${escapeHtml(img)}" alt="${escapeHtml(p.title)}" loading="lazy">
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between p-3">
                                    <div>
                                        <span class="badge bg-tokopedia-light mb-2">${escapeHtml(p.category || 'Elektronik')}</span>
                                        <h6 class="card-title fw-bold text-dark text-truncate">${escapeHtml(p.title)}</h6>
                                        <p class="text-tokopedia fw-bold fs-5 mb-1">${formatRupiah(p.price)}</p>
                                        <div class="d-flex justify-content-between small text-secondary">
                                            <span>Stok: <strong>${p.stock}</strong></span>
                                            <span class="text-success fw-medium">Tersedia</span>
                                        </div>
                                    </div>
                                    <button onclick="bsShowDetail(${p.id})" class="btn btn-tokopedia btn-sm rounded-3 w-100 mt-3 py-2">
                                        Detail Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            // Render Table
            bsRenderTable(products);
        }

        function bsRenderTable(products) {
            const tbody = document.getElementById('bsInventoryTableBody');
            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-secondary">Data inventaris kosong.</td></tr>';
                return;
            }
            tbody.innerHTML = products.map(p => `
                <tr>
                    <td class="fw-bold">#${escapeHtml(p.id)}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="${escapeHtml(p.image || '')}" alt="" class="rounded-2" style="width: 36px; height: 36px; object-fit: cover;" onerror="this.style.display='none'">
                            <span class="fw-medium text-dark">${escapeHtml(p.title)}</span>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-secondary border">${escapeHtml(p.category || 'Elektronik')}</span></td>
                    <td class="fw-bold">${formatRupiah(p.price)}</td>
                    <td><span class="badge ${p.stock > 5 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'}">${p.stock} unit</span></td>
                    <td class="text-end">
                        <button onclick="bsShowDetail(${p.id})" class="btn btn-sm btn-link text-tokopedia text-decoration-none fw-semibold">Detail</button>
                        <button onclick="bsDeleteProduct(${p.id}, '${escapeHtml(p.title)}')" class="btn btn-sm btn-link text-danger text-decoration-none fw-semibold">Hapus</button>
                    </td>
                </tr>
            `).join('');
        }

        function bsSearchProducts(query) {
            const q = query.toLowerCase();
            const filtered = bsProducts.filter(p => (p.title || '').toLowerCase().includes(q) || (p.category || '').toLowerCase().includes(q));
            bsRenderTable(filtered);
        }

        // Add Product Form Submit
        document.getElementById('bsAddProductForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const title = document.getElementById('bsInputName').value.trim();
            const category = document.getElementById('bsInputCategory').value;
            const price = document.getElementById('bsInputPrice').value;
            const stock = document.getElementById('bsInputStock').value;
            let image = document.getElementById('bsInputImage').value.trim();

            if (!image) {
                const lower = title.toLowerCase();
                if (lower.includes('laptop') || lower.includes('macbook') || lower.includes('rog')) {
                    image = 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80';
                } else if (lower.includes('keyboard')) {
                    image = 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80';
                } else if (lower.includes('mouse')) {
                    image = 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80';
                } else {
                    image = 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&auto=format&fit=crop&q=80';
                }
            }

            const formData = new URLSearchParams();
            formData.append('title', title);
            formData.append('category', category);
            formData.append('price', price);
            formData.append('stock', stock);
            formData.append('image', image);
            formData.append('description', `Produk kategori ${category} dengan harga ${formatRupiah(price)}.`);
            formData.append('status', 'ready');

            try {
                const res = await fetch(`${API_URL}/create.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });
                const result = await res.json();
                if (res.status === 201 && result.success) {
                    bsShowAlert(`Produk "${title}" berhasil disimpan!`, 'success');
                    document.getElementById('bsAddProductForm').reset();
                    await bsLoadProducts();
                    bsSwitchTab('products');
                } else {
                    bsShowAlert(result.message || 'Gagal menyimpan.', 'danger');
                }
            } catch (err) {
                console.error(err);
                bsShowAlert('Kesalahan jaringan.', 'danger');
            }
        });

        async function bsShowDetail(id) {
            try {
                const res = await fetch(`${API_URL}/detail.php?id=${id}`);
                const result = await res.json();
                if (result.success && result.data) {
                    const p = result.data;
                    document.getElementById('bsDetailModalBody').innerHTML = `
                        <div class="text-center mb-3">
                            <img src="${escapeHtml(p.image || '')}" class="img-fluid rounded-3 border" style="max-height: 220px; object-fit: cover;">
                        </div>
                        <span class="badge bg-tokopedia-light mb-1">${escapeHtml(p.category || 'Elektronik')}</span>
                        <h4 class="fw-bold mb-1">${escapeHtml(p.title)}</h4>
                        <p class="text-tokopedia fw-bold fs-4 mb-3">${formatRupiah(p.price)}</p>
                        <div class="p-3 bg-light rounded-3 small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-secondary">Stok:</span>
                                <span class="fw-bold">${p.stock} unit</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary">Status:</span>
                                <span class="text-success fw-bold">Tersedia</span>
                            </div>
                        </div>
                    `;
                    bsModalInstance.show();
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function bsDeleteProduct(id, title) {
            if (!confirm(`Hapus produk "${title}"?`)) return;
            const formData = new URLSearchParams();
            formData.append('id', id);

            try {
                const res = await fetch(`${API_URL}/delete.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });
                const result = await res.json();
                if (result.success) {
                    bsShowAlert(`Produk "${title}" berhasil dihapus.`, 'success');
                    bsLoadProducts();
                }
            } catch (err) {
                console.error(err);
            }
        }

        function bsShowAlert(message, type = 'success') {
            const box = document.getElementById('bsAlertBox');
            box.className = `alert alert-${type} rounded-3 shadow-sm mb-4`;
            box.textContent = message;
            box.classList.remove('d-none');
            setTimeout(() => { box.classList.add('d-none'); }, 4000);
        }

        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
    </script>
</body>
</html>
