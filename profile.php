<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'includes/header.php';
?>
<div class="flex-col flex-grow flex" id="main-app">
    <!-- HEADER -->
    <header class="border-b-2 border-[var(--border-main)] py-3 px-4" style="background-color: var(--bg-card)">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black pixel-text leading-none flex items-center gap-2">
                    <span class="text-3xl">💰</span> PROFIL SAYA
                </h1>
                <p class="text-[8px] opacity-60 font-bold uppercase tracking-widest"><?= htmlspecialchars($_SESSION['username']) ?></p>
            </div>
            <div class="flex gap-2">
                <a href="index.php" class="text-xs bg-yellow-400 text-black font-bold border-2 border-black px-2 py-1 retro-shadow-sm retro-shadow-active block">KEMBALI</a>
            </div>
        </div>
    </header>

    <!-- DASHBOARD CONTAINER -->
    <main class="flex-grow max-w-xl mx-auto w-full px-4 py-8">
        <div class="border-2 border-[var(--border-main)] p-6 retro-shadow" style="background-color: var(--bg-card)">
            <h2 class="font-bold text-xl mb-4 uppercase border-b-2 border-[var(--border-main)] pb-2">Ubah Password</h2>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="p-2 mb-4 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-200 border border-red-300 dark:border-red-800 text-center text-xs font-bold">⚠️ <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="p-2 mb-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-200 border border-green-300 dark:border-green-800 text-center text-xs font-bold">✅ <?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <form action="actions/auth_change_password.php" method="POST" class="space-y-4 text-xs font-bold">
                <div>
                    <label class="block mb-1">PASSWORD LAMA</label>
                    <input type="password" name="old_password" required class="w-full p-2 outline-none">
                </div>
                <div>
                    <label class="block mb-1">PASSWORD BARU</label>
                    <input type="password" name="new_password" required class="w-full p-2 outline-none">
                </div>
                <div>
                    <label class="block mb-1">KONFIRMASI PASSWORD BARU</label>
                    <input type="password" name="confirm_password" required class="w-full p-2 outline-none">
                </div>
                <button type="submit" class="w-full bg-black text-white dark:bg-white dark:text-black font-bold py-2 border-2 border-[var(--border-main)] retro-shadow-sm retro-shadow-active uppercase tracking-widest mt-2">SIMPAN PERUBAHAN</button>
            </form>
        </div>

        <!-- DANGER ZONE -->
        <div class="border-2 border-red-500 p-6 retro-shadow mt-6 bg-red-50 dark:bg-red-950/20">
            <h2 class="font-bold text-xl mb-2 uppercase text-red-600 dark:text-red-500">Hapus Akun Permanen</h2>
            <p class="text-xs mb-4 font-bold text-gray-700 dark:text-gray-300">Peringatan: Seluruh data riwayat arus kas dan akun Anda akan dihapus selamanya. Tindakan ini tidak dapat dibatalkan.</p>
            <form action="actions/auth_delete_account.php" method="POST" onsubmit="return confirm('⚠️ PERINGATAN KRITIKAL ⚠️\n\nApakah Anda benar-benar yakin ingin menghapus akun ini beserta seluruh data transaksinya?\n\nTekan OK untuk Hapus Permanen.');">
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 border-2 border-black retro-shadow-sm retro-shadow-active uppercase tracking-widest transition-colors">HAPUS AKUN SAYA SEKARANG</button>
            </form>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>
