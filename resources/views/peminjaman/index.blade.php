<!-- resources/views/peminjaman/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrowing Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-l">
                <div class="p-6 bg-gray-800">
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
                        <h2 class="text-lg font-semibold text-white">Borrowing List</h2>
                        @can('create peminjaman')
                            <a href="{{ route('peminjaman.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Borrow a Book
                            </a>
                        @endcan
                    </div>
    <section class="container px-4 mx-auto">
        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Borrow Code
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Book
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        User
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Borrow Code
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Borrow Date
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Return Date
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($peminjaman as $pinjam)

                                    <tr>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ $pinjam->id }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ $pinjam->kode_pinjam }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 w-20 overflow-hidden whitespace-nowrap">
                                            <div class="inline-flex w-20 items-center gap-x-3">
                                                @foreach ($pinjam->detailPeminjaman as $detail)
                                                {{ $detail->buku->judul ?? 'N/A' }}<br>
                                            @endforeach
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ $pinjam->user->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ $pinjam->kode_pinjam }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ $pinjam->tanggal_pinjam ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ $pinjam->tanggal_kembali ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($pinjam->status == 1)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Dipinjam
                                                </span>
                                            @elseif ($pinjam->status == 2)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @elseif ($pinjam->status == 0)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Menunggu
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Sudah Dikembalikan
                                                </span>
                                            @endif
                                        </td>
                                      <!-- ... (previous code remains unchanged) -->

<td class="px-6 py-4 whitespace-nowrap text-sm">

        @if ($pinjam->status == 0)

            <form action="{{ route('peminjaman.approve', $pinjam->id) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
            </form>
            <form action="{{ route('peminjaman.cancel', $pinjam->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 mr-2">Reject</button>
            </form>
        @elseif ($pinjam->status == 1)
            <a href="{{ route('peminjaman.return', $pinjam->id) }}"
                class="text-blue-600 hover:text-blue-900 mr-2">Return Book</a>
        @endif

    @if ($pinjam->status == 2 || $pinjam->status == 3)
        <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900 mr-2"
                onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
        </form>
    @endif

    @php
    $bayar = \App\Models\Denda::where('peminjaman_id', $pinjam->id)->first();
@endphp

@if ($bayar && $bayar->is_paid == 0)

<form action="{{ route('peminjaman.pay-fine', $bayar->id) }}" method="POST" class="inline">
            @csrf

            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                Pay Fine (Rp. {{ number_format($bayar->total_denda, 0, ',', '.') }})
            </button>
        </form>
    @endif
</td>

<!-- ... (rest of the code remains unchanged) -->


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
    </section>
                    {{ $peminjaman->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
