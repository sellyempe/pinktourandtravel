<nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50" style="scroll-behavior: smooth;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section - Left -->
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold text-gray-900">
                    ✈️ PinkTravel
                </a>
            </div>

            <!-- Menu Section - Right -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-8">
                    <a href="/" onclick="handleNavClick(event, 'beranda')" class="text-gray-700 hover:text-gray-900 font-medium transition duration-200 cursor-pointer">
                        Beranda
                    </a>
                    <a href="/" onclick="handleNavClick(event, 'trips')" class="text-gray-700 hover:text-gray-900 font-medium transition duration-200 cursor-pointer">
                        Trips
                    </a>
                    <a href="/" onclick="handleNavClick(event, 'destinasi')" class="text-gray-700 hover:text-gray-900 font-medium transition duration-200 cursor-pointer">
                        Destinasi
                    </a>
                    <a href="/" onclick="handleNavClick(event, 'kontak')" class="text-gray-700 hover:text-gray-900 font-medium transition duration-200 cursor-pointer">
                        Kontak
                    </a>

                    <!-- Auth Links -->
                    <div class="flex items-center space-x-4 ml-4 pl-4 border-l border-gray-200">
                        @auth
                            <div class="relative group">
                                <button class="text-gray-700 hover:text-gray-900 font-medium transition duration-200 flex items-center space-x-1">
                                    <span>{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">
                                        Profile
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                        Pengaturan
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg text-red-600 hover:text-red-700">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium transition duration-200">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition duration-200">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
function handleNavClick(event, sectionId) {
    event.preventDefault();
    
    // Check if kita sudah di homepage
    if (window.location.pathname === '/' || window.location.pathname === '') {
        // Sudah di home, langsung scroll ke section
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    } else {
        // Di page lain, redirect ke home dengan anchor
        window.location.href = '/#' + sectionId;
    }
}
</script>
