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


            <div class="grid grid-cols-2">
                <div class="">
                    <div class="w-full mx-auto p-4 bg-gray-100 rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Chart</h2>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>

            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-100 p-4 rounded">
                            <h3 class="text-lg font-semibold mb-2">Total Books</h3>
                            <p class="text-3xl font-bold">{{ $totalBooks }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded">
                            <h3 class="text-lg font-semibold mb-2">Total Users</h3>
                            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded">
                            <h3 class="text-lg font-semibold mb-2">Active Borrowings</h3>
                            <p class="text-3xl font-bold">{{ $activeBorrowings }}</p>
                        </div>
                        <div class="bg-red-100 p-4 rounded">
                            <h3 class="text-lg font-semibold mb-2">Pending Requests</h3>
                            <p class="text-3xl font-bold">{{ $pendingRequests }}</p>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

{{--     
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // bar chart type
            data: {
                labels: @json($labels), // Publisher names
                datasets: [{
                    label: 'Number of Books',
                    data: @json($data), // Number of books
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script> --}}

</x-app-layout>
