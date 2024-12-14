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
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Borrow Code
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Borrow Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Return Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                                {{ $pinjam->nama ?? 'N/A' }}
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
                                            {{-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ $pinjam->status ?? 'N/A' }}
                                            </span> --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- @if ($pinjam->status == 1)
                                                <form action="{{ route('peminjaman.update', $pinjam) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="return" value="1">
                                                    <button type="submit"
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                        Return
                                                    </button>
                                                </form>
                                            @endif --}}
                                            @if ($pinjam->status == 0)
                                                <a href="{{ route('peminjaman.show', $pinjam->id) }}">Detail</a>
                                                {{-- <a href="{{ route('peminjaman.confirmBorrow', $pinjam->id) }}"
                                                    class=" text-indigo-600 hover:text-indigo-900 ml-2">Approve</a>
                                                <a href="{{ route('peminjaman.confirmBorrow', $pinjam->id) }}"
                                                    class=" text-red-600 hover:text-red-900 ml-2">Ditolak</a> --}}
                                            @endif
                                            @if ($pinjam->status == 1)
                                                <a href="{{ route('peminjaman.returnBook', $pinjam->id) }}"
                                                    class="te   xt-blue-600 hover:text-blue-900">Kembalikan</a>
                                            @endif
                                            @if ($pinjam->status == 2 || $pinjam->status == 3)
                                                <form action="#" method="POST" class="inline ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                                </form>
                                                {{-- <form action="{{ route('peminjaman.destroy', $pinjam) }}" method="POST" class="inline ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                                </form> --}}
                                            @endif
                                            @if ($pinjam->denda && !$pinjam->denda->is_paid)
                                                <form action="{{ route('peminjaman.pay-fine', $pinjam->denda) }}"
                                                    method="POST" class="inline ml-2">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Pay Fine (Rp.
                                                        {{ number_format($pinjam->denda->total_denda, 0, ',', '.') }})
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
