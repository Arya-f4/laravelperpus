@extends('layout.user')
@section('content')
    <div class="content">

        <div class="page-title flex flex-row justify-between mb-10">
            <h1 class="text-xl">All Books</h1>
            @if (auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ route('books.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Book
                </a>
            @endif
        </div>
        <div class="page-content">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach ($books as $book)
                    <a href="{{ route('books.show', $book->slug) }}" class="group relative block overflow-hidden">
                        <button
                            class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                            <span class="sr-only">Wishlist</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>

                        @if ($book->sampul > 1)
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt=""
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @else
                            <img src="https://placehold.co/400" alt=""
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                        @endif

                        <div class="relative bg-gray-800 p-6">
                            <p class="text-gray-700">

                                {{-- <span class="text-gray-400 line-through">$80</span> --}}
                            </p>

                            <h3 class="mt-1.5 text-lg font-medium text-white">{{ $book->judul }}</h3>

                            <p class="mt-1.5 line-clamp-3 text-gray-400">
                                {{ $book->penulis }}
                            </p>
                            <p class="mt-1.5 line-clamp-3 text-gray-400">
                                {{ $book->kategori->nama }}
                            </p>

                            <form action="{{ route('books.show', $book->slug) }}" class="mt-4 flex gap-4">
                                <button
                                    class="rounded w-full bg-purple-800 px-4 py-3 text-sm font-medium text-white transition hover:scale-105">
                                    Detail
                                </button>
                            </form>
                        </div>
                    </a>
                    {{-- <div
                    class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                        <img src="https://placehold.co/400" alt="{{ $book->judul }}"
                            class="w-full h-64 object-cover hover:opacity-80 transition-opacity duration-300">
                        <div class="book-card px-6">
                            <div class="book-header mb-5 mt-2">
                                <h3 class="font-semibold text-2xl text-gray-800 m-0 p-0">{{ $book->judul }}</h3>
                                <p class="text-gray-600 text-sm m-0 p-0">By <span
                                        class="font-medium text-blue-600">{{ $book->penulis }}</span></p>
                                <p class="text-gray-500 text-sm m-0 p-0">{{ $book->kategori->nama }}</p>
                            </div>
                            <a href="{{ route('books.show', $book->slug) }}"
                                class="inline-block w-full text-center my-3 bg-blue-600 hover:bg-blue-800 text-white font-semibold py-1 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                                View Details
                            </a>
                            @if (auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                                <a href="{{ route('books.edit', $book) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-5 rounded-lg ml-4 transition duration-200 ease-in-out transform hover:scale-105">
                                    Edit
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
                                        onclick="return confirm('Are you sure you want to delete this book?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div> --}}
                @endforeach
            </div>

        </div>
    @endsection
