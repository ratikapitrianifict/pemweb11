<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProductLab - E-Commerce Product Dashboard</title>
    <!-- Checkpoint 1: Aktifkan Tailwind Play CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .tokopedia-green { color: #03AC0E; }
        .bg-tokopedia-green { background-color: #03AC0E; }
        .bg-tokopedia-green:hover { background-color: #02960c; }
        .border-tokopedia-green { border-color: #03AC0E; }
    </style>
</head>
<body class="bg-[#F7F8FA] text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Checkpoint 8: Navbar Dirakit dari Utilities (Tokopedia Style) -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="#" class="font-bold text-xl text-[#03AC0E] tracking-tight flex items-center gap-1.5">
                    ProductLab
                </a>
                <div class="hidden md:flex gap-6 text-sm font-medium text-slate-600">
                    <button onclick="switchTab('products')" class="hover:text-[#03AC0E] transition cursor-pointer">Katalog</button>
                    <button onclick="switchTab('inventory')" class="hover:text-[#03AC0E] transition cursor-pointer">Inventaris</button>
                    <button onclick="switchTab('form')" class="hover:text-[#03AC0E] transition cursor-pointer">Tambah Produk</button>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="../backend/tester/index.php" class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    Backend Tester
                </a>
                <a href="../index.php" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    Portal
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 py-8 flex-1 w-full">

        <!-- Notification Toast -->
        <div id="alertBox" class="hidden"></div>

        <!-- Dashboard Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Product Dashboard</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola katalog produk, stok inventaris, dan REST API asinkron.</p>
            </div>
            <button onclick="switchTab('form')" class="inline-flex items-center justify-center px-4 py-2.5 bg-[#03AC0E] hover:bg-[#02960c] text-white text-sm font-semibold rounded-xl shadow-xs transition cursor-pointer">
                + Tambah Produk Baru
            </button>
        </div>

        <!-- Checkpoint 5: Grid Statistik Ringkasan -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Produk</p>
                    <p id="totalProductStat" class="mt-1.5 text-2xl font-extrabold text-slate-900">-</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 font-bold text-sm">
                    SKU
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Stok Siap</p>
                    <p id="stockReadyStat" class="mt-1.5 text-2xl font-extrabold text-[#03AC0E]">-</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#E8F5E9] text-[#03AC0E] flex items-center justify-center font-bold text-sm">
                    QTY
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Kategori Aktif</p>
                    <p id="categoriesStat" class="mt-1.5 text-2xl font-extrabold text-slate-900">-</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 font-bold text-sm">
                    CAT
                </div>
            </div>
        </section>

        <!-- Pemisah / Tab Switcher Antara Products, Inventory & Form -->
        <div class="bg-white p-1.5 rounded-2xl border border-slate-200 shadow-xs flex flex-wrap gap-1.5 mb-8">
            <button id="btn-tab-products" onclick="switchTab('products')" class="px-5 py-2.5 rounded-xl font-semibold text-sm transition cursor-pointer bg-[#03AC0E] text-white shadow-xs">
                Katalog Produk (E-Commerce)
            </button>
            <button id="btn-tab-inventory" onclick="switchTab('inventory')" class="px-5 py-2.5 rounded-xl font-medium text-sm transition cursor-pointer text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                Tabel Inventaris &amp; Stok
            </button>
            <button id="btn-tab-form" onclick="switchTab('form')" class="px-5 py-2.5 rounded-xl font-medium text-sm transition cursor-pointer text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                Form Tambah Produk
            </button>
        </div>

        <!-- ==========================================
             TAB 1: PRODUCTS (KATALOG E-COMMERCE)
             ========================================== -->
        <section id="tab-products" class="mb-12">
            <!-- Filter Kategori & Search Info -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Katalog Produk</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar produk elektronik, komputer, dan aksesoris</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterCategory('all')" data-cat="all" class="category-pill px-4 py-1.5 rounded-full text-xs font-semibold bg-[#03AC0E] text-white transition cursor-pointer">
                        Semua Kategori
                    </button>
                    <button onclick="filterCategory('Elektronik')" data-cat="Elektronik" class="category-pill px-4 py-1.5 rounded-full text-xs font-medium bg-white text-slate-600 border border-slate-200 hover:border-slate-300 transition cursor-pointer">
                        Elektronik
                    </button>
                    <button onclick="filterCategory('Aksesoris')" data-cat="Aksesoris" class="category-pill px-4 py-1.5 rounded-full text-xs font-medium bg-white text-slate-600 border border-slate-200 hover:border-slate-300 transition cursor-pointer">
                        Aksesoris
                    </button>
                    <button onclick="loadProducts()" class="px-3 py-1.5 rounded-full text-xs font-medium text-slate-500 hover:text-[#03AC0E] transition cursor-pointer">
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Grid Kartu Produk E-Commerce -->
            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                <!-- Dirender secara dinamis oleh AJAX -->
            </div>
        </section>

        <!-- ==========================================
             TAB 2: INVENTORY (TABEL MANAJEMEN STOK)
             ========================================== -->
        <section id="tab-inventory" class="hidden mb-12">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Inventaris Produk</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pantau ketersediaan stok produk dan hapus item dari database.</p>
                    </div>
                    <div class="w-full sm:w-72">
                        <input type="text"
                               placeholder="Cari produk atau kategori..."
                               oninput="searchProducts(this.value)"
                               class="w-full text-sm px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#03AC0E]/20 focus:border-[#03AC0E] transition"
                        >
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-5 py-3">ID</th>
                                <th class="px-5 py-3">Nama Produk</th>
                                <th class="px-5 py-3">Kategori</th>
                                <th class="px-5 py-3">Harga</th>
                                <th class="px-5 py-3">Stok</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody" class="divide-y divide-slate-100">
                            <!-- Dirender secara dinamis oleh AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ==========================================
             TAB 3: FORM TAMBAH PRODUK
             ========================================== -->
        <section id="tab-form" class="hidden mb-12">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8 max-w-2xl mx-auto">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-slate-900">Tambah Produk Baru</h2>
                    <p class="text-xs text-slate-500 mt-1">Isi formulir untuk menambahkan produk ke katalog dan database via AJAX (fetch).</p>
                </div>

                <form id="addProductForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="inputName"
                               name="title"
                               class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#03AC0E]/20 focus:border-[#03AC0E] transition"
                               placeholder="Contoh: Laptop ASUS Zenbook 14 OLED"
                               required
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select id="inputCategory" name="category" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#03AC0E]/20 focus:border-[#03AC0E] transition bg-white">
                            <option value="Elektronik">Elektronik</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Furniture">Furniture</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Satuan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number"
                               id="inputPrice"
                               name="price"
                               class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#03AC0E]/20 focus:border-[#03AC0E] transition"
                               placeholder="15000000"
                               required
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jumlah Stok <span class="text-rose-500">*</span>
                        </label>
                        <input type="number"
                               id="inputStock"
                               name="stock"
                               class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#03AC0E]/20 focus:border-[#03AC0E] transition"
                               placeholder="10"
                               required
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            URL Gambar (Opsional)
                        </label>
                        <input type="url"
                               id="inputImage"
                               name="image"
                               class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#03AC0E]/20 focus:border-[#03AC0E] transition"
                               placeholder="https://images.unsplash.com/..."
                        >
                        <p class="text-[11px] text-slate-400 mt-1">Kosongkan untuk otomatis menggunakan foto produk standar.</p>
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <button type="submit" class="w-full py-3 px-5 rounded-xl bg-[#03AC0E] hover:bg-[#02960c] text-white font-semibold text-sm shadow-sm transition cursor-pointer">
                            Simpan Produk ke Database
                        </button>
                    </div>
                </form>
            </div>
        </section>

    </main>

    <!-- Modal Detail Produk -->
    <div id="detailModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-lg font-bold cursor-pointer">
                Tutup
            </button>
            <div id="detailModalContent"></div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeDetailModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Kembali
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p>ProductLab - Responsive E-Commerce Product Dashboard (Module 11D)</p>
    </footer>

    <!-- AJAX Client Script -->
    <script src="app.js"></script>
</body>
</html>
