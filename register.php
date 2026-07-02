<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
include __DIR__ . '/includes/header.php';
?>
<div class="flex-grow flex items-center justify-center px-4 relative overflow-hidden py-14" style="background-image: radial-gradient(rgba(140, 140, 140, 0.35) 1.5px, transparent 1.5px), linear-gradient(to right, rgba(140, 140, 140, 0.15) 1px, transparent 1px), linear-gradient(to bottom, rgba(140, 140, 140, 0.15) 1px, transparent 1px); background-size: 16px 16px, 32px 32px, 32px 32px;">
    <!-- Decorative Background Badges -->
    <div class="absolute top-6 left-6 md:left-12 flex items-center gap-2 border-2 border-[var(--border-main)] bg-cyan-400 text-black px-3 py-1 font-bold text-xs retro-shadow -rotate-2 select-none pointer-events-none">
        <span>📝 CREATE PORTAL</span>
    </div>
    <div class="absolute top-8 right-6 md:right-16 flex items-center gap-1 border-2 border-[var(--border-main)] bg-orange-400 text-black px-3 py-1 font-bold text-xs retro-shadow rotate-6 select-none pointer-events-none">
        <span>⭐ NEW MEMBER</span>
    </div>
    <div class="absolute top-1/4 left-4 md:left-20 hidden lg:block border-2 border-[var(--border-main)] bg-yellow-400 text-black px-3 py-2 font-bold text-xs retro-shadow -rotate-3 select-none pointer-events-none">
        <span class="block text-sm">🔐 VAULT SECURITY</span>
        <span class="text-[9px] block">ISOLATED USER SESSION</span>
    </div>
    <div class="absolute top-1/3 right-6 md:right-24 hidden lg:block border-2 border-[var(--border-main)] bg-pink-400 text-black px-3 py-2 font-bold text-xs retro-shadow rotate-12 select-none pointer-events-none">
        <span class="block text-sm">✨ FULL ACCESS</span>
        <span class="text-[9px] block">INSTANT LEDGER SETUP</span>
    </div>
    <div class="absolute bottom-16 left-6 md:left-16 hidden md:block border-2 border-[var(--border-main)] bg-purple-400 text-black p-3 font-bold text-xs retro-shadow rotate-3 select-none pointer-events-none">
        <span class="block text-lg font-black">🔒 VAULT INIT</span>
        <span class="text-[9px] block">MULTI-USER ENVIRONMENT</span>
    </div>
    <div class="absolute bottom-12 right-6 md:right-20 flex items-center gap-1 border-2 border-[var(--border-main)] bg-white dark:bg-gray-800 text-[var(--text-main)] px-3 py-1.5 font-bold text-xs retro-shadow -rotate-3 select-none pointer-events-none">
        <span>STATUS: REGISTRATION 📝</span>
    </div>
    <!-- Geometric Scattered Shapes -->
    <div class="absolute top-12 left-1/3 w-6 h-6 border-2 border-[var(--border-main)] bg-emerald-400 retro-shadow -rotate-12 select-none pointer-events-none opacity-80 hidden sm:block"></div>
    <div class="absolute bottom-20 right-1/3 w-8 h-8 rounded-full border-2 border-[var(--border-main)] bg-cyan-300 retro-shadow select-none pointer-events-none opacity-80 hidden sm:block"></div>
    <div class="absolute top-1/2 left-8 w-4 h-4 border-2 border-[var(--border-main)] bg-yellow-400 select-none pointer-events-none opacity-70 hidden md:block"></div>
    <div class="absolute top-2/3 right-12 w-5 h-5 border-2 border-[var(--border-main)] bg-red-400 rotate-45 select-none pointer-events-none opacity-75 hidden md:block"></div>

    <div class="max-w-sm w-full border-2 border-[var(--border-main)] p-6 retro-shadow text-center transition-colors duration-200 relative z-10" style="background-color: var(--bg-card)">
        <span class="text-4xl block mb-1">📝</span>
        <h2 class="pixel-text text-3xl font-bold tracking-wider leading-none mb-4">DAFTAR KAS BARU</h2>
        <form action="actions/auth_register.php" method="POST" class="space-y-4 text-left text-xs font-bold">
            <?php if (isset($_GET['error'])): ?>
                <div class="p-2 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-200 border border-red-300 dark:border-red-800 text-center">⚠️ <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            <div>
                <label class="block mb-1">USERNAME</label>
                <input type="text" name="username" class="w-full p-1.5 outline-none" placeholder="Buat Username" required>
            </div>
            <div>
                <label class="block mb-1">PASSWORD</label>
                <div class="relative">
                    <input type="password" name="password" id="password-register" class="w-full p-1.5 outline-none pr-10" placeholder="Buat Password" required>
                    <button type="button" onclick="togglePassword('password-register', 'eye-register')" class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center cursor-pointer opacity-70 hover:opacity-100 transition-opacity" style="height: 100%;">
                        <span id="eye-register" class="text-sm">👁️</span>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-yellow-400 text-black font-bold py-2 border-2 border-black retro-shadow-sm retro-shadow-active uppercase tracking-widest">REGISTER CABINET</button>
        </form>
        <div class="mt-4 border-2 border-dashed border-gray-400 dark:border-gray-600 p-2.5 text-[10px] text-gray-500 dark:text-gray-400 text-center font-bold">
            Sudah punya akun? <a href="login.php" class="text-yellow-600 dark:text-yellow-400 underline hover:text-yellow-500">Login</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
