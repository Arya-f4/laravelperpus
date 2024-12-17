@extends('layout.user')
@section('content')
    <div class="content">
        <!-- Search Form Section -->
        <div class="mb-8 bg-gray-800 p-6 rounded-lg shadow-md">
            <form action="{{ route('books.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-white mb-1">Search</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            placeholder="Search by title or author..."
                            value="{{ request('search') }}"
                            class="w-full text-black rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        >
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-white mb-1">Category</label>
                        <select name="kategori" id="kategori" class="text-black w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="" class="text-black">All Categories</option>
                            @foreach($categories as $category)
                                <option class="text-black" value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Publisher Filter -->
                    <div>
                        <label for="penerbit" class="block text-sm font-medium text-white mb-1">Publisher</label>
                        <select name="penerbit" id="penerbit" class="text-black w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option class="text-black" value="">All Publishers</option>
                            @foreach($publishers as $publisher)
                                <option class="text-black" value="{{ $publisher->id }}" {{ request('penerbit') == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Most Borrowed Books Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-6">KOLEKSI SERING DI PINJAM</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($mostBorrowedBooks as $book)
                    <a href="{{ route('books.show', $book->slug) }}" class="group relative block overflow-hidden">
                        <button class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                            <span class="sr-only">Wishlist</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>

                        @if ($book->sampul > 1)
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @else
                            <img src="https://placehold.co/400" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @endif

                        <div class="relative bg-gray-800 p-6">
                            <h3 class="mt-1.5 text-lg font-medium text-white">{{ $book->judul }}</h3>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">{{ $book->penulis }}</p>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">{{ $book->kategori->nama }}</p>
                            <form action="{{ route('books.show', $book->slug) }}" class="mt-4">
                                <button class="rounded w-full bg-purple-800 px-4 py-3 text-sm font-medium text-white transition hover:scale-105">
                                    Detail
                                </button>
                            </form>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Latest Books Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-6">KOLEKSI TERBARU</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($latestBooks as $book)
                    <a href="{{ route('books.show', $book->slug) }}" class="group relative block overflow-hidden">
                        <button class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                            <span class="sr-only">Wishlist</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>

                        @if ($book->sampul > 1)
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @else
                            <img src="https://placehold.co/400" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @endif

                        <div class="relative bg-gray-800 p-6">
                            <h3 class="mt-1.5 text-lg font-medium text-white">{{ $book->judul }}</h3>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">{{ $book->penulis }}</p>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">{{ $book->kategori->nama }}</p>
                            <form action="{{ route('books.show', $book->slug) }}" class="mt-4">
                                <button class="rounded w-full bg-purple-800 px-4 py-3 text-sm font-medium text-white transition hover:scale-105">
                                    Detail
                                </button>
                            </form>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- All Books Section -->
        <div class="page-title flex flex-row justify-between mb-10">
            <h1 class="text-2xl font-bold text-white">All Books</h1>
            @if (auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Book
                </a>
            @endif
        </div>

        <div class="page-content">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($books as $book)
                    <a href="{{ route('books.show', $book->slug) }}" class="group relative block overflow-hidden">
                        <button class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                            <span class="sr-only">Wishlist</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>

                        @if ($book->sampul > 1)
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @else
                            <img src="https://placehold.co/400" alt="" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @endif

                        <div class="relative bg-gray-800 p-6">
                            <h3 class="mt-1.5 text-lg font-medium text-white">{{ $book->judul }}</h3>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">{{ $book->penulis }}</p>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">{{ $book->kategori->nama }}</p>
                            <form action="{{ route('books.show', $book->slug) }}" class="mt-4">
                                <button class="rounded w-full bg-purple-800 px-4 py-3 text-sm font-medium text-white transition hover:scale-105">
                                    Detail
                                </button>
                            </form>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

