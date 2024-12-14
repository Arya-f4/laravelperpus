<!-- resources/views/books/show.blade.php -->
@extends('layout.user')
@section('content')
    <!-- component -->
    <section class="text-white overflow-hidden bg-gray-800 w-full rounded-lg">
        <div class="container py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">

                @if ($book->sampul > 1)
                    <img alt="{{ $book->sampul }}"
                        class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200"
                        src="{{ asset('storage/' . $book->sampul) }}">
                @else
                    <img alt="{{ $book->sampul }}"
                        class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200"
                        src="https://placehold.co/300x200">
                @endif

                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 class="text-sm title-font text-gray-300 tracking-widest"> {{ $book->penulis }}</h2>
                    <h1 class="text-white text-3xl title-font font-medium mb-1 uppercase">{{ $book->judul }}</h1>

                    <div class="book-detail mt-5">

                        <div class="flex justify-between w-full">
                            <span class="font-semibold">Publisher:</span>
                            <p class="text-white mb-2 capitalize ">
                                {{ $book->penerbit->nama }}</p>
                        </div>
                        <div class="flex justify-between w-full">
                            <span class="font-semibold">Category:</span>
                            <p class="text-white mb-2 capitalize ">
                                {{ $book->kategori->nama }}</p>
                        </div>
                        <div class="flex justify-between w-full">
                            <span class="font-semibold">Rack:</span>
                            <p class="text-white mb-2 capitalize "> {{ $book->rak->nama ?? '-' }}
                            </p>
                        </div>
                        <div class="flex justify-between w-full">
                            <span class="font-semibold">Available Stock:</span>
                            <p class="text-white mb-4">
                                {{ $book->stok }}</p>
                        </div>
                    </div>

                    
                        @auth
                            @if (Auth::user()->role_id == 3)
                                @if ($book->stok > 0)
                                    <form action="{{ route('books.request-borrow', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Borrow this Book
                                        </button>
                                    </form>
                                    <form action="{{ route('books.add-to-cart', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <p class="text-red-600 font-semibold">This book is currently out of stock.</p>
                                @endif
                            @elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <div class="mt-4">
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                        Edit Book
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                        class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            onclick="return confirm('Are you sure you want to delete this book?')">
                                            Delete Book
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Login to Borrow
                            </a>
                        @endauth
                        @auth
                            @if (auth()->user()->role === 'peminjam')
                                <form action="{{ route('books.add-to-cart', $book) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        @endauth
                    
                </div>
            </div>
        </div>
    </section>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-800 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                class="w-full rounded-lg shadow-md">
                        </div>
                        <div class="md:w-2/3 md:pl-8 mt-4 md:mt-0">
                            <h1 class="text-3xl font-bold mb-4">{{ $book->judul }}</h1>
                            <p class="text-gray-700 mb-2"><span class="font-semibold">Author:</span> {{ $book->penulis }}
                            </p>
                            <p class="text-gray-700 mb-2"><span class="font-semibold">Publisher:</span>
                                {{ $book->penerbit->nama }}</p>
                            <p class="text-gray-700 mb-2"><span class="font-semibold">Category:</span>
                                {{ $book->kategori->nama }}</p>
                            <p class="text-gray-700 mb-2"><span class="font-semibold">Rack:</span> {{ $book->rak->nama }}
                            </p>
                            <p class="text-gray-700 mb-4"><span class="font-semibold">Available Stock:</span>
                                {{ $book->stok }}</p>

                            @auth
                                @if (auth()->user()->role === 'peminjam')
                                    @if ($book->stok > 0)
                                        <form action="{{ route('books.borrow', $book) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Borrow this Book
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-red-600 font-semibold">This book is currently out of stock.</p>
                                    @endif
                                @elseif(in_array(auth()->user()->role, ['admin', 'petugas']))
                                    <div class="mt-4">
                                        <a href="{{ route('books.edit', $book) }}"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            Edit Book
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                                            class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="return confirm('Are you sure you want to delete this book?')">
                                                Delete Book
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Login to Borrow
                                </a>
                            @endauth
                            @auth
                                @if (auth()->user()->role === 'peminjam')
                                    <form action="{{ route('books.add-to-cart', $book) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Add to Cart
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
