<x-admin-layout title="Edit Destinasi" active="destinations">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.destinations.dashboard') }}" class="hover:text-white transition">Destinasi</a>
        <span>/</span>
        <span class="text-gray-300">Edit: {{ Str::limit($destination->name, 40) }}</span>
    </nav>

    <form method="POST" action="{{ route('admin.destinations.update', $destination->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Kiri --}}
            <div class="xl:col-span-2 space-y-5">
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Informasi Destinasi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Destinasi <span class="text-pink-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $destination->name) }}"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Lokasi <span class="text-pink-500">*</span></label>
                            <input type="text" name="location" value="{{ old('location', $destination->location) }}"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                            @error('location')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Kategori <span class="text-pink-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category', $destination->category) }}"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                            @error('category')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Fakta Menarik <span class="text-pink-500">*</span></label>
                            <textarea name="interesting_fact" rows="3"
                                      class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none" required>{{ old('interesting_fact', $destination->interesting_fact) }}</textarea>
                            @error('interesting_fact')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi <span class="text-pink-500">*</span></label>
                            <textarea name="description" rows="6"
                                      class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none" required>{{ old('description', $destination->description) }}</textarea>
                            @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div class="space-y-5">

                {{-- Foto --}}
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Foto Destinasi</h3>
                    <div class="relative rounded-xl overflow-hidden bg-gray-800 cursor-pointer group h-48"
                         onclick="document.getElementById('imageInput').click()">
                        @if($destination->image)
                            <img id="imagePreview" src="{{ $destination->image }}" alt="{{ $destination->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div id="imagePreview" class="w-full h-full flex flex-col items-center justify-center">
                                <span class="text-5xl mb-2">📍</span>
                                <p class="text-gray-600 text-sm">Belum ada foto</p>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                            <p class="text-white text-sm font-medium">🖼 Ganti Foto</p>
                        </div>
                    </div>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                    <p class="text-xs text-gray-600 mt-2 text-center">Biarkan kosong untuk mempertahankan foto lama</p>
                    @error('image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status --}}
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Publikasi</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/5 transition">
                            <input type="radio" name="status" value="active" {{ old('status', $destination->status) === 'active' ? 'checked' : '' }} class="accent-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-white">Aktif</p>
                                <p class="text-xs text-gray-500">Tampil di website</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-gray-500/50 has-[:checked]:bg-gray-500/5 transition">
                            <input type="radio" name="status" value="inactive" {{ old('status', $destination->status) === 'inactive' ? 'checked' : '' }} class="accent-gray-500">
                            <div>
                                <p class="text-sm font-medium text-white">Nonaktif</p>
                                <p class="text-xs text-gray-500">Disembunyikan</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-pink-600 hover:bg-pink-500 text-white font-semibold rounded-xl transition shadow-lg shadow-pink-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.destinations.dashboard') }}"
                   class="block w-full text-center px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>

    <script>
    function previewImage(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById('imagePreview');
            if (el.tagName === 'IMG') {
                el.src = e.target.result;
            } else {
                el.outerHTML = `<img id="imagePreview" src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
    </script>

</x-admin-layout>