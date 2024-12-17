<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-black">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Active Borrowings</h3>
                        @if($activeBorrowings->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($activeBorrowings as $borrowing)
                                    @foreach ($borrowing->detailPeminjaman as $detail)
                                        <li class="py-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $detail->buku->judul }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Due:
                                                @if($borrowing->tanggal_kembali)
                                                    @if(is_string($borrowing->tanggal_kembali))
                                                        {{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('M d, Y') }}
                                                    @else
                                                        {{ $borrowing->tanggal_kembali->format('M d, Y') }}
                                                    @endif
                                                @else
                                                    Not set
                                                @endif
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Status: {{ $borrowing->status == 0 ? 'Pending' : 'Active' }}
                                            </p>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @else
                            <p>No active borrowings.</p>
                        @endif
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Pending Requests</h3>
                        @if($pendingRequests->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($pendingRequests as $request)
                                    @foreach ($request->detailPeminjaman as $detail)
                                        <li class="py-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $detail->buku->judul }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Requested on: {{ $request->created_at->format('M d, Y') }}
                                            </p>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @else
                            <p>No pending requests.</p>
                        @endif
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Pending Denda</h3>
                        @if($pendingDendas->isNotEmpty())
                            <ul class="divide-y divide-gray-200">
                                @foreach($pendingDendas as $denda)
                                    <li class="py-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $denda->peminjaman->detailPeminjaman->first()->buku->judul }}
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
                        @if($unpaidFines->isNotEmpty())
                            <ul class="divide-y divide-gray-200">
                                @foreach($unpaidFines as $fine)
                                    <li class="py-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $fine->peminjaman->detailPeminjaman->first()->buku->judul }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Amount: Rp {{ number_format($fine->total_denda, 0, ',', '.') }}
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

