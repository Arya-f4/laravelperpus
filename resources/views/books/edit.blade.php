<!-- resources/views/books/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <input type="text" name="judul" id="judul" value="{{ $book->judul }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="penulis" class="block text-gray-700 text-sm font-bold mb-2">Author:</label>
                            <input type="text" name="penulis" id="penulis" value="{{ $book->penulis }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="penerbit_id" class="block text-gray-700 text-sm font-bold mb-2">Publisher:</label>
                            <select name="penerbit_id" id="penerbit_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ $book->penerbit_id == $publisher->id ? 'selected' : '' }}>{{ $publisher->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="kategori_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                            <select name="kategori_id" id="kategori_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $book->kategori_id == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="rak_id" class="block text-gray-700 text-sm font-bold mb-2">Rack:</label>
                            <select name="rak_id" id="rak_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                                @foreach($racks as $rack)
                                    <option value="{{ $rack->id }}" {{ $book->rak_id == $rack->id ? 'selected' : '' }}>
                                        {{ $rack->rak }} - {{ $rack->baris }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
                            <input type="number" name="stok" id="stok" value="{{ $book->stok }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="0">
                        </div>
                        <div class="mb-4">
                            <label for="sampul" class="block text-gray-700 text-sm font-bold mb-2">Cover Image:</label>
                            <input type="file" name="sampul" id="sampul" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep the current image</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
