<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrowing Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl font-bold mb-4">Borrowing Details</h1>

                    <div class="space-y-4">
                        <div>
                            <strong>ID:</strong> {{ $peminjaman->id }}
                        </div>
                        <div>
                            <strong>Borrow Code:</strong> {{ $peminjaman->kode_pinjam }}
                        </div>
                        <div>
                            <strong>Borrower:</strong> {{ $peminjaman->user->name }}
                        </div>
                        <div>
                            <strong>Book:</strong> {{ $peminjaman->buku->judul }}
                        </div>
                        <div>
                            <strong>Status:</strong>
                            @if($peminjaman->status == 0)
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">Pending</span>
                            @elseif($peminjaman->status == 1)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Borrowed</span>
                            @elseif($peminjaman->status == 2)
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Rejected</span>
                            @else
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Returned</span>
                            @endif
                        </div>
                        <div>
                            <strong>Borrow Date:</strong> {{ $peminjaman->tanggal_pinjam }}
                        </div>
                        <div>
                            <strong>Due Date:</strong> {{ $peminjaman->tanggal_kembali }}
                        </div>
                        @if($peminjaman->tanggal_pengembalian)
                            <div>
                                <strong>Return Date:</strong> {{ $peminjaman->tanggal_pengembalian }}
                            </div>
                        @endif
                        <div>
                            <strong>Processed by:</strong> {{ $petugasPinjam->name ?? 'N/A' }}
                        </div>
                        @if($petugasKembali)
                            <div>
                                <strong>Returned to:</strong> {{ $petugasKembali->name }}
                            </div>
                        @endif

                        @if($peminjaman->denda)
                            <div class="mt-8">
                                <h2 class="text-lg font-semibold mb-2">Fine Information</h2>
                                <div class="bg-red-50 p-4 rounded-lg">
                                    <p><strong>Days Late:</strong> {{ $peminjaman->denda->jumlah_hari }}</p>
                                    <p><strong>Fine Amount:</strong> Rp. {{ number_format($peminjaman->denda->total_denda, 0, ',', '.') }}</p>
                                    <p><strong>Status:</strong>
                                        @if($peminjaman->denda->is_paid == 1)
                                            <span class="text-green-600">Paid</span>
                                        @else
                                            <span class="text-red-600">Unpaid</span>
                                            <form action="{{ route('peminjaman.pay-fine', $peminjaman->denda->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Pay Fine
                                                </button>
                                            </form>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

