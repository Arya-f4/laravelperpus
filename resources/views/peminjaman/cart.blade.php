<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrowing Cart') }}
        </h2>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($cartItems->isEmpty())
                        <p>Your cart is empty.</p>
                    @else
                        <form action="{{ route('peminjaman.checkout') }}" method="POST">
                            @csrf
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                        <tr class="overflow-hidden w-1/3" data-book-id="{{ $item->id }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="selected_books[]" value="{{ $item->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap overflow-hidden w-40">
                                                <ul>
                                                    <li class="w-40">{{ $item->judul }}</li>
                                                </ul>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button type="button" onclick="removeFromCart({{ $item->id }})" class="text-red-600 hover:text-red-900">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Checkout Selected Books
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function removeFromCart(bookId) {
            fetch(`/cart/remove/${bookId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    // Remove the table row from the DOM
                    const row = document.querySelector(`tr[data-book-id="${bookId}"]`);
                    if (row) {
                        row.remove();
                    }

                    // Check if the cart is empty after removal
                    const tbody = document.querySelector('tbody');
                    if (tbody.children.length === 0) {
                        const cartContainer = document.querySelector('.p-6.bg-white.border-b.border-gray-200');
                        cartContainer.innerHTML = '<p>Your cart is empty.</p>';
                    }
                }
            });
        }
    </script>
</x-app-layout>

