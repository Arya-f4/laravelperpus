@if (Auth::user())
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0%); }
        }
        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(100%); }
        }
        .sidebar-open {
            animation: slideIn 0.3s forwards;
        }
        .sidebar-closed {
            animation: slideOut 0.3s forwards;
        }
        .nav-item {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .nav-item:hover {
            transform: translateZ(10px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div x-data="{ sidebarOpen: true, dataMasterOpen: false }">
        <aside id="sidebar"
               x-show="sidebarOpen"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform translate-x-full"
               x-transition:enter-end="opacity-100 transform translate-x-0"
               x-transition:leave="transition ease-in duration-300"
               x-transition:leave-start="opacity-100 transform translate-x-0"
               x-transition:leave-end="opacity-0 transform translate-x-full"
               class="z-50 border-l-2 border-gray-700 fixed top-0 right-0 h-screen w-64 bg-gray-800 text-white p-5 overflow-y-auto">

            <ul class="space-y-3 mt-10">
                <li><a href="/" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Home</a></li>

                @if(Auth::user()->getRoleNames()->first() === 'admin' || Auth::user()->getRoleNames()->first() === 'petugas')
                    <li><a href="/admin/dashboard" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Admin Dashboard</a></li>

                    <li x-data="{ open: false }">
                        <button @click="open = !open" class="nav-item w-full text-left block p-3 rounded hover:bg-indigo-700 transition-colors duration-200 flex justify-between items-center">
                            Manage Data Master
                            <svg :class="{'rotate-180': open}" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <ul x-show="open"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="ml-4 mt-2 space-y-2">
                            <li><a href="/books" class="nav-item block p-2 rounded hover:bg-indigo-600 transition-colors duration-200">Manage Books</a></li>
                            <li><a href="/admin/categories" class="nav-item block p-2 rounded hover:bg-indigo-600 transition-colors duration-200">Manage Categories</a></li>
                            <li><a href="/admin/publishers" class="nav-item block p-2 rounded hover:bg-indigo-600 transition-colors duration-200">Manage Publishers</a></li>
                            <li><a href="/admin/racks" class="nav-item block p-2 rounded hover:bg-indigo-600 transition-colors duration-200">Manage Racks</a></li>
                            <li><a href="/admin/users/all" class="nav-item block p-2 rounded hover:bg-indigo-600 transition-colors duration-200">Manage Users</a></li>
                        </ul>
                    </li>

                    <li><a href="/peminjaman" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Manage Borrowing</a></li>
                    <li><a href="/denda" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Manage Denda</a></li>

                    @else
                    <li><a href="/dashboard" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">User Dashboard</a></li>
                    <li><a href="/peminjaman/my-borrowings" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">My Borrowing</a></li>
                    <li><a href="/cart" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Cart</a></li>
                @endif
            </ul>
        </aside>

        <div class="fixed top-5 right-5 z-50">
            <button @click="sidebarOpen = !sidebarOpen" class="focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        // Add 3D effect to nav items
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('mousemove', (e) => {
                const rect = item.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                item.style.transform = `perspective(1000px) rotateX(${(y - rect.height / 2) / 10}deg) rotateY(${-(x - rect.width / 2) / 10}deg) translateZ(10px)`;
            });

            item.addEventListener('mouseleave', () => {
                item.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
            });
        });

        // Keyboard accessibility
        document.querySelector('button').addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                e.target.click();
            }
        });

        // Trap focus within sidebar when open
        document.getElementById('sidebar').addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                const focusableElements = sidebar.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.shiftKey && document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                } else if (!e.shiftKey && document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        });
    </script>
@endif

