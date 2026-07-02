<?php
session_start();
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT monthly_budget_limit FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$budgetLimit = $user->monthly_budget_limit;

include __DIR__ . '/includes/header.php';
?>

<div class="flex-col justify-between flex-grow flex relative overflow-hidden" id="main-app" style="background-image: radial-gradient(rgba(140, 140, 140, 0.3) 1.5px, transparent 1.5px), linear-gradient(to right, rgba(140, 140, 140, 0.12) 1px, transparent 1px), linear-gradient(to bottom, rgba(140, 140, 140, 0.12) 1px, transparent 1px); background-size: 16px 16px, 32px 32px, 32px 32px;">
    <!-- Decorative Background Accents for Dashboard -->
    <div class="absolute top-20 left-4 hidden 2xl:flex items-center gap-2 border-2 border-[var(--border-main)] bg-yellow-400 text-black px-3 py-1 font-bold text-xs retro-shadow -rotate-3 select-none pointer-events-none opacity-85">
        <span>⚡ POCKET_LEDGER v2.6</span>
    </div>
    <div class="absolute top-40 right-4 hidden 2xl:flex items-center gap-2 border-2 border-[var(--border-main)] bg-cyan-400 text-black px-3 py-1.5 font-bold text-xs retro-shadow rotate-3 select-none pointer-events-none opacity-85">
        <span>📊 LIVE TRACKING</span>
    </div>
    <div class="absolute bottom-20 left-6 hidden 2xl:block border-2 border-[var(--border-main)] bg-pink-400 text-black p-2.5 font-bold text-xs retro-shadow rotate-6 select-none pointer-events-none opacity-85">
        <span class="block text-sm">💰 AUTO-CALC</span>
        <span class="text-[9px] block">REALTIME BALANCE</span>
    </div>
    <div class="absolute bottom-32 right-6 hidden 2xl:block border-2 border-[var(--border-main)] bg-emerald-400 text-black px-3 py-2 font-bold text-xs retro-shadow -rotate-6 select-none pointer-events-none opacity-85">
        <span class="block text-sm">🔒 SECURE SESSION</span>
    </div>
    <!-- Subtle Geometric Shapes in Background -->
    <div class="absolute top-36 left-8 w-6 h-6 border-2 border-[var(--border-main)] bg-orange-400 retro-shadow rotate-45 select-none pointer-events-none opacity-50 hidden xl:block"></div>
    <div class="absolute bottom-40 right-10 w-8 h-8 rounded-full border-2 border-[var(--border-main)] bg-purple-300 retro-shadow select-none pointer-events-none opacity-50 hidden xl:block"></div>

    <!-- HEADER -->
    <header class="border-b-2 border-[var(--border-main)] py-3 px-4 relative z-20" style="background-color: var(--bg-card)">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black pixel-text leading-none flex items-center gap-2">
                    <span class="text-3xl">💰</span> POCKET_LEDGER
                </h1>
                <p class="text-[8px] opacity-60 font-bold uppercase tracking-widest">Edisi Kas Mandiri Harian (<?= htmlspecialchars($_SESSION['username']) ?>)</p>
            </div>
            <div class="flex gap-2">
                <button id="theme-toggle" class="text-xs bg-yellow-400 text-black font-bold border-2 border-black px-2 py-1 retro-shadow-sm retro-shadow-active">🌙 DARK_MODE</button>
                <a href="profile.php" class="text-xs bg-white dark:bg-gray-700 text-black dark:text-white font-bold border-2 border-[var(--border-main)] px-2 py-1 retro-shadow-sm retro-shadow-active text-center block">PROFIL</a>
                <a href="actions/auth_logout.php" id="logout-btn" class="text-xs font-bold border-2 border-[var(--border-main)] px-2 py-1 retro-shadow-sm retro-shadow-active text-center block bg-red-500 text-white">LOGOUT</a>
            </div>
        </div>
    </header>

    <!-- DASHBOARD CONTAINER -->
    <main class="flex-grow max-w-6xl mx-auto w-full px-4 py-6 space-y-6 relative z-10">
        <!-- CARDS STATS -->
        <section class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs font-bold">
            <div class="border-2 border-[var(--border-main)] p-3 retro-shadow" style="background-color: var(--bg-card)">
                <span>💰 SISA SALDO</span>
                <p id="stat-saldo" class="text-base mt-1">Rp 0</p>
            </div>
            <div class="border-2 border-[var(--border-main)] p-3 retro-shadow" style="background-color: var(--bg-card)">
                <span>📊 BUDGET BULANAN</span>
                <p id="stat-budget" class="text-base mt-1">0% Terpakai</p>
            </div>
            <div class="border-2 border-[var(--border-main)] p-3 retro-shadow text-emerald-600 dark:text-emerald-400" style="background-color: var(--bg-card)">
                <span>📈 PEMASUKAN</span>
                <p id="stat-pemasukan" class="text-base mt-1">+Rp 0</p>
            </div>
            <div class="border-2 border-[var(--border-main)] p-3 retro-shadow text-red-500" style="background-color: var(--bg-card)">
                <span>📉 PENGELUARAN</span>
                <p id="stat-pengeluaran" class="text-base mt-1">-Rp 0</p>
            </div>
        </section>

        <!-- WORKSPACE -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- CONTROLS -->
            <div class="space-y-4">
                <div class="border-2 border-[var(--border-main)] p-4 retro-shadow" style="background-color: var(--bg-card)">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-bold text-xs">📊 GRAFIK PENGELUARAN</h4>
                        <select id="chart-type" onchange="renderDashboard()" class="text-[10px] p-1 outline-none font-bold border border-black cursor-pointer bg-white dark:bg-gray-700">
                            <option value="doughnut">Donat</option>
                            <option value="pie">Pie</option>
                            <option value="bar">Batang</option>
                            <option value="line">Garis</option>
                        </select>
                    </div>
                    <canvas id="expenseChart" class="w-full"></canvas>
                </div>

                <div class="border-2 border-[var(--border-main)] p-4 retro-shadow" style="background-color: var(--bg-card)">
                    <h4 class="font-bold mb-2 text-xs">LIMIT ANGGARAN</h4>
                    <input type="range" id="budget-slider" min="0" max="10000000" step="100000" value="<?= $budgetLimit ?>" class="w-full accent-yellow-400 cursor-pointer" />
                    <p id="budget-limit-text" class="text-xs font-bold mt-1">Target: Rp <?= number_format($budgetLimit, 0, ',', '.') ?></p>
                </div>

                <div class="border-2 border-[var(--border-main)] p-4 retro-shadow" style="background-color: var(--bg-card)">
                    <h4 class="font-bold mb-2 text-xs">METERAN KAS CEPAT</h4>
                    <form id="tx-form" class="space-y-2.5 text-xs font-bold">
                        <div class="grid grid-cols-2 gap-2 border border-black p-1">
                            <button type="button" id="btn-type-keluar" class="py-1 bg-black text-white dark:bg-white dark:text-black font-bold">🔴 KELUAR</button>
                            <button type="button" id="btn-type-masuk" class="py-1 text-slate-400 font-bold">🟢 MASUK</button>
                        </div>
                        <input type="number" id="tx-amount" required class="w-full p-1 outline-none" placeholder="Nominal Rp..." />
                        <div class="flex gap-2">
                            <select id="tx-category" class="w-full p-1 outline-none rounded-none cursor-pointer">
                            <!-- Opsi diisi dinamis oleh JS -->
                            </select>
                            <button type="button" onclick="deleteCurrentCategory()" class="bg-red-500 text-white px-3 font-bold border border-black retro-shadow-sm retro-shadow-active transition hover:bg-red-600" title="Hapus Kategori yang Dipilih">X</button>
                        </div>
                        <input type="text" id="tx-description" class="w-full p-1 outline-none" placeholder="Keterangan..." required />
                        <button type="submit" class="w-full bg-yellow-400 text-black font-bold py-1 border border-black retro-shadow-sm retro-shadow-active transition uppercase">KIRIM</button>
                    </form>
                </div>
            </div>

            <!-- BUKU ARUS KAS -->
            <div class="lg:col-span-2 space-y-6">
                <div class="border-2 border-[var(--border-main)] p-4 retro-shadow" style="background-color: var(--bg-card)">
                    <div class="flex flex-col gap-2 mb-3">
                        <div class="flex flex-wrap gap-2 text-[10px] uppercase font-bold items-center">
                            <input type="text" id="search-box" oninput="renderDashboard()" placeholder="CARI KETERANGAN..." class="p-1 w-full sm:w-auto flex-grow outline-none border border-[var(--border-main)]" />
                            <select id="filter-type" onchange="renderDashboard()" class="p-1 outline-none cursor-pointer border border-[var(--border-main)]">
                                <option value="Semua">SEMUA TIPE</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                            <select id="filter-month" onchange="renderDashboard()" class="p-1 outline-none cursor-pointer border border-[var(--border-main)]">
                                <option value="Semua">SEMUA BULAN</option>
                            </select>
                            <span>| DARI:</span>
                            <input type="date" id="filter-start" onchange="renderDashboard()" class="p-1 outline-none border border-[var(--border-main)] bg-transparent">
                            <span>S/D:</span>
                            <input type="date" id="filter-end" onchange="renderDashboard()" class="p-1 outline-none border border-[var(--border-main)] bg-transparent">
                        </div>
                        <div class="flex gap-2 self-end">
                            <button onclick="exportCSV()" class="bg-green-500 text-black text-[10px] px-3 py-1 border-2 border-black retro-shadow-sm retro-shadow-active font-bold cursor-pointer">⬇️ CSV (EXCEL)</button>
                            <button onclick="exportPDF()" class="bg-blue-500 text-white text-[10px] px-3 py-1 border-2 border-black retro-shadow-sm retro-shadow-active font-bold cursor-pointer">📄 CETAK PDF</button>
                        </div>
                    </div>
                    <div id="transactions-list" class="space-y-2 max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
                        <!-- Diisi oleh JS -->
                    </div>
                </div>

                <!-- NEW: Kalkulator & Tips -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Box Kalkulator -->
                    <div class="border-2 border-[var(--border-main)] p-4 retro-shadow" style="background-color: var(--bg-card)">
                        <h4 class="font-bold mb-2 text-xs">🧮 KALKULATOR RETRO</h4>
                        <div class="border-2 border-black p-2 mb-2 bg-gray-200 dark:bg-gray-800 text-right text-lg font-bold" id="calc-display">0</div>
                        <div class="grid grid-cols-4 gap-2 text-xs font-bold">
                            <!-- Buttons -->
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('7')">7</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('8')">8</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('9')">9</button>
                            <button class="border border-black bg-yellow-400 text-black p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('/')">/</button>
                            
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('4')">4</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('5')">5</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('6')">6</button>
                            <button class="border border-black bg-yellow-400 text-black p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('*')">x</button>
                            
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('1')">1</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('2')">2</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('3')">3</button>
                            <button class="border border-black bg-yellow-400 text-black p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('-')">-</button>
                            
                            <button class="border border-black bg-red-400 text-black p-2 retro-shadow-sm retro-shadow-active" onclick="calcClear()">C</button>
                            <button class="border border-black bg-white dark:bg-gray-700 p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('0')">0</button>
                            <button class="border border-black bg-green-400 text-black p-2 retro-shadow-sm retro-shadow-active" onclick="calcEval()">=</button>
                            <button class="border border-black bg-yellow-400 text-black p-2 retro-shadow-sm retro-shadow-active" onclick="calcInput('+')">+</button>
                        </div>
                    </div>

                    <!-- Box Tips Hemat -->
                    <div class="border-2 border-[var(--border-main)] p-4 retro-shadow flex flex-col" style="background-color: var(--bg-card)">
                        <h4 class="font-bold mb-2 text-xs">💡 TIPS HARI INI</h4>
                        <div class="flex-grow border-2 border-dashed border-[var(--border-main)] p-4 flex items-center justify-center text-center bg-yellow-50 dark:bg-yellow-900/20 relative">
                            <span class="absolute top-1 left-2 text-xl opacity-20">❝</span>
                            <p id="tips-text" class="text-sm font-bold opacity-80 leading-relaxed"></p>
                            <span class="absolute bottom-1 right-2 text-xl opacity-20">❞</span>
                        </div>
                        <button onclick="changeTip()" class="w-full mt-3 bg-black text-white dark:bg-white dark:text-black font-bold py-1.5 border-2 border-black retro-shadow-sm retro-shadow-active transition uppercase text-xs">GANTI TIPS</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t-2 border-[var(--border-main)] py-3 text-center text-[9px] opacity-60 font-bold uppercase" style="background-color: var(--bg-card)">
        © 2026 POCKET_LEDGER. PHP Fullstack Edition.
    </footer>
</div>

<script>
    let budgetLimit = <?= $budgetLimit ?>;
    let activeType = 'Pengeluaran';
    let transactions = [];
    let editingTxId = null;

    // --- DOM ELEMENTS ---
    const txForm = document.getElementById('tx-form');
    const btnTypeKeluar = document.getElementById('btn-type-keluar');
    const btnTypeMasuk = document.getElementById('btn-type-masuk');
    const txCategory = document.getElementById('tx-category');
    const budgetSlider = document.getElementById('budget-slider');
    const budgetLimitText = document.getElementById('budget-limit-text');
    const transactionsList = document.getElementById('transactions-list');
    const searchBox = document.getElementById('search-box');
    const filterType = document.getElementById('filter-type');
    const filterMonth = document.getElementById('filter-month');

    // Opsi Kategori Berdasarkan Alur
    let categories = {
        Pengeluaran: ['🍔 Makanan', '🚗 Transport', '🏠 Kost & Bulanan', '🛍️ Belanja'],
        Pemasukan: ['💼 Gaji', '💰 Penjualan', '🎁 Pemberian']
    };

    // --- FORM ALUR KAS TYPE TOGGLE ---
    function updateCategoryOptions() {
        txCategory.innerHTML = '';
        let deletedCats = JSON.parse(localStorage.getItem('deletedCategories') || '[]');

        categories[activeType].forEach(cat => {
            if (!deletedCats.includes(cat)) {
                const opt = document.createElement('option');
                opt.value = cat;
                opt.innerText = cat;
                txCategory.appendChild(opt);
            }
        });

        // Opsi tambah kategori baru
        const optNew = document.createElement('option');
        optNew.value = 'tambah_baru';
        optNew.innerText = '✨ [+] Tambah Kategori...';
        optNew.className = 'bg-yellow-200 dark:bg-yellow-800 text-black dark:text-white font-bold';
        txCategory.appendChild(optNew);
    }
    updateCategoryOptions();

    txCategory.addEventListener('change', (e) => {
        if (e.target.value === 'tambah_baru') {
            const newCat = prompt("Masukkan nama kategori baru (contoh: 🏥 Kesehatan):");
            if (newCat && newCat.trim() !== '') {
                const finalCat = newCat.trim();
                
                // Hapus dari deletedCategories jika sebelumnya pernah dihapus
                let deletedCats = JSON.parse(localStorage.getItem('deletedCategories') || '[]');
                deletedCats = deletedCats.filter(c => c !== finalCat);
                localStorage.setItem('deletedCategories', JSON.stringify(deletedCats));

                if (!categories[activeType].includes(finalCat)) {
                    categories[activeType].push(finalCat);
                }
                updateCategoryOptions();
                txCategory.value = finalCat;
            } else {
                txCategory.selectedIndex = 0;
            }
        }
    });

    // Fungsi Hapus Kategori
    window.deleteCurrentCategory = function() {
        const catToDelete = txCategory.value;
        if (!catToDelete || catToDelete === 'tambah_baru') return;

        if (!confirm(`Yakin ingin menyembunyikan kategori "${catToDelete}" dari daftar pilihan?`)) return;

        // Simpan ke localStorage agar tidak dimuat ulang
        let deletedCats = JSON.parse(localStorage.getItem('deletedCategories') || '[]');
        if (!deletedCats.includes(catToDelete)) {
            deletedCats.push(catToDelete);
            localStorage.setItem('deletedCategories', JSON.stringify(deletedCats));
        }

        // Hapus dari opsi saat ini
        categories[activeType] = categories[activeType].filter(c => c !== catToDelete);
        updateCategoryOptions();
    };

    btnTypeKeluar.addEventListener('click', () => {
        activeType = 'Pengeluaran';
        btnTypeKeluar.className = 'py-1 bg-black text-white dark:bg-white dark:text-black font-bold';
        btnTypeMasuk.className = 'py-1 text-slate-400 font-bold';
        updateCategoryOptions();
    });

    btnTypeMasuk.addEventListener('click', () => {
        activeType = 'Pemasukan';
        btnTypeMasuk.className = 'py-1 bg-yellow-400 text-black border border-black font-bold';
        btnTypeKeluar.className = 'py-1 text-slate-400 font-bold';
        updateCategoryOptions();
    });

    // --- RENDER & KALKULASI DATA ---
    function renderDashboard() {
        let totalPemasukan = 0;
        let totalPengeluaran = 0;

        transactions.forEach(t => {
            if (t.type === 'Pemasukan') totalPemasukan += parseInt(t.amount);
            if (t.type === 'Pengeluaran') totalPengeluaran += parseInt(t.amount);
        });

        const sisaSaldo = totalPemasukan - totalPengeluaran;
        const usagePercent = budgetLimit > 0 ? Math.min(100, (totalPengeluaran / budgetLimit) * 100) : 0;

        // Update Teks Stat Panel
        document.getElementById('stat-saldo').innerText = `Rp ${sisaSaldo.toLocaleString('id-ID')}`;
        document.getElementById('stat-budget').innerText = budgetLimit > 0 ? `${usagePercent.toFixed(0)}% Terpakai` : 'No Limit';
        document.getElementById('stat-pemasukan').innerText = `+Rp ${totalPemasukan.toLocaleString('id-ID')}`;
        document.getElementById('stat-pengeluaran').innerText = `-Rp ${totalPengeluaran.toLocaleString('id-ID')}`;

        // Render List Transaksi dengan Filter
        transactionsList.innerHTML = '';
        const q = searchBox.value.toLowerCase();
        const f = filterType.value;
        const m = filterMonth.value;
        const s = document.getElementById('filter-start').value;
        const e = document.getElementById('filter-end').value;

        const filtered = transactions.filter(t => {
            const matchQ = t.description.toLowerCase().includes(q) || t.category.toLowerCase().includes(q);
            const matchF = f === 'Semua' || t.type === f;
            const matchM = m === 'Semua' || t.date.startsWith(m);
            
            let matchRange = true;
            if (s && e) matchRange = (t.date >= s && t.date <= e);
            else if (s) matchRange = (t.date >= s);
            else if (e) matchRange = (t.date <= e);

            return matchQ && matchF && matchM && matchRange;
        });

        if (filtered.length === 0) {
            transactionsList.innerHTML = `<div class="text-center py-4 border border-dashed border-gray-400 opacity-60">Catatan Kas Tidak Ditemukan</div>`;
            return;
        }

        filtered.forEach(tx => {
            const dateObj = new Date(tx.date);
            const humanDate = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

            const row = document.createElement('div');
            row.className = 'border p-2.5 flex justify-between items-center text-xs transition-colors';
            row.style.borderColor = 'var(--border-main)';
            row.innerHTML = `
                <div>
                    <p class="font-bold uppercase">${tx.description}</p>
                    <p class="text-[10px] opacity-50 font-bold">${tx.category} | ${humanDate}</p>
                </div>
                <div class="flex items-center gap-3">
                    <p class="font-bold mr-2 ${tx.type === 'Pemasukan' ? 'text-emerald-500' : 'text-red-500'}">
                        ${tx.type === 'Pemasukan' ? '+' : '-'}Rp ${parseInt(tx.amount).toLocaleString('id-ID')}
                    </p>
                    <button onclick="editTx('${tx.id}')" class="text-blue-500 hover:text-blue-700 font-bold cursor-pointer transition">[EDIT]</button>
                    <button onclick="deleteTx('${tx.id}', this)" class="text-gray-400 hover:text-red-500 font-bold cursor-pointer transition">[X]</button>
                </div>
            `;
            transactionsList.appendChild(row);
        });

        renderChart(filtered);
    }

    // Load transactions from server
    async function loadTransactions() {
        try {
            const res = await fetch('actions/transactions_get.php');
            const data = await res.json();
            if (Array.isArray(data)) {
                transactions = data;
                
                // Update Opsi Filter Bulan
                const currentMonthSelection = filterMonth.value;
                const uniqueMonths = [...new Set(transactions.map(t => t.date.substring(0, 7)))].sort().reverse();
                filterMonth.innerHTML = '<option value="Semua">SEMUA BULAN</option>';
                uniqueMonths.forEach(ym => {
                    const [y, monthStr] = ym.split('-');
                    const dateObj = new Date(y, parseInt(monthStr) - 1);
                    const monthName = dateObj.toLocaleString('id-ID', { month: 'short', year: 'numeric' });
                    const opt = document.createElement('option');
                    opt.value = ym;
                    opt.innerText = monthName.toUpperCase();
                    filterMonth.appendChild(opt);
                });
                if (uniqueMonths.includes(currentMonthSelection)) {
                    filterMonth.value = currentMonthSelection;
                }

                // Ekstrak kategori kustom dari riwayat transaksi
                transactions.forEach(t => {
                    if (t.type === 'Pengeluaran' && !categories['Pengeluaran'].includes(t.category)) {
                        categories['Pengeluaran'].push(t.category);
                    }
                    if (t.type === 'Pemasukan' && !categories['Pemasukan'].includes(t.category)) {
                        categories['Pemasukan'].push(t.category);
                    }
                });
                updateCategoryOptions();
                
                renderDashboard();
            }
        } catch (e) {
            console.error('Failed to load transactions');
        }
    }

    // Delete Transaksi (D)
    window.deleteTx = async function(id, btn) {
        if(!confirm('Hapus transaksi ini?')) return;
        const originalText = btn.innerText;
        btn.innerText = '[...]';
        try {
            const res = await fetch('actions/transaction_delete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            const data = await res.json();
            if (data.success) {
                transactions = transactions.filter(t => t.id != id);
                renderDashboard();
            }
        } catch (e) {
            console.error(e);
            btn.innerText = originalText;
        }
    }

    // Edit Transaksi (U)
    window.editTx = function(id) {
        const tx = transactions.find(t => t.id == id);
        if(!tx) return;
        
        editingTxId = tx.id;
        
        if(tx.type === 'Pemasukan') btnTypeMasuk.click();
        else btnTypeKeluar.click();
        
        setTimeout(() => {
            if(!Array.from(txCategory.options).some(opt => opt.value === tx.category)) {
                 const opt = document.createElement('option');
                 opt.value = tx.category; opt.innerText = tx.category;
                 txCategory.insertBefore(opt, txCategory.lastChild);
            }
            txCategory.value = tx.category;
        }, 10);
        
        document.getElementById('tx-amount').value = tx.amount;
        document.getElementById('tx-description').value = tx.description;
        
        const submitBtn = txForm.querySelector('button[type="submit"]');
        submitBtn.innerText = 'SIMPAN PERUBAHAN';
        submitBtn.className = 'w-full bg-blue-400 text-white font-bold py-1 border border-black retro-shadow-sm retro-shadow-active transition uppercase';
        
        txForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // --- SUBMIT TRANSAKSI BARU/UBAH (C/U) ---
    txForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const amt = parseInt(document.getElementById('tx-amount').value);
        const desc = document.getElementById('tx-description').value;
        const cat = txCategory.value;

        if (!amt || amt <= 0) return;

        const submitBtn = txForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerText;
        submitBtn.innerText = 'MENYIMPAN...';
        submitBtn.disabled = true;

        try {
            if (editingTxId) {
                const res = await fetch('actions/transaction_update.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: editingTxId, type: activeType, category: cat, amount: amt, description: desc })
                });
                const data = await res.json();
                if (data.success) {
                    const index = transactions.findIndex(t => t.id == editingTxId);
                    if (index > -1) {
                        transactions[index].type = activeType;
                        transactions[index].category = cat;
                        transactions[index].amount = amt;
                        transactions[index].description = desc;
                    }
                    editingTxId = null;
                    submitBtn.className = 'w-full bg-yellow-400 text-black font-bold py-1 border border-black retro-shadow-sm retro-shadow-active transition uppercase';
                }
            } else {
                const res = await fetch('actions/transaction_create.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ type: activeType, category: cat, amount: amt, description: desc })
                });
                const data = await res.json();
                if (data.success) {
                    transactions.unshift({
                        id: data.id, type: activeType, category: cat, amount: amt,
                        date: new Date().toISOString().split('T')[0], description: desc
                    });
                }
            }
            document.getElementById('tx-amount').value = '';
            document.getElementById('tx-description').value = '';
            renderDashboard();
        } catch(e) {
            console.error(e);
        } finally {
            submitBtn.innerText = editingTxId ? 'SIMPAN PERUBAHAN' : 'KIRIM';
            submitBtn.disabled = false;
        }
    });

    // --- CONTROL EVENT LISTENERS ---
    let debounceTimer;
    budgetSlider.addEventListener('input', (e) => {
        budgetLimit = parseInt(e.target.value);
        budgetLimitText.innerText = `Target: Rp ${budgetLimit.toLocaleString('id-ID')}`;
        renderDashboard();

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(async () => {
            try {
                await fetch('actions/budget_update.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ budgetLimit })
                });
            } catch(err) {
                console.error(err);
            }
        }, 500);
    });

    searchBox.addEventListener('input', renderDashboard);
    filterType.addEventListener('change', renderDashboard);
    filterMonth.addEventListener('change', renderDashboard);

    // Initial load
    loadTransactions();

    // --- CHART LOGIC ---
    let expenseChartInstance = null;
    function renderChart(dataToChart = transactions) {
        const ctx = document.getElementById('expenseChart').getContext('2d');
        const typeSelect = document.getElementById('chart-type').value;
        const expenseData = {};
        
        dataToChart.forEach(t => {
            if (t.type === 'Pengeluaran') {
                expenseData[t.category] = (expenseData[t.category] || 0) + parseInt(t.amount);
            }
        });

        const labels = Object.keys(expenseData);
        const data = Object.values(expenseData);

        if (expenseChartInstance) {
            expenseChartInstance.destroy();
        }

        const isDark = document.documentElement.classList.contains('dark') || document.body.classList.contains('dark');
        const textColor = isDark ? '#ffffff' : '#000000';
        const borderColor = isDark ? '#333333' : '#e5e7eb'; // For grid lines, softer
        const axisColor = isDark ? '#ffffff' : '#000000'; // For text/borders

        expenseChartInstance = new Chart(ctx, {
            type: typeSelect,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pengeluaran (Rp)',
                    data: data,
                    backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#ec4899', '#06b6d4'],
                    borderColor: axisColor,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { 
                        position: 'bottom', 
                        labels: { 
                            color: textColor, 
                            font: { family: "sans-serif", size: 11, weight: 'bold' } 
                        } 
                    }
                },
                scales: (typeSelect === 'bar' || typeSelect === 'line') ? {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor, font: { family: "sans-serif", size: 10, weight: 'bold' } },
                        grid: { color: borderColor }
                    },
                    x: {
                        ticks: { color: textColor, font: { family: "sans-serif", size: 10, weight: 'bold' } },
                        grid: { color: borderColor }
                    }
                } : {}
            }
        });
    }

    // --- PDF EXPORT LOGIC ---
    function exportPDF() {
        const q = searchBox.value.toLowerCase();
        const f = filterType.value;
        const m = filterMonth.value;

        const periodeTeks = filterMonth.options[filterMonth.selectedIndex].text;

        const filtered = transactions.filter(t => {
            const matchQ = t.description.toLowerCase().includes(q) || t.category.toLowerCase().includes(q);
            const matchF = f === 'Semua' || t.type === f;
            const matchM = m === 'Semua' || t.date.startsWith(m);
            return matchQ && matchF && matchM;
        });

        if (filtered.length === 0) {
            alert('Tidak ada data transaksi untuk dicetak pada filter ini!');
            return;
        }

        let totalPemasukan = 0;
        let totalPengeluaran = 0;
        filtered.forEach(t => {
            if (t.type === 'Pemasukan') totalPemasukan += parseInt(t.amount);
            if (t.type === 'Pengeluaran') totalPengeluaran += parseInt(t.amount);
        });
        let hasilBersih = totalPemasukan - totalPengeluaran;
        let hasilBersihTeks = hasilBersih >= 0 ? '+Rp ' + hasilBersih.toLocaleString('id-ID') : '-Rp ' + Math.abs(hasilBersih).toLocaleString('id-ID');

        const element = document.createElement('div');
        element.innerHTML = `
            <div style="font-family: monospace; padding: 20px; color: #000; background: #fff;">
                <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 5px; border-bottom: 2px solid #000; padding-bottom: 10px;">LAPORAN POCKET_LEDGER</h2>
                <div style="margin-bottom: 20px; font-weight: bold; display: flex; justify-content: space-between;">
                    <div>
                        <p>Periode: ${periodeTeks}</p>
                        <p>Jenis: ${f === 'Semua' ? 'Semua Transaksi' : f}</p>
                    </div>
                    <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}</p>
                </div>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;" border="1">
                    <tr style="background-color: #f3f4f6;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #000;">Tanggal</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #000;">Keterangan</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #000;">Kategori</th>
                        <th style="padding: 8px; text-align: right; border: 1px solid #000;">Pemasukan</th>
                        <th style="padding: 8px; text-align: right; border: 1px solid #000;">Pengeluaran</th>
                    </tr>
                    ${filtered.map(t => `
                    <tr>
                        <td style="padding: 8px; border: 1px solid #000;">${t.date}</td>
                        <td style="padding: 8px; border: 1px solid #000;">${t.description}</td>
                        <td style="padding: 8px; border: 1px solid #000;">${t.category}</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #000;">${t.type === 'Pemasukan' ? 'Rp ' + parseInt(t.amount).toLocaleString('id-ID') : '-'}</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #000;">${t.type === 'Pengeluaran' ? 'Rp ' + parseInt(t.amount).toLocaleString('id-ID') : '-'}</td>
                    </tr>
                    `).join('')}
                    <tr style="background-color: #f3f4f6; font-weight: bold;">
                        <td colspan="3" style="padding: 8px; text-align: right; border: 1px solid #000;">TOTAL (${periodeTeks.toUpperCase()})</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #000;">Rp ${totalPemasukan.toLocaleString('id-ID')}</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #000;">Rp ${totalPengeluaran.toLocaleString('id-ID')}</td>
                    </tr>
                    <tr style="background-color: #e5e7eb; font-weight: bold; font-size: 13px;">
                        <td colspan="3" style="padding: 8px; text-align: right; border: 1px solid #000;">HASIL BERSIH ${periodeTeks.toUpperCase()} (Pemasukan - Pengeluaran)</td>
                        <td colspan="2" style="padding: 8px; text-align: center; border: 1px solid #000; color: ${hasilBersih >= 0 ? '#15803d' : '#dc2626'};">${hasilBersihTeks}</td>
                    </tr>
                </table>
                <p style="margin-top: 20px; font-size: 10px; text-align: center;">Di-generate secara otomatis oleh PocketLedger Web App.</p>
            </div>
        `;

        const filename_pdf = m === 'Semua' ? 'Laporan_PocketLedger_Semua.pdf' : `Laporan_PocketLedger_${periodeTeks.replace(' ', '_')}.pdf`;

        html2pdf().from(element).set({
            margin: 10,
            filename: filename_pdf,
            html2canvas: { scale: 2 },
            jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
        }).save();
    }

    // --- EXCEL/CSV EXPORT LOGIC ---
    function exportCSV() {
        const q = searchBox.value.toLowerCase();
        const f = filterType.value;
        const m = filterMonth.value;
        const s = document.getElementById('filter-start').value;
        const e = document.getElementById('filter-end').value;

        const filtered = transactions.filter(t => {
            const matchQ = t.description.toLowerCase().includes(q) || t.category.toLowerCase().includes(q);
            const matchF = f === 'Semua' || t.type === f;
            const matchM = m === 'Semua' || t.date.startsWith(m);
            let matchRange = true;
            if (s && e) matchRange = (t.date >= s && t.date <= e);
            else if (s) matchRange = (t.date >= s);
            else if (e) matchRange = (t.date <= e);
            return matchQ && matchF && matchM && matchRange;
        });

        if (filtered.length === 0) {
            alert('Tidak ada data transaksi untuk diekspor!');
            return;
        }

        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Tanggal,Keterangan,Kategori,Jenis,Nominal(Rp)\n";
        
        filtered.forEach(t => {
            let desc = t.description.replace(/"/g, '""'); // escape quotes
            let row = `${t.date},"${desc}","${t.category}",${t.type},${t.amount}`;
            csvContent += row + "\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `PocketLedger_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // --- KALKULATOR LOGIC ---
    let calcStr = "";
    const calcDisplay = document.getElementById('calc-display');
    function calcInput(val) {
        if (calcStr === "Error") calcStr = "";
        calcStr += val;
        calcDisplay.innerText = calcStr;
    }
    function calcClear() {
        calcStr = "";
        calcDisplay.innerText = "0";
    }
    function calcEval() {
        try {
            if (/^[0-9+\-*/.]*$/.test(calcStr)) {
                const result = new Function('return ' + calcStr)();
                calcStr = result.toString();
                calcDisplay.innerText = calcStr;
            }
        } catch(e) {
            calcStr = "Error";
            calcDisplay.innerText = "Error";
        }
    }

    // --- TIPS LOGIC ---
    const tipsArray = [
        "Catat pengeluaran sekecil apapun, bahkan uang parkir 2 ribu perak!",
        "Kurangi jajan kopi di luar. Bikin kopi sendiri bisa hemat ratusan ribu sebulan.",
        "Sebelum beli barang, terapkan aturan 24 jam. Yakin masih butuh besok?",
        "Prioritaskan bayar tagihan wajib sebelum budget untuk bersenang-senang.",
        "Sisihkan uang tabungan di awal bulan, bukan dari sisa akhir bulan.",
        "Promo diskon bukan berarti hemat, kalau sebenarnya kamu nggak butuh barangnya.",
        "Bawa botol minum sendiri saat keluar. Hemat uang air mineral!",
        "Gunakan fitur limit anggaran di aplikasi ini agar tidak over-budget."
    ];

    function changeTip() {
        const randomIndex = Math.floor(Math.random() * tipsArray.length);
        document.getElementById('tips-text').innerText = tipsArray[randomIndex];
    }
    changeTip();
</script>

<?php include 'includes/footer.php'; ?>
