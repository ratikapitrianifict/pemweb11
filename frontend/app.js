/**
 * TaskLab / ProductLab - Frontend AJAX Client
 * Menghubungkan Frontend ke Backend REST API menggunakan fetch()
 */

const API_BASE = '../backend/api/tasks';

// DOM Elements
const totalCountEl = document.getElementById('totalCount');
const doneCountEl = document.getElementById('doneCount');
const pendingCountEl = document.getElementById('pendingCount');
const productsGridEl = document.getElementById('productsGrid');
const tableBodyEl = document.getElementById('tableBody');
const productFormEl = document.getElementById('productForm');
const alertBoxEl = document.getElementById('alertBox');
const modalEl = document.getElementById('detailModal');
const modalContentEl = document.getElementById('modalContent');

// 1. Fetch & Render All Data
async function loadData() {
    try {
        const response = await fetch(`${API_BASE}/read.php`);
        const result = await response.json();

        if (result.success && Array.isArray(result.data)) {
            renderDashboard(result.data);
        } else {
            showAlert('Gagal memuat data dari server.', 'error');
        }
    } catch (error) {
        console.error('Fetch error:', error);
        showAlert('Tidak dapat terhubung ke Backend API.', 'error');
    }
}

// 2. Render UI Components
function renderDashboard(tasks) {
    // A. Update Statistics
    const total = tasks.length;
    const done = tasks.filter(t => t.status === 'done').length;
    const pending = tasks.filter(t => t.status === 'pending').length;

    totalCountEl.textContent = total;
    doneCountEl.textContent = done;
    pendingCountEl.textContent = pending;

    // B. Render Cards
    if (tasks.length === 0) {
        productsGridEl.innerHTML = `
            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-xl border border-dashed border-slate-200">
                Belum ada data task/produk. Tambahkan melalui form di bawah.
            </div>
        `;
    } else {
        productsGridEl.innerHTML = tasks.map(task => {
            const isDone = task.status === 'done';
            const statusBadge = isDone 
                ? '<span class="px-2 py-0.5 text-xs font-semibold rounded bg-emerald-100 text-emerald-800">Done</span>' 
                : '<span class="px-2 py-0.5 text-xs font-semibold rounded bg-amber-100 text-amber-800">Pending</span>';

            return `
                <article class="overflow-hidden rounded-xl bg-white shadow-sm border border-slate-200 flex flex-col justify-between">
                    <div class="h-40 bg-slate-800 flex items-center justify-center text-slate-300 font-mono text-sm px-4 text-center">
                        <div>
                            <div class="text-xs text-slate-400 mb-1">TASK ID #${escapeHtml(task.id)}</div>
                            <div class="font-bold text-white text-base">${escapeHtml(task.title)}</div>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-slate-400">${escapeHtml(task.created_at || '-')}</span>
                                ${statusBadge}
                            </div>
                            <h3 class="text-lg font-semibold text-slate-900">${escapeHtml(task.title)}</h3>
                            <p class="mt-2 text-sm text-slate-600 line-clamp-2">
                                ${escapeHtml(task.description || 'Tidak ada deskripsi.')}
                            </p>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <button onclick="showDetail(${task.id})" class="flex-1 px-3 py-2 rounded-lg bg-slate-900 text-white text-sm font-semibold hover:bg-slate-700 transition">
                                Detail
                            </button>
                            <button onclick="toggleStatus(${task.id}, '${escapeHtml(task.title)}', '${escapeHtml(task.description || '')}', '${task.status}')" class="px-3 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition" title="Ubah Status">
                                ${isDone ? 'Set Pending' : 'Set Done'}
                            </button>
                        </div>
                    </div>
                </article>
            `;
        }).join('');
    }

    // C. Render Table
    if (tasks.length === 0) {
        tableBodyEl.innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-400">Data inventaris masih kosong.</td>
            </tr>
        `;
    } else {
        tableBodyEl.innerHTML = tasks.map(task => {
            const isDone = task.status === 'done';
            const statusBadge = isDone 
                ? '<span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">done</span>' 
                : '<span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">pending</span>';

            return `
                <tr class="border-t border-slate-200 hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-semibold text-slate-900">#${escapeHtml(task.id)}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">${escapeHtml(task.title)}</td>
                    <td class="px-4 py-3 text-slate-600 max-w-xs truncate">${escapeHtml(task.description || '-')}</td>
                    <td class="px-4 py-3">${statusBadge}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <button onclick="showDetail(${task.id})" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                            Detail
                        </button>
                        <button onclick="deleteTask(${task.id})" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
}

// 3. Create Task via AJAX
productFormEl.addEventListener('submit', async (e) => {
    e.preventDefault();

    const title = document.getElementById('inputTitle').value.trim();
    const description = document.getElementById('inputDesc').value.trim();
    const status = document.getElementById('inputStatus').value;

    if (!title) {
        showAlert('Judul task/produk wajib diisi!', 'error');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('status', status);

    try {
        const response = await fetch(`${API_BASE}/create.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        });

        const result = await response.json();

        if (response.status === 201 && result.success) {
            showAlert(`Berhasil! ${result.message} (ID: ${result.data.id})`, 'success');
            productFormEl.reset();
            loadData(); // reload data tanpa refresh halaman
        } else {
            showAlert(result.message || 'Gagal menambahkan data.', 'error');
        }
    } catch (error) {
        console.error('Create error:', error);
        showAlert('Terjadi kesalahan koneksi saat mengirim data.', 'error');
    }
});

// 4. Delete Task via AJAX
async function deleteTask(id) {
    if (!confirm(`Yakin ingin menghapus task #${id}?`)) {
        return;
    }

    const formData = new URLSearchParams();
    formData.append('id', id);

    try {
        const response = await fetch(`${API_BASE}/delete.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        });

        const result = await response.json();

        if (result.success) {
            showAlert('Task berhasil dihapus dari database.', 'success');
            loadData();
        } else {
            showAlert(result.message || 'Gagal menghapus task.', 'error');
        }
    } catch (error) {
        console.error('Delete error:', error);
        showAlert('Kesalahan koneksi saat menghapus task.', 'error');
    }
}

// 5. Toggle Status via AJAX
async function toggleStatus(id, title, description, currentStatus) {
    const newStatus = currentStatus === 'done' ? 'pending' : 'done';

    const formData = new URLSearchParams();
    formData.append('id', id);
    formData.append('title', title);
    formData.append('description', description);
    formData.append('status', newStatus);

    try {
        const response = await fetch(`${API_BASE}/update.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        });

        const result = await response.json();

        if (result.success) {
            showAlert(`Status #${id} diubah menjadi ${newStatus}.`, 'success');
            loadData();
        } else {
            showAlert(result.message || 'Gagal mengubah status.', 'error');
        }
    } catch (error) {
        console.error('Update error:', error);
        showAlert('Kesalahan koneksi saat memperbarui status.', 'error');
    }
}

// 6. Fetch Single Detail via AJAX (detail.php?id=...)
async function showDetail(id) {
    try {
        const response = await fetch(`${API_BASE}/detail.php?id=${id}`);
        const result = await response.json();

        if (result.success && result.data) {
            const task = result.data;
            modalContentEl.innerHTML = `
                <div class="mb-4">
                    <span class="text-xs font-mono uppercase px-2 py-1 bg-slate-100 text-slate-600 rounded">ID: #${escapeHtml(task.id)}</span>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2">${escapeHtml(task.title)}</h3>
                </div>
                <div class="space-y-3 text-sm text-slate-700">
                    <div>
                        <strong class="text-slate-500 block text-xs">Deskripsi:</strong>
                        <p class="mt-1 bg-slate-50 p-3 rounded-lg border border-slate-200">${escapeHtml(task.description || '-')}</p>
                    </div>
                    <div class="flex justify-between items-center py-2 border-t border-slate-100">
                        <strong class="text-slate-500 text-xs">Status:</strong>
                        <span class="font-semibold ${task.status === 'done' ? 'text-emerald-600' : 'text-amber-600'} uppercase text-xs">${escapeHtml(task.status)}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-t border-slate-100">
                        <strong class="text-slate-500 text-xs">Dibuat pada:</strong>
                        <span class="text-slate-600">${escapeHtml(task.created_at || '-')}</span>
                    </div>
                </div>
            `;
            modalEl.classList.remove('hidden');
            modalEl.classList.add('flex');
        } else {
            showAlert('Detail task tidak ditemukan.', 'error');
        }
    } catch (error) {
        console.error('Detail error:', error);
        showAlert('Gagal mengambil data detail.', 'error');
    }
}

function closeModal() {
    modalEl.classList.add('hidden');
    modalEl.classList.remove('flex');
}

// Helper: Alert notification
function showAlert(message, type = 'success') {
    alertBoxEl.textContent = message;
    alertBoxEl.className = type === 'success' 
        ? 'mb-6 p-4 rounded-xl text-sm font-medium bg-emerald-50 text-emerald-800 border border-emerald-200'
        : 'mb-6 p-4 rounded-xl text-sm font-medium bg-rose-50 text-rose-800 border border-rose-200';
    alertBoxEl.classList.remove('hidden');

    setTimeout(() => {
        alertBoxEl.classList.add('hidden');
    }, 4000);
}

// Helper: Escape HTML string to prevent XSS
function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', loadData);
