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
                    @if (Auth::user()->getRoleNames()->first() === 'admin'|| Auth::user()->getRoleNames()->first() ==='petugas')

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
                                        <table id="booksTable" class="display responsive nonwrap w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
                                                                @if (Auth::user() && in_array(Auth::user()->getRoleNames()->first(), ['admin', 'petugas']))
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


                    </section>


                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#booksTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('books.data') }}',
                columns: [
                    { data: 'judul', name: 'judul' },
                    { data: 'penulis', name: 'penulis' },
                    { data: 'kategori', name: 'kategori.nama' },
                    { data: 'rak', name: 'rak.nama' },
                    { data: 'stok', name: 'stok' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>
