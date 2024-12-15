<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Denda Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Denda Details</h3>
                    <p><strong>Book:</strong> {{ $denda->peminjaman->buku->judul }}</p>
                    <p><strong>Days Late:</strong> {{ $denda->jumlah_hari }}</p>
                    <p><strong>Total Denda:</strong> Rp. {{ number_format($denda->total_denda, 0, ',', '.') }}</p>

                    @if(auth()->user()->hasRole(['admin', 'petugas']))
                        <div class="mt-4">
                            <form action="{{ route('denda.mark-as-paid', $denda->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Mark as Paid
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="mt-4 text-red-600">Please pay the denda to the library staff.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

