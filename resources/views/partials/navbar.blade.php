<nav style="display: flex; align-items: center; padding: 10px 30px; background-color: #fff; border-bottom: 1px solid #ddd;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
        <h1 style="font-weight: bold;">Auto<span style="font-weight: normal;">Web</span></h1>
    </div>

    <ul style="display: flex; gap: 25px; margin-left: 50px; list-style: none;">
        <li><a href="">Dashboard</a></li> {{-- {{ route('dashboard') }} --}}
        <li><a href="{{ route('veiculos.list') }}">Veículos</a></li>
        <li><a href="">Clientes</a></li> {{-- {{ route('clientes.list') }} --}}
        <li><a href="">Vendedores</a></li> {{-- {{ route('vendedores.list') }} --}}
        <li><a href="">Nova Venda</a></li> {{-- {{ route('vendas.list') }} --}}
        <li><a href="">Relatório</a></li> {{-- {{ route('relatorios.list') }} --}}
    </ul>

    <div style="margin-left: auto; display: flex; align-items: center; gap: 8px;">
        <span style="background-color: #ddd; border-radius: 50%; padding: 8px;">
            <i class="fa fa-user"></i>
        </span>
        <strong>Administrador</strong>
    </div>
</nav>
