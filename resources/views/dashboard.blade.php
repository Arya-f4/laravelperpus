<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Welcome to the Library Management System</h3>
                    @if(auth()->user()->role === 'user')
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2">Available Books</h4>
                            <ul class="list-disc pl-5">
                                @foreach(\App\Models\Buku::where('stok', '>', 0)->take(5)->get() as $book)
                                    <li>{{ $book->judul }} (Available: {{ $book->stok }})</li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="{{ route('peminjaman.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Borrow a Book
                        </a>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Total Books</h4>
                                <p class="text-2xl">{{ \App\Models\Buku::count() }}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Total Categories</h4>
                                <p class="text-2xl">{{ \App\Models\Kategori::count() }}</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Active Borrowings</h4>
                                <p class="text-2xl">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
