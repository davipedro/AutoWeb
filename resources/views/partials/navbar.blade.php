<nav class="navbar">
    <div class="container">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
            <h1>Auto<span>Web</span></h1>
        </div>



        <div class="menu-wrapper">
            <ul class="menu">
                @if (auth()->user()->isAdmin())
                    <li><a href="{{ route('catalogo') }}" class="{{ request()->routeIs('catalogo') ? 'active' : '' }}">Catálogo</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.veiculos.list') }}" class="{{ request()->routeIs('admin.veiculos.*') ? 'active' : '' }}">Veículos</a></li>
                    <li><a href="{{ route('admin.clientes.list') }}" class="{{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">Clientes</a></li>
                    <li><a href="{{ route('admin.vendedores.list') }}" class="{{ request()->routeIs('admin.vendedores.*') ? 'active' : '' }}">Vendedores</a></li>
                    <li><a href="{{ route('admin.sell.add') }}" class="{{ request()->routeIs('admin.sell.add') ? 'active' : '' }}">Nova Venda</a></li>
                    <li><a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">Relatórios</a></li>
                @endif
                @if(auth()->user()->isSeller())
                    <li><a href="{{ route('catalogo') }}" class="{{ request()->routeIs('catalogo') ? 'active' : '' }}">Catálogo</a></li>
                    <li><a href="{{ route('seller.dashboard') }}" class="{{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('seller.veiculos.list') }}" class="{{ request()->routeIs('seller.veiculos.*') ? 'active' : '' }}">Veículos</a></li>
                    <li><a href="{{ route('seller.clientes.list') }}" class="{{ request()->routeIs('seller.clientes.*') ? 'active' : '' }}">Clientes</a></li>
                    <li><a href="{{ route('seller.sell.add') }}" class="{{ request()->routeIs('seller.sell.add') ? 'active' : '' }}">Nova Venda</a></li>
                    <li><a href="{{ route('seller.report') }}" class="{{ request()->routeIs('seller.report') ? 'active' : '' }}">Relatório</a></li>
                @endif
            </ul>
        </div>

        <div class="relative">
            <x-dropdown align="right" width="48">
                {{-- Dropdown --}}
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <span>{{ Auth::user()->name }}</span>

                        <span class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                </x-slot>

                {{-- Conteúdo Dropdown --}}
                <x-slot name="content">
                    <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        {{ __('Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
