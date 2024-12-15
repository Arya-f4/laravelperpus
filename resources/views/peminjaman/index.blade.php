<!-- resources/views/peminjaman/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrowing Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Borrowing List</h3>
                        @can('create peminjaman')
                            <a href="{{ route('peminjaman.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Borrow a Book
                            </a>
                        @endcan
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Borrow Code
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Borrow Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Return Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($peminjaman as $pinjam)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $pinjam->id }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $pinjam->kode_pinjam }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                @foreach ($pinjam->detailPeminjaman as $detail)
                                                    {{ $detail->buku->judul ?? 'N/A' }}<br>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $pinjam->user->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $pinjam->tanggal_pinjam ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $pinjam->tanggal_kembali ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($pinjam->status == 1)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Dipinjam
                                                </span>
                                            @elseif ($pinjam->status == 2)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @elseif ($pinjam->status == 0)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Sudah Dikembalikan
                                                </span>
                                            @endif
                                        </td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    @if(auth()->user()->hasRole(['admin', 'petugas']))
        @if ($pinjam->status == 1)
            <a href="{{ route('peminjaman.return', $pinjam->id) }}"
                class="text-blue-600 hover:text-blue-900">Return Book</a>
        @endif
    @endif
    @if ($pinjam->status == 2 || $pinjam->status == 3)
        <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST" class="inline ml-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900"
                onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
        </form>
    @endif

    @php
    $bayar = \App\Models\Denda::where('peminjaman_id', $pinjam->id)->first();
@endphp

@if ($bayar && $bayar->is_paid == 0)
    <form action="{{ route('peminjaman.pay-fine', $bayar->id) }}"
        method="POST" class="inline ml-2">
        @csrf
        <button type="submit" class="text-red-600 hover:text-red-900">
            Pay Fine (Rp.
            {{ number_format($bayar->total_denda, 0, ',', '.') }})
        </button>
    </form>
@endif
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $peminjaman->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

