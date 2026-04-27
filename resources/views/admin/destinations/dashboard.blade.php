<x-admin-layout title="Kelola Destinasi" active="destinations">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-white">Destinasi Wisata</h2>
            <p class="text-sm text-gray-500">{{ $destinations->count() }} destinasi terdaftar</p>
        </div>
        <a href="{{ route('admin.destinations.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-pink-600 hover:bg-pink-500 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-pink-600/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Destinasi
        </a>
    </div>

    {{-- Grid Kartu Destinasi --}}
    @if($destinations->isEmpty())
        <div class="bg-gray-900 border border-white/5 rounded-2xl py-20 text-center">
            <div class="text-5xl mb-4">📍</div>
            <p class="text-gray-500 font-medium">Belum ada destinasi</p>
            <a href="{{ route('admin.destinations.create') }}" class="inline-block mt-3 text-pink-400 hover:text-pink-300 text-sm font-medium">
                + Tambah destinasi pertama
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($destinations as $destination)
            <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden group hover:border-pink-500/30 transition-colors">
                {{-- Thumbnail --}}
                <div class="relative h-44 bg-gray-800">
                    @if($destination->image)
                        <img src="{{ $destination->image }}" alt="{{ $destination->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl text-gray-700">📍</div>
                    @endif
                    {{-- Status badge --}}
                    <div class="absolute top-3 right-3">
                        @if($destination->status === 'active')
                            <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full backdrop-blur-sm border border-emerald-500/30">Aktif</span>
                        @else
                            <span class="px-2.5 py-1 bg-gray-500/40 text-gray-300 text-xs font-bold rounded-full backdrop-blur-sm">Nonaktif</span>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-bold text-white text-sm mb-0.5">{{ $destination->name }}</h3>
                    <p class="text-xs text-pink-400 flex items-center gap-1 mb-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $destination->location }}
                    </p>
                    <p class="text-gray-500 text-xs line-clamp-2">{{ $destination->description }}</p>
                </div>

                {{-- Actions --}}
                <div class="px-4 pb-4 flex gap-2">
                    <a href="{{ route('admin.destinations.edit', $destination->id) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 text-xs font-semibold rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.destinations.destroy', $destination->id) }}"
                          onsubmit="return confirm('Hapus destinasi {{ addslashes($destination->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center justify-center gap-1.5 px-3 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</x-admin-layout>