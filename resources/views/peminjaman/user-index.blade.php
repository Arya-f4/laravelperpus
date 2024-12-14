<!-- resources/views/peminjaman/user-index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Borrowings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($borrowings->isEmpty())
                        <p>You have no active borrowings.</p>
                    @else
                        <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
                            <table class="min-w-full table-auto">
                                <thead class="bg-blue-600 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-medium">Borrower Info</th>
                                        <th class="px-6 py-4 text-left text-sm font-medium">Borrow Date</th>
                                        <th class="px-6 py-4 text-left text-sm font-medium">Return Date</th>
                                        <th class="px-6 py-4 text-left text-sm font-medium">Status</th>
                                        <th class="px-6 py-4 text-left text-sm font-medium">Books</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($borrowings as $borrowing)
                                        <tr class="border-b hover:bg-gray-100 transition-colors">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                                Borrower #{{ $borrowing->id }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->tanggal_pinjam }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $borrowing->tanggal_kembali }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                @if ($borrowing->status == 1)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Dipinjam</span>
                                                @elseif ($borrowing->status == 0)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">Menunggu</span>
                                                @elseif ($borrowing->status == 2)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded-full">Ditolak</span>
                                                @elseif ($borrowing->status == 3)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">Dikembalikan</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded-full">Unkown
                                                        : {{ $borrowing->status }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <!-- Dropdown Button to Show Books -->
                                                <button class="text-blue-600 hover:text-blue-800 focus:outline-none"
                                                    onclick="toggleBooks('books-{{ $borrowing->id }}')">
                                                    <i class="fas fa-caret-down"></i> View Books
                                                </button>
                                                <div id="books-{{ $borrowing->id }}" class="hidden mt-2">
                                                    <ul class="space-y-2">
                                                        @foreach ($borrowing->bukus as $buku)
                                                            <li class="text-gray-800 text-sm">
                                                                {{ $buku->judul ?? 'No Title' }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- {{ $borrowing->links() }} --}}

                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle the visibility of the books dropdown
        function toggleBooks(id) {
            const booksList = document.getElementById(id);
            booksList.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
