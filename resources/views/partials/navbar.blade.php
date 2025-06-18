<nav class="navbar">
    <div class="container">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
            <h1>Auto<span>Web</span></h1>
        </div>

        <div class="menu-wrapper">
            <ul class="menu">
                <li><a href="">Dashboard</a></li>
                <li><a href="{{ route('veiculos.list') }}" class="{{ request()->routeIs('veiculos.*') ? 'active' : '' }}">Veículos</a></li>
                <li><a href="">Clientes</a></li>
                <li><a href="">Vendedores</a></li>
                <li><a href="">Nova Venda</a></li>
                <li><a href="">Relatório</a></li>
            </ul>
        </div>

        <div class="usuario">
            <span><i class="fa fa-user"></i></span>
            <strong>Administrador</strong>
        </div>
    </div>
</nav>

