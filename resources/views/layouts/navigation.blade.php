<!-- resources/views/layouts/navigation.blade.php -->
<nav x-data="{ open: false }" class="bg-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-300" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    @auth
                        @if(Auth::user()->getRoleNames()->first() === 'admin' || Auth::user()->getRoleNames()->first() === 'petugas')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">
                                {{ __('Manage Books') }}
                            </x-nav-link>
                            <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                {{ __('Manage Categories') }}
                            </x-nav-link>
                            <x-nav-link :href="route('publishers.index')" :active="request()->routeIs('publishers.*')">
                                {{ __('Manage Publishers') }}
                            </x-nav-link>
                            <x-nav-link :href="route('racks.index')" :active="request()->routeIs('racks.*')">
                                {{ __('Manage Racks') }}
                            </x-nav-link>
                            <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">
                                {{ __('Manage Borrowings') }}
                            </x-nav-link>
                            <x-nav-link :href="route('denda.index')" :active="request()->routeIs('denda.index')">
                                {{ __('Fines') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                                {{ __('User Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('peminjaman.user-index')" :active="request()->routeIs('peminjaman.user-index')">
                                {{ __('My Borrowings') }}
                            </x-nav-link>
                            <x-nav-link :href="route('peminjaman.cart')" :active="request()->routeIs('peminjaman.cart')">
                                {{ __('Cart') }}
                            </x-nav-link>

                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <br>
                                {{-- <div class="text-xs text-gray-500 font-semibold mt-1">
                                    {{ ucfirst(Auth::user()->getRoleNames()->first()) }}
                                </div> --}}

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            @auth
                @if(Auth::user()->getRoleNames()->first() === 'admin' || Auth::user()->getRoleNames()->first() === 'petugas')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">
                        {{ __('Manage Books') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        {{ __('Manage Categories') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('publishers.index')" :active="request()->routeIs('publishers.*')">
                        {{ __('Manage Publishers') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('racks.index')" :active="request()->routeIs('racks.*')">
                        {{ __('Manage Racks') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">
                        {{ __('Manage Borrowings') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('denda.index')" :active="request()->routeIs('denda.index')">
                        {{ __('Fines') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                        {{ __('User Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.user-index')">
                        {{ __('My Borrowings') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.cart')" :active="request()->routeIs('peminjaman.cart')">
                        {{ __('Cart') }}
                    </x-responsive-nav-link>

                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endauth
    </div>
</nav>
