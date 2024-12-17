<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="bg-gray-700 text-white">
    @include('layout.topbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-black mb-4">Payment for Fine</h2>
                    <div class="mb-4">
                        <p class="text-gray-900">Fine ID: <span class="font-semibold">{{ $denda->id }}</span></p>
                        <p class="text-gray-900">Amount: <span class="font-semibold text-blue-600">Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</span></p>
                    </div>
                    <button id="pay-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Pay Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert('Payment successful!');
                    // Send a request to update the fine status
                    fetch("{{ route('peminjaman.update-fine-status', $denda->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: 'paid',
                            transaction_id: result.transaction_id,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        window.location.href = "{{ route('peminjaman.index') }}";
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                },
                onPending: function (result) {
                    alert('Payment is pending!');
                    console.log(result);
                },
                onError: function (result) {
                    alert('Payment failed!');
                    console.log(result);
                },
                onClose: function () {
                    alert('You closed the payment popup without completing payment.');
                }
            });
        });
    </script>
</body>
</html>
