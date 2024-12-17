<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Denda') }}
        </h2>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Unpaid Fines Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Unpaid Fines</h3>
                    @if ($dendas->where('is_paid', 0)->isEmpty())
                        <p>You have no unpaid denda.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowing Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Late</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($dendas->where('is_paid', false) as $denda)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->peminjaman->kode_pinjam ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->peminjaman->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap overflow-hidden">
                                            @foreach($denda->peminjaman->detailPeminjaman as $detail)
                                                <p class="w-10">{{ $detail->buku->judul }}</p>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->jumlah_hari ?? 'N/A'}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($denda->total_denda, 0, ',', '.') ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('denda.pay', $denda) }}" class="text-indigo-600 hover:text-indigo-900">Pay Denda</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Paid Fines Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Paid Fines</h3>
                    @if ($dendas->where('is_paid', '1')->isEmpty())
                    @php
                        dd($dendas);
                    @endphp
                        <p>You have no paid denda.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowing Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Late</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($dendas->where('is_paid', true) as $denda)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->peminjaman->kode_pinjam ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->peminjaman->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap overflow-hidden">
                                            @foreach($denda->peminjaman->detailPeminjaman as $detail)
                                                <p class="w-10">{{ $detail->buku->judul }}</p>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->jumlah_hari ?? 'N/A'}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($denda->total_denda, 0, ',', '.') ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $denda->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

