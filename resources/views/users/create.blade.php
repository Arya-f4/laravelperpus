<!-- resources/views/books/edit.blade.php -->
<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create User') }}
            </h2>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w7xl mx-auto sm:px-6 lg:px-8">
                <div class="-bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
    
    
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="bg-green-500 text-white p-4 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        <!-- Form to create a new user -->
                        <form action="{{ route('users.index') }}" method="POST" class="space-y-4">
                            @csrf
    
                            <div class="form-group">
                                <label for="name" class="block text-black text-lg font-medium">Name:</label>
                                <input type="text" id="name" name="name" class="w-full p-2 text-gray-700 border rounded-lg"
                                    required>
                            </div>
    
                            <div class="form-group">
                                <label for="email" class="block text-black text-lg font-medium">Email:</label>
                                <input type="email" id="email" name="email" class="w-full p-2 text-gray-700 border rounded-lg"
                                    required>
                            </div>
    
                            <div class="form-group">
                                <label for="password" class="block text-black text-lg font-medium">Password:</label>
                                <input type="password" id="password" name="password" class="w-full p-2 text-gray-700 border rounded-lg"
                                    required>
                            </div>
    
                            <div class="form-group">
                                <label for="role_id" class="block text-black text-lg font-medium">Role:</label>
                                <select id="role_id" name="role_id" class="w-full p-2 text-gray-700 border rounded-lg" required>
                                    <option value="">Select a role</option>
                                    <!-- Populate roles dynamically if needed -->
                                    <option value="1">Admin</option>
                                    <option value="2">Petugas</option>
                                    <option value="3">Peminjam</option>
                                </select>
                            </div>
    
                            {{-- <div class="form-group">
                                <label for="status" class="block text-black text-lg font-medium">Status:</label>
                                <select id="status" name="status" class="w-full p-2 text-gray-700 border rounded-lg" required>
                                    <option value="Offline">Offline</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div> --}}
    
                            <button type="submit"
                                class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600">Create User</button>
                        </form>
    
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    