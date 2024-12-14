<!-- resources/views/books/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Book Catalog') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 g-gray-800">
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <div class="mb-4">
                            <a href="{{ route('books.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add New Book
                            </a>
                        </div>
                    @endif
                    <section class="container px-4 mx-auto">
                        <div class="flex flex-col">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div
                                        class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        <div class="flex items-center gap-x-3">
                                                            <input type="checkbox"
                                                                class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">
                                                            <button class="flex items-center gap-x-2">
                                                                <span>ID Buku</span>
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <th scope="col"
                                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Judul Buku
                                                    </th>

                                                    <th scope="col"
                                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Penerbit
                                                    </th>

                                                    <th scope="col"
                                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Penulis
                                                    </th>

                                                    <th scope="col"
                                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Kategori
                                                    </th>

                                                    <th scope="col" class="relative py-3.5 px-4">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                                @foreach ($books as $book)
                                                    <tr>
                                                        <td
                                                            class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            <div class="inline-flex items-center gap-x-3">
                                                                <input type="checkbox"
                                                                    class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">

                                                                <span>{{ $book->id }}</span>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            {{ $book->judul }}</td>
                                                        <td
                                                            class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                                            <div
                                                                class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500 bg-emerald-100/60 dark:bg-gray-800">
                                                                <h2 class="text-sm font-normal">
                                                                    {{ $book->penerbit->nama }}</h2>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            <div class="flex items-center gap-x-2">
                                                                <img class="object-cover w-8 h-8 rounded-full"
                                                                    src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80"
                                                                    alt="">
                                                                <div>
                                                                    <h2
                                                                        class="text-sm font-medium text-gray-800 dark:text-white ">
                                                                    </h2>
                                                                    <p
                                                                        class="text-xs font-normal text-gray-600 dark:text-gray-400">
                                                                        {{ $book->penulis }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            {{ $book->kategori->nama }}</td>
                                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                            <a href="{{ route('books.show', $book->slug) }}"
                                                                class="inline-block text-center my-3 bg-blue-600 hover:bg-blue-800 text-white font-semibold py-1 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                                                                View Details
                                                                @if (auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                                                                    <a href="{{ route('books.edit', $book) }}"
                                                                        class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-semibold py-2 px-5 rounded-lg ml-4 transition duration-200 ease-in-out transform hover:scale-105">
                                                                        Edit
                                                                    </a>
                                                                    <form action="{{ route('books.destroy', $book) }}"
                                                                        method="POST" class="inline-block ml-4">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
                                                                            onclick="return confirm('Are you sure you want to delete this book?')">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            {{ $books->links() }}
                            {{-- <a href="#"
                                class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                                </svg>

                                <span>
                                    previous
                                </span>
                            </a>

                            <div class="items-center hidden md:flex gap-x-3">
                                <a href="#"
                                    class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">1</a>
                                <a href="#"
                                    class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">2</a>
                                <a href="#"
                                    class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">3</a>
                                <a href="#"
                                    class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">...</a>
                                <a href="#"
                                    class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">12</a>
                                <a href="#"
                                    class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">13</a>
                                <a href="#"
                                    class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">14</a>
                            </div>

                            <a href="#"
                                class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
                                <span>
                                    Next
                                </span>

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                            </a> --}}
                        </div>
                    </section>
                    {{-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($books as $book)
                            <div
                                class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">

                                @if ($book->sampul > 1)
                                    <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                        class="w-full h-64 object-cover hover:opacity-80 transition-opacity duration-300">
                                @else
                                    <img src="https://placehold.co/400" alt="{{ $book->judul }}"
                                        class="w-full h-64 object-cover hover:opacity-80 transition-opacity duration-300">
                                @endif

                                <div class="book-card px-6">
                                    <div class="book-header mb-5 mt-2">
                                        <h3 class="font-semibold text-2xl text-gray-800 m-0 p-0">{{ $book->judul }}
                                        </h3>
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
                                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                                            class="inline-block ml-4">
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
                            </div>
                        @endforeach

                    </div> --}}
                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
