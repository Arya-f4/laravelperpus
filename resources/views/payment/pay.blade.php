<!DOCTYPE html>
<html>
<head>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Payment for Fine ID: {{ $denda->id }}</h1>
    <p>Amount: Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</p>
    <button id="pay-button">Pay Now</button>

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
