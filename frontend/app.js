/**
 * ProductLab - Tailwind Product Dashboard
 * Modul 11D: Responsive Product Dashboard (Powered by AJAX Fetch)
 */

const API_URL = '../backend/api/tasks';

// Elements
const totalProductStat = document.getElementById('totalProductStat');
const stockReadyStat = document.getElementById('stockReadyStat');
const categoriesStat = document.getElementById('categoriesStat');
const productsGrid = document.getElementById('productsGrid');
const inventoryTableBody = document.getElementById('inventoryTableBody');
const addProductForm = document.getElementById('addProductForm');
const alertBox = document.getElementById('alertBox');
const detailModal = document.getElementById('detailModal');
const detailModalContent = document.getElementById('detailModalContent');

// Format Currency
function formatRupiah(num) {
    const val = Number(num) || 0;
    return 'Rp' + val.toLocaleString('id-ID');
}

// 1. Fetch & Render All Products
async function loadProducts() {
    try {
        const res = await fetch(`${API_URL}/read.php`);
        const result = await res.json();

        if (result.success && Array.isArray(result.data)) {
            renderDashboard(result.data);
        } else {
            console.error('API Error:', result.message);
        }
    } catch (err) {
        console.error('Fetch error:', err);
    }
}

// 2. Render UI
function renderDashboard(products) {
    // A. Statistics
    const totalCount = products.length;
    const totalStock = products.reduce((acc, p) => acc + (Number(p.stock) || 0), 0);
    const uniqueCategories = new Set(products.map(p => p.category || 'Elektronik')).size;

    totalProductStat.textContent = totalCount;
    stockReadyStat.textContent = totalStock;
    categoriesStat.textContent = uniqueCategories || 1;

    // B. Product Cards (Modul 11D Checkpoint 6)
    if (products.length === 0) {
        productsGrid.innerHTML = `
            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-xl border border-dashed border-slate-200">
                Belum ada produk yang terdaftar. Tambahkan melalui form di bawah.
            </div>
        `;
    } else {
        productsGrid.innerHTML = products.map(product => {
            const img = product.image && product.image.trim() !== '' 
                ? product.image 
                : `https://placehold.co/600x360?text=${encodeURIComponent(product.title)}`;

            return `
                <article class="overflow-hidden rounded-xl bg-white shadow-sm border border-slate-200 flex flex-col justify-between">
                    <img src="${escapeHtml(img)}"
                         alt="${escapeHtml(product.title)}"
                         class="h-44 w-full object-cover"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/600x360?text=${encodeURIComponent(product.title)}'"
                    >
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-slate-500">${escapeHtml(product.category || 'Elektronik')}</p>
                            <h3 class="mt-1 text-lg font-semibold text-slate-900">${escapeHtml(product.title)}</h3>
                            <p class="mt-3 font-bold text-slate-900">${formatRupiah(product.price)}</p>
                        </div>
                        <button onclick="showDetail(${product.id})" class="mt-4 w-full px-4 py-2 rounded-lg bg-slate-900 text-white font-semibold hover:bg-slate-700 transition cursor-pointer">
                            Detail Product
                        </button>
                    </div>
                </article>
            `;
        }).join('');
    }

    // C. Inventory Table (Modul 11D Checkpoint 9)
    if (products.length === 0) {
        inventoryTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-400">Data inventaris kosong.</td>
            </tr>
        `;
    } else {
        inventoryTableBody.innerHTML = products.map(product => {
            return `
                <tr class="border-t border-slate-200 hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-medium text-slate-900">${escapeHtml(product.title)}</td>
                    <td class="px-4 py-3 text-slate-600">${escapeHtml(product.category || 'Elektronik')}</td>
                    <td class="px-4 py-3 font-semibold text-slate-800">${formatRupiah(product.price)}</td>
                    <td class="px-4 py-3 text-slate-700">${Number(product.stock) || 0}</td>
                    <td class="px-4 py-3 text-right">
                        <button onclick="deleteProduct(${product.id}, '${escapeHtml(product.title)}')" class="text-rose-600 hover:text-rose-800 text-xs font-semibold cursor-pointer">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
}

// 3. Add Product via AJAX Form (Modul 11D Checkpoint 10)
addProductForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const title = document.getElementById('inputName').value.trim();
    const category = document.getElementById('inputCategory').value;
    const price = document.getElementById('inputPrice').value;
    const stock = document.getElementById('inputStock').value;

    if (!title || !price || !stock) {
        showAlert('Semua field wajib diisi!', 'error');
        return;
    }

    // Auto assign image for laptops/keyboards/mouse if available
    let image = '';
    const lower = title.toLowerCase();
    if (lower.includes('laptop') || lower.includes('macbook') || lower.includes('notebook')) {
        image = 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop';
    } else if (lower.includes('keyboard')) {
        image = 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop';
    } else if (lower.includes('mouse')) {
        image = 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=600&auto=format&fit=crop';
    } else if (lower.includes('monitor') || lower.includes('screen')) {
        image = 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop';
    } else if (lower.includes('stand')) {
        image = 'https://images.unsplash.com/photo-1616353071588-708dcff912e2?w=600&auto=format&fit=crop';
    } else {
        image = `https://placehold.co/600x360?text=${encodeURIComponent(title)}`;
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
            showAlert(`Produk "${title}" berhasil disimpan!`, 'success');
            addProductForm.reset();
            loadProducts();
            // Scroll to products
            const productsSection = document.getElementById('products');
            if (productsSection) {
                productsSection.scrollIntoView({ behavior: 'smooth' });
            }
        } else {
            showAlert(result.message || 'Gagal menyimpan produk.', 'error');
        }
    } catch (err) {
        console.error('Save error:', err);
        showAlert('Terjadi kesalahan jaringan saat menyimpan produk.', 'error');
    }
});

// 4. Detail Product Modal
async function showDetail(id) {
    try {
        const res = await fetch(`${API_URL}/detail.php?id=${id}`);
        const result = await res.json();

        if (result.success && result.data) {
            const p = result.data;
            const img = p.image && p.image.trim() !== '' 
                ? p.image 
                : `https://placehold.co/600x360?text=${encodeURIComponent(p.title)}`;

            detailModalContent.innerHTML = `
                <div class="overflow-hidden rounded-xl border border-slate-200 mb-4">
                    <img src="${escapeHtml(img)}" alt="${escapeHtml(p.title)}" class="h-48 w-full object-cover">
                </div>
                <div class="mb-4">
                    <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md uppercase tracking-wider">
                        ${escapeHtml(p.category || 'Elektronik')}
                    </span>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2">${escapeHtml(p.title)}</h3>
                    <p class="text-xl font-extrabold text-blue-600 mt-1">${formatRupiah(p.price)}</p>
                </div>
                <div class="space-y-2 text-sm text-slate-600 border-t border-slate-100 pt-3">
                    <div class="flex justify-between">
                        <span>Stok Tersedia:</span>
                        <strong class="text-slate-900 font-semibold">${Number(p.stock) || 0} unit</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Status Inventaris:</span>
                        <span class="text-emerald-600 font-semibold uppercase text-xs">Ready</span>
                    </div>
                    ${p.description ? `<p class="mt-2 text-xs text-slate-500 bg-slate-50 p-2.5 rounded-lg border border-slate-100">${escapeHtml(p.description)}</p>` : ''}
                </div>
            `;
            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');
        }
    } catch (err) {
        console.error('Detail error:', err);
    }
}

function closeDetailModal() {
    detailModal.classList.add('hidden');
    detailModal.classList.remove('flex');
}

// 5. Delete Product via AJAX
async function deleteProduct(id, name) {
    if (!confirm(`Hapus produk "${name}" dari inventaris?`)) {
        return;
    }

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
            showAlert(`Produk "${name}" telah dihapus.`, 'success');
            loadProducts();
        } else {
            showAlert(result.message || 'Gagal menghapus produk.', 'error');
        }
    } catch (err) {
        console.error('Delete error:', err);
        showAlert('Gagal menghapus produk karena gangguan jaringan.', 'error');
    }
}

// Alert Toast Helper
function showAlert(message, type = 'success') {
    alertBox.textContent = message;
    alertBox.className = type === 'success'
        ? 'mb-6 p-4 rounded-xl text-sm font-medium bg-emerald-50 text-emerald-800 border border-emerald-200'
        : 'mb-6 p-4 rounded-xl text-sm font-medium bg-rose-50 text-rose-800 border border-rose-200';
    alertBox.classList.remove('hidden');

    setTimeout(() => {
        alertBox.classList.add('hidden');
    }, 4000);
}

// XSS Sanitizer
function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// Load on DOM ready
document.addEventListener('DOMContentLoaded', loadProducts);
