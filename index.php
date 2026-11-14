<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Programming Lab - Module 11</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <div class="max-w-4xl mx-auto px-4 py-12 w-full">
        <!-- Header -->
        <header class="text-center mb-10">
            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full uppercase tracking-wider mb-3">
                Web Programming 1
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                Fullstack Lab Project
            </h1>
            <p class="mt-2 text-slate-600 text-base sm:text-lg">
                Pemisahan Modul Backend (JSON API &amp; MySQL) dan Frontend (Tailwind CSS Dashboard)
            </p>
        </header>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            
            <!-- Frontend Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded">
                        FRONTEND
                    </span>
                    <span class="text-xs text-slate-400">Modul 11D</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Tailwind Product Dashboard</h2>
                <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                    Antarmuka modern menggunakan Tailwind CSS Browser CDN yang mencakup Navbar, Statistik Grid, Kartu Produk, Tabel Inventaris, dan Form Produk.
                </p>
                <a href="frontend/index.html" class="inline-flex items-center justify-center w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition text-sm">
                    Buka Frontend Dashboard &rarr;
                </a>
            </div>

            <!-- Backend Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded">
                        BACKEND
                    </span>
                    <span class="text-xs text-slate-400">Modul 11B</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Task API &amp; Tester</h2>
                <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                    JSON Endpoints dengan PHP Native &amp; MySQLi (CRUD, Prepared Statements, HTTP Status Codes) dilengkapi halaman form tester bersih tanpa AJAX.
                </p>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="backend/tester/index.php" class="inline-flex items-center justify-center flex-1 py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition text-sm">
                        Buka API Tester &rarr;
                    </a>
                    <a href="backend/api/tasks/read.php" target="_blank" class="inline-flex items-center justify-center py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition text-sm">
                        Raw JSON
                    </a>
                </div>
            </div>

        </div>

        <!-- Quick API Endpoints Table -->
        <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-3">Daftar Endpoint API (Backend)</h3>
            <div class="overflow-x-auto text-sm">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">Method</th>
                            <th class="py-2.5 px-3">Endpoint Path</th>
                            <th class="py-2.5 px-3">Aksi / Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-mono text-xs">
                        <tr>
                            <td class="py-2 px-3 text-blue-600 font-bold">GET</td>
                            <td class="py-2 px-3"><a href="backend/api/hello.php" target="_blank" class="hover:underline">/backend/api/hello.php</a></td>
                            <td class="py-2 px-3 font-sans text-slate-500">Cek status server API</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-blue-600 font-bold">GET</td>
                            <td class="py-2 px-3"><a href="backend/api/tasks/read.php" target="_blank" class="hover:underline">/backend/api/tasks/read.php</a></td>
                            <td class="py-2 px-3 font-sans text-slate-500">Ambil seluruh data task</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-blue-600 font-bold">GET</td>
                            <td class="py-2 px-3"><a href="backend/api/tasks/detail.php?id=1" target="_blank" class="hover:underline">/backend/api/tasks/detail.php?id=1</a></td>
                            <td class="py-2 px-3 font-sans text-slate-500">Ambil detail task berdasarkan ID</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-emerald-600 font-bold">POST</td>
                            <td class="py-2 px-3">/backend/api/tasks/create.php</td>
                            <td class="py-2 px-3 font-sans text-slate-500">Tambah data task baru</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-amber-600 font-bold">POST</td>
                            <td class="py-2 px-3">/backend/api/tasks/update.php</td>
                            <td class="py-2 px-3 font-sans text-slate-500">Perbarui task berdasarkan ID</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-rose-600 font-bold">POST</td>
                            <td class="py-2 px-3">/backend/api/tasks/delete.php</td>
                            <td class="py-2 px-3 font-sans text-slate-500">Hapus task berdasarkan ID</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p>&copy; 2026 Ratika Pitriani - Web Programming 1</p>
    </footer>

</body>
</html>
