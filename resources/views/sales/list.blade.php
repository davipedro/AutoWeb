@extends('layouts.app')

@section('title', 'Gestão de Vendas')

@section('content')
    @php
        use Carbon\Carbon;

        function formatPhone($phone) {
            $digits = preg_replace('/\D/', '', $phone);
            if(strlen($digits) == 11) {
                return '('.substr($digits, 0, 2).') '.substr($digits, 2, 5).'-'.substr($digits, 7);
            }
            return $phone;
        }
    @endphp
    <div class="vehicles-header">
        <div>
            <h1 class="page-title">Gestão de Vendas</h1>
            <p class="subheading">Gerencie as vendas realizadas</p>
        </div>

        <div style="display: flex; flex-direction: column; align-items: flex-end;">
            <a href="{{ route(auth()->user()->role . '.vendas.add') }}" class="add-btn">+ Cadastrar Nova Venda</a>
        </div>
    </div>

    <form method="GET" action="{{ route(auth()->user()->role . '.vendas.list') }}" class="filters">
        <div class="filter-options">
            <input
                type="text"
                name="nome_cliente"
                class="input-field"
                placeholder="Nome do cliente"
                value="{{ $filters['nome_cliente'] ?? '' }}"
            >

            <div>
                Data de início:
                <input
                    type="date"
                    name="data_venda_inicio"
                    class="input-field"
                    value="{{ $filters['data_venda_inicio'] ?? '' }}"
                >
            </div>

            <div>
                Data de fim:
                <input
                    type="date"
                    name="data_venda_fim"
                    class="input-field"
                    value="{{ $filters['data_venda_fim'] ?? '' }}"
                >
            </div>

            <button type="submit" class="filter-btn">
                <i class="fa fa-filter"></i> Filtrar
            </button>

            <a href="{{ route(auth()->user()->role .'.vendas.list') }}" class="clear-filters-btn">
                <i class="fa fa-times"></i> Limpar
            </a>
        </div>
    </form>

    <div class="client-list">
        <div class="list-header">
            <div>
                <h2>Lista de Vendas</h2>
                <p id="total-clients-text">Total: {{ $vendas->total() }} vendas cadastradas</p>
            </div>
            <button type="button" class="collapse-all-btn" onclick="collapseAllSellers()">
                <i class="fa fa-chevron-up"></i>
                Recolher Todos
            </button>
        </div>

        @if($vendas->isEmpty())
            <div class="no-clients-message">
                Nenhuma venda cadastrada no momento
            </div>
        @else
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Vendedor</th>
                    <th>Nome do Cliente</th>
                    <th>Veículo</th>
                    <th>Data da Venda</th>
                    <th>Valor da Venda</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vendas as $venda)
                    <tr class="client-row"
                        data-sale-id="{{ $venda->id }}"
                        data-client-name="{{ strtolower($venda->cliente_nome) }}"
                        data-seller-name="{{ strtolower($venda->vendedor_nome) }}"
                        data-vehicle-name="{{ strtolower($venda->veiculo_nome) }}"
                        data-sale-date="{{ $venda->data_venda }}"
                        data-sale-total-value="{{ $venda->valor_total }}"
                    >
                        <td>{{ $venda->id }}</td>
                        <td>
                            <div class="client-info-container">
                                <span class="client-name">{{ $venda->vendedor_nome ?? 'Não informado' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="client-info-container">
                                <span class="client-name">{{ $venda->cliente_nome ?? 'Não informado' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="client-info-container">
                                <span class="client-name">{{ $venda->veiculo_nome ?? 'Não informado' }}</span>
                            </div>
                        </td>
                        <td>
                            {{ $venda->data_venda ? Carbon::parse($venda->data_venda)->format('d/m/Y') : 'Não informada' }}
                        </td>
                        <td>
                            {{ $venda->valor_total !== null ? 'R$ ' . number_format($venda->valor_total, 2, ',', '.') : 'Não informado' }}
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <a href="{{ route('admin.vendas.edit', $venda->id) }}" class="edit-btn">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="delete-btn" onclick="openModal({{ $venda->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="info-toggle-btn"
                                        onclick="toggleSellerInfo({{ $venda->id }})">
                                    <i class="fa fa-chevron-down" id="icon-{{ $venda->id }}"></i>
                                </button>
                                <div id="modal-{{ $venda->id }}" class="custom-modal">
                                    <div class="modal-box">
                                        <div class="modal-header">
                                            <span class="modal-title">
                                                <i class="fa fa-trash text-danger"></i>
                                                <strong class="text-danger"> Confirmar Exclusão</strong>
                                            </span>
                                            <span class="close-btn"
                                                  onclick="closeModal({{ $venda->id }})">&times;</span>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir este vendedor?</p>
                                            <p><strong>Item:</strong>
                                                <strong>{{ $venda->cliente_nome }} - {{ $venda->veiculo_nome }}</strong>
                                            </p>
                                        </div>
                                        <form method="GET"
                                              action="{{ route('admin.vendas.delete', $venda->id) }}">
                                            @csrf
                                            <div class="modal-footer">
                                                <button type="button" class="btn-cancel"
                                                        onclick="closeModal({{ $venda->id }})">Cancelar
                                                </button>
                                                <button type="submit" class="btn-confirm">Excluir</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif(auth()->user() && auth()->user()->role === 'seller')
                                <button type="button" class="info-toggle-btn"
                                        onclick="toggleSellerInfo({{ $venda->id }})">
                                    <i class="fa fa-chevron-down" id="icon-{{ $venda->id }}"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    <tr class="client-details-row" id="details-{{ $venda->id }}" style="display: none;">
                        <td colspan="9">
                            <div class="client-details-content">
                                <div class="details-grid">
                                    <div class="detail-item">
                                        <strong>Comissão:</strong>
                                        <span>{{ $venda->comissao !== null ? 'R$ ' . number_format($venda->comissao, 2, ',', '.') : 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Placa:</strong>
                                        <span>{{ $venda->placa ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Cor do veículo:</strong>
                                        <span>{{ $venda->veiculo_cor ?? 'Não informado' }}</span>
                                    </div>
                                </div>
                                @if($venda->observacoes)
                                    <div class="observations">
                                        <strong>Observações:</strong>
                                        <p>{{ $venda->observacoes }}</p>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <div class="pagination-container">
            {{ $vendas->links('partials.pagination') }}
        </div>
    </div>

    <script>
        function toggleSellerInfo(sellerId) {
            const detailsRow = document.getElementById('details-' + sellerId);
            const icon = document.getElementById('icon-' + sellerId);

            if (!icon) {
                console.error('Ícone não encontrado para sellerId:', sellerId);
                return;
            }

            const toggleBtn = icon.parentElement;
            if (!toggleBtn || !toggleBtn.classList.contains('info-toggle-btn')) {
                console.error('Botão toggle não encontrado para sellerId:', sellerId);
                return;
            }

            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                detailsRow.style.display = 'table-row';
                toggleBtn.classList.add('active');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                detailsRow.style.display = 'none';
                toggleBtn.classList.remove('active');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }

            updateCollapseAllButton();
        }

        function collapseAllSellers() {
            const detailsRows = document.querySelectorAll('.client-details-row');
            const toggleBtns = document.querySelectorAll('.info-toggle-btn');

            detailsRows.forEach(row => {
                row.style.display = 'none';
            });

            toggleBtns.forEach(btn => {
                btn.classList.remove('active');
            });

            updateCollapseAllButton();
        }

        function updateCollapseAllButton() {
            const collapseBtn = document.querySelector('.collapse-all-btn');
            const activeDropdowns = document.querySelectorAll('.info-toggle-btn.active');

            console.log("Active toggles:", activeDropdowns.length);

            if (activeDropdowns.length === 0) {
                collapseBtn.disabled = true;
                collapseBtn.innerHTML = '<i class="fa fa-chevron-down"></i> Nenhum Expandido';
            } else {
                collapseBtn.disabled = false;
                collapseBtn.innerHTML = `<i class="fa fa-chevron-up"></i> Recolher Todos (${activeDropdowns.length})`;
            }
        }

        // Inicializar o estado do botão quando a página carregar
        document.addEventListener('DOMContentLoaded', function () {
            updateCollapseAllButton();
            initializeFilters();
        });

        function updateClientCount(count) {
            const totalElement = document.getElementById('total-clients-text');
            const totalClients = {{ $vendas->total() }};

            if (count === totalClients) {
                totalElement.textContent = `Total: ${totalClients} veículos cadastrados`;
            } else {
                totalElement.textContent = `Mostrando: ${count} de ${totalClients} veículos`;
            }
        }

        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
        }

        window.onclick = function (event) {
            document.querySelectorAll('.custom-modal').forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
            @endif

            @if(session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
            @endif
        });
    </script>
@endsection
