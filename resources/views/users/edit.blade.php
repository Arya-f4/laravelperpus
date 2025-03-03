<!-- resources/views/books/edit.blade.php -->
<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Book') }}
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
                        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="block text-lg text-black font-medium">Name:</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}" class="w-full p-2 border text-gray-700 rounded-lg"
                                    required>
                            </div>
    
                            <div class="form-group">
                                <label for="email" class="block text-lg text-black font-medium">Email:</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full p-2 border text-gray-700 rounded-lg"
                                    required>
                            </div>
    
                            <div class="form-group">
                                <label for="password" class="block text-lg text-black font-medium">Password:</label>
                                <input type="password" id="password" name="password" value="{{ $user->password }}" class="w-full p-2 border text-gray-700 rounded-lg"
                                    required>
                            </div>
    
                            <div class="form-group">
                                <label for="role_id" class="block text-lg text-black font-medium">Role:</label>
                                <select id="role_id" name="role_id" value="{{ $user->role_id }}" class="w-full p-2 border text-gray-700 rounded-lg" required>
                                    <option value="">Select a role</option>
                                    <!-- Populate roles dynamically if needed -->
                                    <option value="1">Admin</option>
                                    <option value="2">Petugas</option>
                                    <option value="3">Peminjam</option>
                                </select>
                            </div>
{{--     
                            <div class="form-group">
                                <label for="status" class="block text-lg font-medium">Status:</label>
                                <select id="status" name="status" value="{{ $user->status }}" class="w-full p-2 border rounded-lg" required>
                                    <option value="Offline">Offline</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div> --}}
    
                            <button type="submit"
                                class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600">Update User</button>
                        </form>
    
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    