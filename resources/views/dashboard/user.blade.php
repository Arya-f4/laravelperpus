<!-- resources/views/dashboard/user.blade.php -->
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
                    <h3 class="text-lg font-semibold mb-4">Active Borrowings</h3>
                    @if($activeBorrowings->count() > 0)
                        <ul>
                            @foreach($activeBorrowings as $borrowing)
                                <li class="mb-2">
                                    {{ $borrowing->buku->judul }} - Due: {{ $borrowing->tanggal_kembali }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No active borrowings.</p>
                    @endif

                    <h3 class="text-lg font-semibold mt-6 mb-4">Pending Requests</h3>
                    @if($pendingRequests->count() > 0)
                        <ul>
                            @foreach($pendingRequests as $request)
                                <li class="mb-2">
                                    {{ $request->buku->judul }} - Requested on: {{ $request->created_at }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No pending requests.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
