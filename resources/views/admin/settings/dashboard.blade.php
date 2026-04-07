<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Settings - PinkTravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif
</head>
<body class="font-poppins bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-gray-900">
                        ✈️ PinkTravel Admin
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">⚙️ Pengaturan Perusahaan</h1>
                    <p class="text-gray-600 mt-2">Kelola informasi dan konfigurasi perusahaan</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition font-semibold">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Settings by Category -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- General Settings -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">📋 Pengaturan Umum</h2>
                    </div>
                    <div class="p-6 space-y-6" id="general-settings">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </div>
                </div>

                <!-- Contact Settings -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">📞 Kontak Perusahaan</h2>
                    </div>
                    <div class="p-6 space-y-6" id="contact-settings">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </div>
                </div>

                <!-- Social Media Settings -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">📱 Social Media</h2>
                    </div>
                    <div class="p-6 space-y-6" id="social-settings">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">💳 Pengaturan Pembayaran</h2>
                    </div>
                    <div class="p-6 space-y-6" id="payment-settings">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">📧 Email</h2>
                    </div>
                    <div class="p-6 space-y-6" id="email-settings">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allSettings = {};

        document.addEventListener('DOMContentLoaded', function() {
            loadSettings();
        });

        async function loadSettings() {
            try {
                const response = await fetch('/api/settings');
                const settings = await response.json();

                // Group settings by category
                allSettings = settings.reduce((acc, setting) => {
                    if (!acc[setting.category]) {
                        acc[setting.category] = [];
                    }
                    acc[setting.category].push(setting);
                    return acc;
                }, {});

                // Render each category
                renderSettings('general');
                renderSettings('contact');
                renderSettings('social');
                renderSettings('payment');
                renderSettings('email');
            } catch (error) {
                console.error('Error loading settings:', error);
            }
        }

        function renderSettings(category) {
            const container = document.getElementById(`${category}-settings`);
            const settings = allSettings[category] || [];

            if (settings.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-8">Tidak ada pengaturan</p>';
                return;
            }

            container.innerHTML = settings.map(setting => `
                <div class="border-b pb-6 last:border-b-0">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        ${setting.label || setting.key}
                    </label>
                    ${setting.type === 'text' ? `
                        <textarea 
                            id="setting-${setting.id}" 
                            value="${setting.value}" 
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-600"
                        >${setting.value}</textarea>
                    ` : setting.type === 'boolean' ? `
                        <select id="setting-${setting.id}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-600">
                            <option value="1" ${setting.value === '1' || setting.value === 'true' ? 'selected' : ''}>Aktif</option>
                            <option value="0" ${setting.value === '0' || setting.value === 'false' ? 'selected' : ''}>Tidak Aktif</option>
                        </select>
                    ` : `
                        <input 
                            type="${setting.type === 'number' ? 'number' : 'text'}" 
                            id="setting-${setting.id}" 
                            value="${setting.value}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-600"
                        >
                    `}
                    ${setting.description ? `<p class="text-xs text-gray-500 mt-1">${setting.description}</p>` : ''}
                    <button onclick="updateSetting(${setting.id})" class="mt-2 px-4 py-2 bg-teal-600 text-white rounded font-semibold hover:bg-teal-700 transition text-sm">
                        Simpan
                    </button>
                </div>
            `).join('');
        }

        async function updateSetting(id) {
            try {
                const input = document.getElementById(`setting-${id}`);
                const value = input.value;

                // Find the setting to get its type
                let settingType = 'string';
                for (const category in allSettings) {
                    const setting = allSettings[category].find(s => s.id === id);
                    if (setting) {
                        settingType = setting.type;
                        break;
                    }
                }

                const response = await fetch(`/api/settings/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    },
                    body: JSON.stringify({
                        value: value,
                        type: settingType,
                    }),
                });

                if (response.ok) {
                    alert('Pengaturan berhasil disimpan!');
                    loadSettings();
                } else {
                    alert('Gagal menyimpan pengaturan');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal menyimpan pengaturan');
            }
        }
    </script>
</body>
</html>
