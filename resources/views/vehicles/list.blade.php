@extends('layouts.app')

@section('title', 'Gestão de Veículos')

@section('content')
    <div class="vehicles-header">
        <div>
            <h1 class="page-title">Gestão de Veículos</h1>
            <p class="subheading">Gerencie o estoque de veículos</p>
        </div>

        <div>
            <a href="{{ route(auth()->user()->role . '.veiculos.add') }}" class="add-btn">+ Cadastrar Novo Veículo</a>
        </div>
    </div>

    <form method="GET" action="{{ route(auth()->user()->role . '.veiculos.list') }}" class="filters">
        <div class="filter-options">
            <input
                type="text"
                name="modelo"
                class="input-field"
                placeholder="Buscar por modelo..."
                value="{{ $filters['modelo'] ?? '' }}"
            >

            <select name="marca" class="input-select">
                <option value="">Todas as Marcas</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca }}" {{ ($filters['marca'] ?? '') === $marca ? 'selected' : '' }}>
                        {{ $marca }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="input-select">
                <option value="">Todos os Status</option>
                @foreach($status as $statusItem)
                    <option value="{{ $statusItem }}" {{ ($filters['status'] ?? '') === $statusItem ? 'selected' : '' }}>
                        @if($statusItem == "disponivel")
                            Disponível
                        @elseif($statusItem == "vendido")
                            Vendido
                        @elseif($statusItem == "indisponivel")
                            Indisponível
                        @elseif($statusItem == "reservado")
                            Reservado
                        @else
                            Em Manutenção
                        @endif
                    </option>
                @endforeach
            </select>

            <select name="ano" class="input-select">
                <option value="">Todos os Anos</option>
                @foreach($anos as $ano)
                    <option value="{{ $ano }}" {{ ($filters['ano'] ?? '') == $ano ? 'selected' : '' }}>
                        {{ $ano }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="filter-btn">
                <i class="fa fa-filter"></i> Filtrar
            </button>

            <a href="{{ route(auth()->user()->role . '.veiculos.list') }}" class="clear-filters-btn">
                <i class="fa fa-times"></i> Limpar
            </a>
        </div>
    </form>

    <div class="vehicle-list">
        <div class="list-header">
            <div>
                <h2>Lista de Veículos</h2>
                <p id="total-vehicles-text">Total: {{ $veiculos->total() }} veículos cadastrados</p>
            </div>
            <button type="button" class="collapse-all-btn" onclick="collapseAllVehicles()">
                <i class="fa fa-chevron-up"></i>
                Recolher Todos
            </button>
        </div>

        @if($veiculos->isEmpty())
            <div class="no-vehicles-message">
                Nenhum veículo disponível no momento
            </div>
        @else
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca/Modelo</th>
                    <th>Ano</th>
                    <th>KM</th>
                    <th>Valor Custo</th>
                    <th>Valor Venda</th>
                    <th>Combustível</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($veiculos as $veiculo)
                    <tr class="vehicle-row"
                        data-vehicle-id="{{ $veiculo->id }}"
                        data-brand="{{ strtolower($veiculo->marca) }}"
                        data-model="{{ strtolower($veiculo->modelo) }}"
                        data-full-name="{{ strtolower($veiculo->marca . ' ' . $veiculo->modelo) }}"
                        data-year="{{ $veiculo->ano }}"
                        data-status="{{ $veiculo->status }}"
                    >
                        <td>{{ $veiculo->id }}</td>
                        <td>
                            <div class="vehicle-info-container">
                                <span class="vehicle-name">{{ $veiculo->marca }} {{ $veiculo->modelo }}</span>
                            </div>
                        </td>
                        <td>{{ $veiculo->ano }}</td>
                        <td>{{ number_format($veiculo->quilometragem, 0, ',', '.') }} Km</td>
                        <td class="price-cost">R$ {{ number_format($veiculo->valor_custo, 2, ',', '.') }}</td>
                        <td class="price-sale">R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</td>
                        <td>{{ __('combustiveis.' . $veiculo->tipo_combustivel) }}</td>
                        <td>
                    <span class="status-badge status-{{ $veiculo->status }}">
                        @if($veiculo->status == "disponivel")
                            Disponível
                        @elseif($veiculo->status == "vendido")
                            Vendido
                        @elseif($veiculo->status == "indisponivel")
                            Indisponível
                        @elseif($veiculo->status == "reservado")
                            Reservado
                        @elseif($veiculo->status == "manutencao")
                            Em Manutenção
                        @endif
                    </span>
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <a href="{{ route('admin.veiculos.edit', ['id' => $veiculo->id]) }}" class="edit-btn">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="delete-btn" onclick="openModal({{ $veiculo->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="info-toggle-btn" onclick="toggleVehicleInfo({{ $veiculo->id }})">
                                    <i class="fa fa-chevron-down" id="icon-{{ $veiculo->id }}"></i>
                                </button>

                                <div id="modal-{{ $veiculo->id }}" class="custom-modal">
                                    <div class="modal-box">
                                        <div class="modal-header">
                                    <span class="modal-title">
                                        <i class="fa fa-trash text-danger"></i>
                                        <strong class="text-danger"> Confirmar Exclusão</strong>
                                    </span>
                                            <span class="close-btn" onclick="closeModal({{ $veiculo->id }})">&times;</span>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir este veículo?</p>
                                            <p><strong>Item:</strong> <strong>{{ $veiculo->marca }} {{ $veiculo->modelo }}</strong></p>
                                        </div>
                                        <form method="GET" action="{{ route('admin.veiculos.delete', $veiculo->id) }}">
                                            @csrf
                                            <div class="modal-footer">
                                                <button type="button" class="btn-cancel" onclick="closeModal({{ $veiculo->id }})">Cancelar</button>
                                                <button type="submit" class="btn-confirm">Excluir</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif(auth()->user() && auth()->user()->role === 'seller')
                                <button type="button" class="info-toggle-btn" onclick="toggleVehicleInfo({{ $veiculo->id }})">
                                    <i class="fa fa-chevron-down" id="icon-{{ $veiculo->id }}"></i>
                                </button>
                            @endif

                        </td>
                    </tr>
                    <tr class="vehicle-details-row" id="details-{{ $veiculo->id }}" style="display: none;">
                        <td colspan="9">
                            <div class="vehicle-details-content">
                                <div class="details-grid">
                                    <div class="detail-item">
                                        <strong>Placa:</strong>
                                        <span>{{ $veiculo->placa ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Chassi:</strong>
                                        <span>{{ $veiculo->chassi ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Cor:</strong>
                                        <span class="color-info">
                                    @if($veiculo->cor && $veiculo->cor !== 'Não informado')
                                                <span class="color-dot" style="background-color: {{ $veiculo->cor_hex ?? '#CCCCCC' }}"></span>
                                            @endif
                                            {{ $veiculo->cor ?? 'Não informado' }}
                                </span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Transmissão:</strong>
                                        <span>{{ __('transmissoes.' . $veiculo->transmissao) }}</span>
                                    </div>
                                </div>
                                @if($veiculo->observacoes)
                                    <div class="observations">
                                        <strong>Observações:</strong>
                                        <p>{{ $veiculo->observacoes }}</p>
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
            {{ $veiculos->links('partials.pagination') }}
        </div>
    </div>

    <script>
        function toggleVehicleInfo(vehicleId) {
            const detailsRow = document.getElementById('details-' + vehicleId);
            const icon = document.getElementById('icon-' + vehicleId);
            const toggleBtn = icon.parentElement;

            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                detailsRow.style.display = 'table-row';
                toggleBtn.classList.add('active');
            } else {
                detailsRow.style.display = 'none';
                toggleBtn.classList.remove('active');
            }

            updateCollapseAllButton();
        }

        function collapseAllVehicles() {
            const detailsRows = document.querySelectorAll('.vehicle-details-row');
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

            if (activeDropdowns.length === 0) {
                collapseBtn.disabled = true;
                collapseBtn.innerHTML = '<i class="fa fa-chevron-up"></i> Nenhum Expandido';
            } else {
                collapseBtn.disabled = false;
                collapseBtn.innerHTML = `<i class="fa fa-chevron-up"></i> Recolher Todos (${activeDropdowns.length})`;
            }
        }

        // Inicializar o estado do botão quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            updateCollapseAllButton();
            initializeFilters();
        });

        function updateVehicleCount(count) {
            const totalElement = document.getElementById('total-vehicles-text');
            const totalVehicles = {{ $veiculos->total() }};

            if (count === totalVehicles) {
                totalElement.textContent = `Total: ${totalVehicles} veículos cadastrados`;
            } else {
                totalElement.textContent = `Mostrando: ${count} de ${totalVehicles} veículos`;
            }
        }

        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
        }

        window.onclick = function(event) {
            document.querySelectorAll('.custom-modal').forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
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
