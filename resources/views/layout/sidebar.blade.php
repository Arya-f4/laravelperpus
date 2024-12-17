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
         <aside id="sidebar" class="z-999 border-l-2 border-gray-700 fixed top-0 right-0 h-screen w-64 bg-gray-800 text-white p-5 transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto sidebar-open">
                <!-- Sidebar content here -->

                <ul class="space-y-3 mt-10">
                    <li><a href="#" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Home</a></li>
                    <li><a href="#" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Analytics</a></li>
                    <li><a href="#" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Customers</a></li>
                    <li><a href="#" class="nav-item block p-3 rounded hover:bg-indigo-700 transition-colors duration-200">Settings</a></li>
                </ul>
            </aside>

            <div class="fixed top-5 right-5 z-50">
                <button onclick="toggleSidebar()"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg></button>
            </div>


            <script>
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebarToggle');
                let isOpen = true;

                function toggleSidebar() {
                    isOpen = !isOpen;
                    if (isOpen) {
                        sidebar.classList.remove('sidebar-closed', '-translate-x-full');
                        sidebar.classList.add('sidebar-open');
                    } else {
                        sidebar.classList.remove('sidebar-open');
                        sidebar.classList.add('sidebar-closed');
                    }
                }

                sidebarToggle.addEventListener('click', toggleSidebar);

                // Close sidebar when clicking outside
                document.addEventListener('click', (event) => {
                    if (isOpen && !sidebar.contains(event.target) && event.target !== sidebarToggle) {
                        toggleSidebar();
                    }
                });

                // Add 3D effect to nav items
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
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
                sidebarToggle.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleSidebar();
                    }
                });

                // Trap focus within sidebar when open
                sidebar.addEventListener('keydown', (e) => {
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
