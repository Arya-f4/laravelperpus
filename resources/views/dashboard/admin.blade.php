<!-- resources/views/dashboard/admin.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="sm:flex sm:space-x-4">
                <!-- Total Subscribers Card -->
                <div
                    class="inline-block align-bottom bg-gray-700 text-white rounded-lg text-left overflow-hidden shadow transform transition-all mb-4 w-full sm:w-1/3 sm:my-8">
                    <div class="bg-gray-700 text-white p-5">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <div class="flex items-center gap-4">
                                    <!-- Total Subscribers Icon -->
                                    <i class="fa-solid fa-book"></i>
                                    <h3 class="text-sm leading-6 font-medium text-gray-400">Total Books</h3>
                                </div>
                                <p class="text-3xl font-bold text-white">{{ $totalBooks }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avg. Open Rate Card -->
                <div
                    class="inline-block align-bottom bg-gray-700 text-white rounded-lg text-left overflow-hidden shadow transform transition-all mb-4 w-full sm:w-1/3 sm:my-8">
                    <div class="bg-gray-700 text-white p-5">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <div class="flex items-center gap-4">
                                    <!-- Avg. Open Rate Icon -->
                                    <i class="fa-solid fa-user"></i>
                                    <h3 class="text-sm leading-6 font-medium text-gray-400">Total Users</h3>
                                </div>
                                <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avg. Click Rate Card -->
                <div
                    class="inline-block align-bottom bg-gray-700 text-white rounded-lg text-left overflow-hidden shadow transform transition-all mb-4 w-full sm:w-1/3 sm:my-8">
                    <div class="bg-gray-700 text-white p-5">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-book-bookmark"></i>
                                    <h3 class="text-sm leading-6 font-medium text-gray-400">Active Borrowings</h3>
                                </div>
                                <p class="text-3xl font-bold text-white">{{ $activeBorrowings }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="inline-block align-bottom bg-gray-700 text-white rounded-lg text-left overflow-hidden shadow transform transition-all mb-4 w-full sm:w-1/3 sm:my-8">
                    <div class="bg-gray-700 text-white p-5">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-hourglass-start"></i>
                                    <h3 class="text-sm leading-6 font-medium text-gray-400">Pending Requests</h3>
                                </div>
                                <p class="text-3xl font-bold text-white">{{ $pendingRequests }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-1">
                    <div class="w-full mx-auto p-4 bg-gray-700 rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-white">Jumlah Buku per Penerbit</h2>
                        <canvas id="myChart" style="width:100%; max-height:350px;"></canvas>
                    </div>
                </div>
                <div class="w-full mx-auto p-4 bg-gray-700 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4">User Activity Logs</h2>
                    <ul class="space-y-4">
                        @foreach($aktivitas_user as $log)
                        <li class="flex justify-between items-center p-4 bg-gray-800 text-white rounded-lg shadow">
                            <div>
                                <p class="text-lg font-semibold">{{ $log->user->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ ucfirst($log->activity) }} at {{ $log->created_at->format('d M Y, H:i:s') }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-sm font-medium rounded 
                                {{ $log->activity === 'login' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ ucfirst($log->activity) }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- <div class="grid grid-cols-2">
                <div class="">
                    <div class="w-full mx-auto p-4 bg-gray-100 rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Chart</h2>
                        <div id="chart"></div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut', // Doughnut chart type
            data: {
                labels: @json($labels), // Publisher names
                datasets: [{
                    label: 'Number of Books',
                    data: @json($data), // Number of books
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Allows custom height
                plugins: {
                    legend: {
                        position: 'right', // Move labels to the right side
                        labels: {
                            boxWidth: 20, // Adjusts the size of the color boxes
                            padding: 20 // Adds spacing between legend items
                        }
                    }
                }
            }
        });
    </script>
    

</x-app-layout>
