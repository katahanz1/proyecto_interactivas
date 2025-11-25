<nav x-data="{ open: false }" class="bg-white border-b border-primary-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Branding -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-10 w-auto fill-current text-primary-800" />
                    <span class="font-bold text-lg text-primary-900 hidden sm:inline">Library</span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex space-x-1">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Panel
                        </a>
                        <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('categories.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Categorías
                        </a>
                        <a href="{{ route('authors.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('authors.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Autores
                        </a>
                        <a href="{{ route('books.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('books.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Libros
                        </a>
                        <a href="{{ route('loans.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('loans.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Préstamos
                        </a>
                        <a href="{{ route('reports.general') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('reports.general') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Reportes
                        </a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('student.dashboard') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Panel
                        </a>
                        <a href="{{ route('books.catalog') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('books.catalog') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Catálogo
                        </a>
                        <a href="{{ route('reports.library_card') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('reports.library_card') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Carnet
                        </a>
                        <a href="{{ route('reports.history') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('reports.history') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                            Historial
                        </a>
                    @endif
                </div>
            </div>

            <!-- User Menu & Hamburger -->
            <div class="flex items-center gap-4">
                <!-- Desktop User Dropdown -->
                <div class="hidden sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-primary-700 hover:text-accent-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-primary-200">
                                <p class="text-xs text-primary-600 font-semibold uppercase">Cuenta</p>
                                <p class="text-sm font-semibold text-primary-900 mt-1">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-primary-600 mt-1">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                Configuración de Perfil
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar Sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Hamburger -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-primary-700 hover:bg-primary-100 transition-colors">
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden border-t border-primary-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Panel
                </a>
                <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('categories.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Categorías
                </a>
                <a href="{{ route('authors.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('authors.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Autores
                </a>
                <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('books.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Libros
                </a>
                <a href="{{ route('loans.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('loans.*') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Préstamos
                </a>
                <a href="{{ route('reports.general') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('reports.general') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Reportes
                </a>
            @else
                <a href="{{ route('student.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('student.dashboard') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Panel
                </a>
                <a href="{{ route('books.catalog') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('books.catalog') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Catálogo
                </a>
                <a href="{{ route('reports.library_card') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('reports.library_card') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Carnet
                </a>
                <a href="{{ route('reports.history') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('reports.history') ? 'bg-primary-100 text-accent-600' : 'text-primary-700 hover:bg-primary-50' }} transition-colors">
                    Historial
                </a>
            @endif
        </div>

        <!-- Mobile User Section -->
        <div class="border-t border-primary-200 px-4 py-4 sm:hidden">
            <div class="flex items-center gap-3">
                <svg class="w-10 h-10 text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                <div>
                    <p class="font-semibold text-primary-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-primary-600">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-primary-700 hover:bg-primary-50 transition-colors">
                    Configuración de Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-semibold text-primary-700 hover:bg-primary-50 transition-colors">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
