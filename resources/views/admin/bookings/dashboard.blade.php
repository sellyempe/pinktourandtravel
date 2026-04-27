<x-admin-layout title="Manajemen Booking" active="bookings">

    {{-- Summary Cards --}}
    @php
    $statusCfg = [
        'all'       => ['label' => 'Total',        'color' => 'gray',   'icon' => '📋'],
        'pending'   => ['label' => 'Pending',       'color' => 'yellow', 'icon' => '⏳'],
        'confirmed' => ['label' => 'Dikonfirmasi',  'color' => 'green',  'icon' => '✅'],
        'completed' => ['label' => 'Selesai',       'color' => 'blue',   'icon' => '🏁'],
        'cancelled' => ['label' => 'Dibatalkan',    'color' => 'red',    'icon' => '❌'],
    ];
    $totalAll = $counts->sum();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
        @foreach($statusCfg as $key => $cfg)
        <a href="{{ route('admin.bookings.dashboard', ['status' => $key]) }}"
           class="bg-gray-900 border rounded-2xl p-4 text-center transition
                  {{ $status === $key ? 'border-pink-500/50 bg-pink-500/5' : 'border-white/5 hover:border-white/10' }}">
            <p class="text-2xl mb-1">{{ $cfg['icon'] }}</p>
            <p class="text-2xl font-bold text-white">{{ $key === 'all' ? $totalAll : ($counts[$key] ?? 0) }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $cfg['label'] }}</p>
        </a>
        @endforeach
    </div>

    {{-- Filter Pills --}}
    <div class="flex flex-wrap gap-2 mb-5">
        @foreach($statusCfg as $key => $cfg)
        <a href="{{ route('admin.bookings.dashboard', ['status' => $key]) }}"
           class="px-4 py-1.5 rounded-full text-xs font-semibold transition
                  {{ $status === $key ? 'bg-pink-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white' }}">
            {{ $cfg['label'] }}
        </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-left">
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trip</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.03]">
                @forelse($bookings as $booking)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-5 py-4 font-mono text-xs text-gray-500">{{ Str::limit($booking->order_id, 16) }}</td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white text-sm">{{ $booking->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->user->email ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-200 text-sm">{{ Str::limit($booking->trip->title ?? '-', 30) }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->trip->departure_city ?? '' }} → {{ $booking->trip->destination ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="font-bold text-white">{{ $booking->participants }}</span>
                        <span class="text-gray-600 text-xs">org</span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        {{ $booking->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        @php
                        $badge = match($booking->status) {
                            'confirmed' => 'bg-emerald-500/10 text-emerald-400',
                            'pending'   => 'bg-yellow-500/10 text-yellow-400',
                            'completed' => 'bg-blue-500/10 text-blue-400',
                            'cancelled' => 'bg-red-500/10 text-red-400',
                            default     => 'bg-gray-500/10 text-gray-400',
                        };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if($booking->status === 'confirmed')
                        <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}"
                              onsubmit="return confirm('Tandai booking ini sebagai selesai?')">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 text-xs font-semibold rounded-lg transition">
                                ✅ Selesai
                            </button>
                        </form>
                        @else
                            <span class="text-gray-700 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <div class="text-4xl mb-3">📋</div>
                        <p class="text-gray-500">Tidak ada booking dengan filter ini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $bookings->links() }}
    </div>
    @endif

</x-admin-layout>