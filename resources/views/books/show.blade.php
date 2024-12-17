@extends('layout.user')
@section('content')
    <!-- component -->
    <section class="text-white overflow-hidden bg-gray-800 w-full rounded-lg">
        <div class="container py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                @if (session('error'))
                    <div class="w-full mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

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
                        <div class="flex flex-col w-full">
                            <span class="font-semibold mb-1">Description:</span>
                            <p class="text-white break-words">{{ $book->deskripsi }}</p>
                        </div>

                        <div class="mt-2 flex justify-between w-full">
                            <span class="font-semibold">ISBN:</span>
                            <p class="text-white mb-2">{{ $book->isbn }}</p>
                        </div>

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
                            @php
                                $activeBorrowings = \App\Models\Peminjaman::where('peminjam_id', Auth::id())
                                    ->whereIn('status', [0, 1])
                                    ->count();
                            @endphp

                            @if ($activeBorrowings >= 2)
                                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                                    <p class="font-bold">Warning</p>
                                    <p>You have already borrowed two books. Please return a book before borrowing another.</p>
                                </div>
                            @else
                                @if ($book->stok > 0)
                                    <form action="{{ route('books.request-borrow') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit"
                                            class="bg-blue-500 mb-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                            class="bg-blue-500 mb-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Login to Borrow
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection

