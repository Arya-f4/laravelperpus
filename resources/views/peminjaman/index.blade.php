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

                    <!-- Search inputs -->
                    <div class="mb-4 flex space-x-4">
                        <input type="text" id="searchUser" placeholder="Search User" class="rounded p-2 text-black">
                        <input type="text" id="searchBook" placeholder="Search Book" class="rounded p-2 text-black">
                    </div>

                    <section class="container px-4 mx-auto">
                        <div class="flex flex-col">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                        <table id="borrowingTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        ID
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Borrow Code
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Book
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        User
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Borrow Date
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Return Max
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Returned Date
                                                    </th>

                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="py-5 px-4 text-sm font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-gray-600 dark:divide-gray-700">
                                                @foreach ($peminjaman as $pinjam)
                                                    <tr>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            {{ $pinjam->id }}
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            {{ $pinjam->kode_pinjam }}
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 w-20 overflow-hidden whitespace-nowrap">
                                                            @foreach ($pinjam->detailPeminjaman as $detail)
                                                                {{ $detail->buku->judul ?? 'N/A' }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            {{ $pinjam->user->name ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            {{ $pinjam->tanggal_pinjam ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            {{ $pinjam->tanggal_kembali ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            {{ $pinjam->tanggal_pengembalian ?? 'N/A' }}
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
                                                                <a href="{{ route('peminjaman.return', $pinjam->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Return Book</a>
                                                            @endif

                                                            @if ($pinjam->status == 2 || $pinjam->status == 3)
                                                                <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-900 mr-2" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
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
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <style>
        #borrowingTable tbody tr {
            background-color: #374151 !important; /* This is the Tailwind bg-gray-700 color */
        }
        #borrowingTable tbody tr:hover {
            background-color: #4B5563 !important; /* This is the Tailwind bg-gray-600 color for hover effect */
        }
    </style>

    @push('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function() {
            var table = $('#borrowingTable').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "dom": '<"top"f>rt<"bottom"ip><"clear">',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search..."
                },
                "stripeClasses": [], // Remove default stripe classes
                "rowCallback": function(row, data, index) {
                    $(row).addClass('text-gray-200'); // Add text color for better contrast
                }
            });

            $('#searchUser').on('keyup', function() {
                table.column(3).search(this.value).draw();
            });

            $('#searchBook').on('keyup', function() {
                table.column(2).search(this.value).draw();
            });
        });
    </script>
    @endpush
</x-app-layout>

