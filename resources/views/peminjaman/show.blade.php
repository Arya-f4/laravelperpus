<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Borrowing Management') }}
            </h2>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-xl font-bold mb-4">Detail Peminjaman</h1>
    
                        <div class="space-y-4">
                            <div>
                                <strong>ID:</strong> {{ $peminjaman->id }}
                            </div>
                            <div>
                                <strong>Kode Pinjam:</strong> {{ $peminjaman->kode_pinjam }}
                            </div>
                            <div>
                                <strong>Peminjam ID:</strong> {{ $peminjaman->peminjam_id }}
                            </div>
                            <div>
                                <strong>Status:</strong> 
                                @if($peminjaman->status == 0)
                                    Menunggu Konfirmasi
                                @else
                                    Other Status
                                @endif
                            </div>
                            <div>
                                <strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                            </div>
                            <div>
                                <strong>Tanggal Kembali:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                            </div>
                            <div>
                                <strong>Denda:</strong> {{ $peminjaman->denda ? $peminjaman->denda : 'No Denda' }}
                            </div>
                            <div>
                                <strong>Tanggal Pengembalian:</strong> 
                                {{ $peminjaman->tanggal_pengembalian ? \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y') : 'Not Returned Yet' }}
                            </div>
                        </div>
                        <div class="flex flex-row btn-actions mt-12 gap-6">
                                <a class="text-green-800" href="{{ route('peminjaman.confirmBorrow', $peminjaman->id) }}">Approve</a>
                                <a class="text-red-800" href="">Tolak</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    