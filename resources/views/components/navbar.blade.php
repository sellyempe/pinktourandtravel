<nav id="mainNav" class="fixed top-0 left-0 right-0 z-50" style="background: transparent;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- ── Logo ────────────────────────────────────────────── --}}
            <a href="/" class="flex items-center gap-2.5 group flex-shrink-0">
                <div class="w-9 h-9 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg shadow-pink-500/30 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span id="logoText" class="text-xl font-bold">PinkTravel</span>
            </a>

            {{-- ── Desktop Menu ─────────────────────────────────────── --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="/" onclick="handleNavClick(event,'beranda')" class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Beranda<span class="nav-link-underline"></span>
                </a>
                <a href="/" onclick="handleNavClick(event,'trips')" class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Trips<span class="nav-link-underline"></span>
                </a>
                <a href="/" onclick="handleNavClick(event,'destinasi')" class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Destinasi<span class="nav-link-underline"></span>
                </a>
                <a href="/" onclick="handleNavClick(event,'kontak')" class="nav-link relative px-4 py-2 font-medium text-sm cursor-pointer">
                    Kontak<span class="nav-link-underline"></span>
                </a>

                <div class="nav-divider w-px h-5 mx-2"></div>

                @auth
                    {{-- User Dropdown --}}
                    <div class="relative group">
                        <button class="nav-user-btn flex items-center gap-2 px-3 py-2 font-medium text-sm">
                            <div class="w-7 h-7 rounded-full bg-pink-500 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Str::limit(auth()->user()->name, 12) }}</span>
                            <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        {{-- Dropdown --}}
                        <div class="absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100
                                    opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                    translate-y-2 group-hover:translate-y-0 transition-all duration-200 overflow-hidden z-50">
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Masuk sebagai</p>
                                <p class="font-semibold text-gray-900 text-sm truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('user.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Dashboard Saya
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Admin Panel
                            </a>
                            @endif
                            <div class="border-t border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-auth-link px-4 py-2 font-medium text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 bg-pink-600 hover:bg-pink-500 text-white rounded-xl font-semibold text-sm
                              transition-all shadow-lg shadow-pink-600/25 hover:-translate-y-0.5">
                        Daftar Gratis
                    </a>
                @endauth
            </div>

            {{-- ── Mobile Hamburger ────────────────────────────────── --}}
            <button id="mobileMenuBtn" onclick="toggleMobileMenu()"
                    class="md:hidden p-2 rounded-xl hover:bg-white/10 transition">
                <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ── Mobile Menu ──────────────────────────────────────────── --}}
    <div id="mobileMenu" class="hidden md:hidden bg-gray-900/95 backdrop-blur-xl border-t border-white/10 px-4 py-4 space-y-1">
        <a href="/" onclick="handleNavClick(event,'beranda')" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">🏠 Beranda</a>
        <a href="/" onclick="handleNavClick(event,'trips')"   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">✈️ Trips</a>
        <a href="/" onclick="handleNavClick(event,'destinasi')" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">📍 Destinasi</a>
        <a href="/" onclick="handleNavClick(event,'kontak')"  class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">📞 Kontak</a>
        <div class="pt-2 border-t border-white/10 space-y-2">
            @auth
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 font-medium transition">👤 Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 font-medium transition">🚪 Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}"    class="block px-4 py-3 rounded-xl text-center text-gray-300 hover:bg-white/10 font-medium transition">Masuk</a>
                <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl text-center bg-pink-600 hover:bg-pink-500 text-white font-semibold transition">Daftar Gratis</a>
            @endauth
        </div>
    </div>
</nav>

<script>
const mainNav = document.getElementById('mainNav');

function handleScroll() {
    if (window.scrollY > 60) {
        mainNav.classList.add('scrolled');
    } else {
        mainNav.classList.remove('scrolled');
    }
}
window.addEventListener('scroll', handleScroll, { passive: true });
handleScroll();

function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const h = document.getElementById('hamburgerIcon');
    const c = document.getElementById('closeIcon');
    const open = menu.classList.contains('hidden');
    menu.classList.toggle('hidden', !open);
    h.classList.toggle('hidden', open);
    c.classList.toggle('hidden', !open);
}

function handleNavClick(event, sectionId) {
    event.preventDefault();
    document.getElementById('mobileMenu').classList.add('hidden');
    document.getElementById('hamburgerIcon').classList.remove('hidden');
    document.getElementById('closeIcon').classList.add('hidden');
    if (window.location.pathname === '/' || window.location.pathname === '') {
        const el = document.getElementById(sectionId);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    } else {
        window.location.href = '/#' + sectionId;
    }
}
</script>