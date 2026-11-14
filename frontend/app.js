/**
 * ProductLab - E-Commerce Product Dashboard
 * Modul 11D: Tailwind CSS Product Dashboard (Clean Tokopedia Style)
 * Powered by AJAX Fetch
 */

const API_URL = '../backend/api/tasks';

// State
let allProducts = [];
let currentCategory = 'all';

// DOM Elements
const totalProductStat = document.getElementById('totalProductStat');
const stockReadyStat = document.getElementById('stockReadyStat');
const categoriesStat = document.getElementById('categoriesStat');
const productsGrid = document.getElementById('productsGrid');
const inventoryTableBody = document.getElementById('inventoryTableBody');
const addProductForm = document.getElementById('addProductForm');
const alertBox = document.getElementById('alertBox');
const detailModal = document.getElementById('detailModal');
const detailModalContent = document.getElementById('detailModalContent');

// Tab Navigation
function switchTab(tabId) {
    const tabs = ['tab-products', 'tab-inventory', 'tab-form'];
    tabs.forEach(t => {
        const el = document.getElementById(t);
        if (el) {
            el.classList.add('hidden');
        }
    });

    const activeEl = document.getElementById(`tab-${tabId}`);
    if (activeEl) {
        activeEl.classList.remove('hidden');
    }

    // Update active button state
    const btnIds = ['btn-tab-products', 'btn-tab-inventory', 'btn-tab-form'];
    btnIds.forEach(bId => {
        const btn = document.getElementById(bId);
        if (btn) {
            btn.className = 'px-5 py-2.5 rounded-xl font-medium text-sm transition cursor-pointer text-slate-600 hover:text-slate-900 hover:bg-slate-100';
        }
    });

    const activeBtn = document.getElementById(`btn-tab-${tabId}`);
    if (activeBtn) {
        activeBtn.className = 'px-5 py-2.5 rounded-xl font-semibold text-sm transition cursor-pointer bg-[#03AC0E] text-white shadow-sm';
    }
}

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
            allProducts = result.data;
            renderDashboard(allProducts);
        } else {
            console.error('API Error:', result.message);
        }
    } catch (err) {
        console.error('Fetch error:', err);
    }
}

// Filter category
function filterCategory(cat) {
    currentCategory = cat;
    
    // update button styling
    const pills = document.querySelectorAll('.category-pill');
    pills.forEach(pill => {
        if (pill.getAttribute('data-cat') === cat) {
            pill.className = 'category-pill px-4 py-1.5 rounded-full text-xs font-semibold bg-[#03AC0E] text-white transition cursor-pointer';
        } else {
            pill.className = 'category-pill px-4 py-1.5 rounded-full text-xs font-medium bg-white text-slate-600 border border-slate-200 hover:border-slate-300 transition cursor-pointer';
        }
    });

    if (cat === 'all') {
        renderCards(allProducts);
    } else {
        const filtered = allProducts.filter(p => (p.category || 'Elektronik').toLowerCase() === cat.toLowerCase());
        renderCards(filtered);
    }
}

// 2. Render Dashboard UI
function renderDashboard(products) {
    // A. Update Statistics
    const totalCount = products.length;
    const totalStock = products.reduce((acc, p) => acc + (Number(p.stock) || 0), 0);
    const uniqueCategories = new Set(products.map(p => p.category || 'Elektronik')).size;

    totalProductStat.textContent = totalCount;
    stockReadyStat.textContent = totalStock;
    categoriesStat.textContent = uniqueCategories || 1;

    // B. Render Cards & Table
    renderCards(products);
    renderTable(products);
}

// Render E-Commerce Style Cards
function renderCards(products) {
    if (!productsGrid) return;

    if (products.length === 0) {
        productsGrid.innerHTML = `
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-2xl border border-dashed border-slate-200">
                Tidak ada produk dalam kategori ini.
            </div>
        `;
        return;
    }

    productsGrid.innerHTML = products.map(product => {
        const img = product.image && product.image.trim() !== '' 
            ? product.image 
            : `https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&auto=format&fit=crop&q=80`;

        return `
            <article class="group bg-white rounded-2xl border border-slate-200 hover:border-[#03AC0E] hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <!-- E-Commerce Product Image Container -->
                <div class="h-48 w-full bg-slate-50 flex items-center justify-center p-3 relative overflow-hidden border-b border-slate-100">
                    <img src="${escapeHtml(img)}"
                         alt="${escapeHtml(product.title)}"
                         class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-300"
                         loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&auto=format&fit=crop&q=80'"
                    >
                    <span class="absolute top-3 left-3 px-2 py-0.5 text-[11px] font-semibold rounded-md bg-white/90 text-slate-700 shadow-sm border border-slate-100">
                        ${escapeHtml(product.category || 'Elektronik')}
                    </span>
                </div>

                <!-- Product Body Details -->
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800 line-clamp-2 leading-snug group-hover:text-[#03AC0E] transition">
                            ${escapeHtml(product.title)}
                        </h3>
                        <p class="mt-2 text-base font-bold text-slate-900">
                            ${formatRupiah(product.price)}
                        </p>
                        <div class="mt-1.5 flex items-center justify-between text-xs text-slate-500">
                            <span>Stok: <strong class="text-slate-700 font-semibold">${Number(product.stock) || 0}</strong></span>
                            <span class="text-[#03AC0E] font-medium bg-[#E8F5E9] px-2 py-0.5 rounded text-[10px]">Tersedia</span>
                        </div>
                    </div>

                    <button onclick="showDetail(${product.id})" class="mt-4 w-full py-2 px-3 rounded-xl bg-[#03AC0E] hover:bg-[#02960c] text-white text-xs font-semibold transition cursor-pointer text-center shadow-sm">
                        Detail Produk
                    </button>
                </div>
            </article>
        `;
    }).join('');
}

// Render Inventory Table
function renderTable(products) {
    if (!inventoryTableBody) return;

    if (products.length === 0) {
        inventoryTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-slate-400">Data inventaris masih kosong.</td>
            </tr>
        `;
        return;
    }

    inventoryTableBody.innerHTML = products.map(product => {
        return `
            <tr class="border-t border-slate-100 hover:bg-slate-50/80 transition text-sm">
                <td class="px-5 py-3.5 font-semibold text-slate-900">#${escapeHtml(product.id)}</td>
                <td class="px-5 py-3.5 font-medium text-slate-800">
                    <div class="flex items-center gap-3">
                        <img src="${escapeHtml(product.image || '')}" alt="" class="w-9 h-9 rounded-lg object-cover bg-slate-100 border border-slate-200" onerror="this.style.display='none'">
                        <span>${escapeHtml(product.title)}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-slate-600">
                    <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                        ${escapeHtml(product.category || 'Elektronik')}
                    </span>
                </td>
                <td class="px-5 py-3.5 font-semibold text-slate-900">${formatRupiah(product.price)}</td>
                <td class="px-5 py-3.5 text-slate-700">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold ${Number(product.stock) > 5 ? 'bg-[#E8F5E9] text-[#03AC0E]' : 'bg-amber-100 text-amber-800'}">
                        ${Number(product.stock) || 0} unit
                    </span>
                </td>
                <td class="px-5 py-3.5 text-right space-x-3">
                    <button onclick="showDetail(${product.id})" class="text-[#03AC0E] hover:text-[#02960c] text-xs font-semibold cursor-pointer">
                        Detail
                    </button>
                    <button onclick="deleteProduct(${product.id}, '${escapeHtml(product.title)}')" class="text-rose-600 hover:text-rose-800 text-xs font-semibold cursor-pointer">
                        Hapus
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

// 3. Add Product via AJAX Form
addProductForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const title = document.getElementById('inputName').value.trim();
    const category = document.getElementById('inputCategory').value;
    const price = document.getElementById('inputPrice').value;
    const stock = document.getElementById('inputStock').value;
    let customImage = document.getElementById('inputImage') ? document.getElementById('inputImage').value.trim() : '';

    if (!title || !price || !stock) {
        showAlert('Semua field wajib diisi!', 'error');
        return;
    }

    if (!customImage) {
        const lower = title.toLowerCase();
        if (lower.includes('laptop') || lower.includes('macbook') || lower.includes('notebook') || lower.includes('rog')) {
            customImage = 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80';
        } else if (lower.includes('keyboard')) {
            customImage = 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80';
        } else if (lower.includes('mouse')) {
            customImage = 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80';
        } else if (lower.includes('monitor') || lower.includes('screen')) {
            customImage = 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop&q=80';
        } else if (lower.includes('stand')) {
            customImage = 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80';
        } else {
            customImage = 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&auto=format&fit=crop&q=80';
        }
    }

    const formData = new URLSearchParams();
    formData.append('title', title);
    formData.append('category', category);
    formData.append('price', price);
    formData.append('stock', stock);
    formData.append('image', customImage);
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
            await loadProducts();
            switchTab('products'); // pindah ke tab katalog
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
                : 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&auto=format&fit=crop&q=80';

            detailModalContent.innerHTML = `
                <div class="h-56 w-full bg-slate-50 rounded-xl overflow-hidden mb-4 border border-slate-100 flex items-center justify-center p-2">
                    <img src="${escapeHtml(img)}" alt="${escapeHtml(p.title)}" class="h-full w-full object-cover rounded-lg">
                </div>
                <div class="mb-4">
                    <span class="text-[11px] font-semibold px-2.5 py-1 bg-[#E8F5E9] text-[#03AC0E] rounded-md uppercase tracking-wider">
                        ${escapeHtml(p.category || 'Elektronik')}
                    </span>
                    <h3 class="text-xl font-bold text-slate-900 mt-2">${escapeHtml(p.title)}</h3>
                    <p class="text-2xl font-extrabold text-[#03AC0E] mt-1">${formatRupiah(p.price)}</p>
                </div>
                <div class="space-y-2.5 text-sm text-slate-600 border-t border-slate-100 pt-3">
                    <div class="flex justify-between items-center">
                        <span>Stok Inventaris:</span>
                        <strong class="text-slate-900 font-semibold">${Number(p.stock) || 0} unit</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Status Produk:</span>
                        <span class="text-[#03AC0E] font-semibold text-xs uppercase">Tersedia</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>ID Produk:</span>
                        <span class="font-mono text-xs text-slate-400">#${escapeHtml(p.id)}</span>
                    </div>
                    ${p.description ? `<p class="mt-2 text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed">${escapeHtml(p.description)}</p>` : ''}
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
        ? 'mb-6 p-4 rounded-xl text-sm font-semibold bg-[#E8F5E9] text-[#03AC0E] border border-[#C8E6C9]'
        : 'mb-6 p-4 rounded-xl text-sm font-semibold bg-rose-50 text-rose-700 border border-rose-200';
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

// Search filter in inventory table
function searchProducts(query) {
    const q = query.toLowerCase();
    const filtered = allProducts.filter(p => 
        (p.title || '').toLowerCase().includes(q) || 
        (p.category || '').toLowerCase().includes(q)
    );
    renderTable(filtered);
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', loadProducts);
