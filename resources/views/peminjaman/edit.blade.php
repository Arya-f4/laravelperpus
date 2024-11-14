<!-- resources/views/peminjaman/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Borrowing Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('peminjaman.update', $peminjaman) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="buku_id" class="block text-gray-700 text-sm font-bold mb-2">Book:</label>
                            <select name="buku_id" id="buku_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}" {{ $peminjaman->buku_id == $book->id ? 'selected' : '' }}>
                                        {{ $book->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_pinjam" class="block text-gray-700 text-sm font-bold mb-2">Borrow Date:</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ $peminjaman->tanggal_pinjam }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_kembali" class="block text-gray-700 text-sm font-bold mb-2">Return Date:</label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ $peminjaman->tanggal_kembali }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Borrowing Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
