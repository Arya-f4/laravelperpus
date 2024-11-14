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
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $book->judul }}</h3>
                                    <p class="text-gray-700 text-sm mb-2">By {{ $book->penulis }}</p>
                                    <p class="text-gray-600 text-sm mb-4">{{ $book->kategori->nama }}</p>
                                    <a href="{{ route('books.show', $book->slug) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        View Details
                                    </a>
                                    @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                                        <a href="{{ route('books.edit', $book) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" onclick="return confirm('Are you sure you want to delete this book?')">
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
