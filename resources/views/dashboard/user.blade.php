<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Active Borrowings</h3>
                        @if($activeBorrowings->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($activeBorrowings as $borrowing)
                                    <li class="py-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $borrowing->buku->judul }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Due: {{ $borrowing->tanggal_pengembalian->format('M d, Y') }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No active borrowings.</p>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Pending Denda</h3>
                        @if($pendingDendas->isNotEmpty())
                            <ul class="divide-y divide-gray-200">
                                @foreach($pendingDendas as $denda)
                                    <li class="py-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $denda->peminjaman->buku->judul }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Amount: Rp {{ number_format($denda->total_denda, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-red-600">
                                            Please pay this denda to the library staff.
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No pending denda.</p>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Unpaid Fines</h3>
                        @if($unpaidFines->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($unpaidFines as $fine)
                                    <li class="py-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $fine->peminjaman->buku->judul }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Amount: Rp {{ number_format($fine->jumlah_denda, 0, ',', '.') }}
                                        </p>
                                        <a href="{{ route('denda.show', $fine) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                            Pay Fine
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No unpaid fines.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

