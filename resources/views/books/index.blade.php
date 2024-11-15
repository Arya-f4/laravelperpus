<!-- resources/views/books/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Catalog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                        <div class="mb-4">
                            <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add New Book
                            </a>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($books as $book)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}" class="w-full h-64 object-cover hover:opacity-80 transition-opacity duration-300">
                            <div class="book-card px-6">
                                <div class="book-header mb-5 mt-2">
                                    <h3 class="font-semibold text-2xl text-gray-800 m-0 p-0">{{ $book->judul }}</h3>
                                    <p class="text-gray-600 text-sm m-0 p-0">By <span class="font-medium text-blue-600">{{ $book->penulis }}</span></p>
                                    <p class="text-gray-500 text-sm m-0 p-0">{{ $book->kategori->nama }}</p>
                                </div>
                                <a href="{{ route('books.show', $book->slug) }}" class="inline-block w-full text-center my-3 bg-blue-600 hover:bg-blue-800 text-white font-semibold py-1 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                                    View Details
                                </a>
                                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                                    <a href="{{ route('books.edit', $book) }}" class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-5 rounded-lg ml-4 transition duration-200 ease-in-out transform hover:scale-105">
                                        Edit
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105" onclick="return confirm('Are you sure you want to delete this book?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    </div>
                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
