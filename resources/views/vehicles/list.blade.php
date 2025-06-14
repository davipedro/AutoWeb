@extends('layouts.app')

@section('title', 'Gestão de Veículos')

@section('content')
    <div class="vehicles-header">
        <div>
            <h1>Gestão de Veículos</h1>
            <p class="subheading">Gerencie o estoque de veículos</p>
        </div>

        <div>
            <a href="{{ route('veiculos.add') }}" class="add-btn">+ Cadastrar Novo Veículo</a>
        </div>
    </div>

    <div class="filters">
        <div class="filter-options">
            <input type="text" id="model_search" placeholder="Buscar por modelo..." />
            <select id="brand_search">
                <option value="">Todas as Marcas</option>
                @php
                    $marcas = collect($veiculosArray['itens'])->pluck('marca')->unique()->sort()->values();
                @endphp
                @foreach($marcas as $marca)
                    <option value="{{ $marca }}">{{ $marca }}</option>
                @endforeach
            </select>
            <select id="status_search">
                <option value="">Todos os Status</option>
                @php
                    $status = collect($veiculosArray['itens'])->pluck('status_nome')->unique()->sort()->values();
                @endphp
                @foreach($status as $statusItem)
                    <option value="{{ $statusItem }}">
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
            <select id="year_search">
                <option value="">Todos os Anos</option>
                @php
                    $anos = collect($veiculosArray['itens'])->pluck('ano')->unique()->sortDesc()->values();
                @endphp
                @foreach($anos as $ano)
                    <option value="{{ $ano }}">{{ $ano }}</option>
                @endforeach
            </select>
            <button type="button" class="clear-filters-btn" onclick="clearAllFilters()">
                <i class="fa fa-times"></i>
                Limpar Filtros
            </button>
        </div>
    </div>

    <div class="vehicle-list">
        <div class="list-header">
            <div>
                <h2>Lista de Veículos</h2>
                <p>Total: {{ $veiculosArray['count'] }} veículos cadastrados</p>
            </div>
            <button type="button" class="collapse-all-btn" onclick="collapseAllVehicles()">
                <i class="fa fa-chevron-up"></i>
                Recolher Todos
            </button>
        </div>

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
            <!-- Início do bloco de repetição -->
            @foreach($veiculosArray['itens'] as $veiculo)
                <tr class="vehicle-row"
                    data-vehicle-id="{{ $veiculo->id }}"
                    data-brand="{{ strtolower($veiculo->marca) }}"
                    data-model="{{ strtolower($veiculo->modelo) }}"
                    data-full-name="{{ strtolower($veiculo->marca . ' ' . $veiculo->modelo) }}"
                    data-year="{{ $veiculo->ano }}"
                    data-status="{{ $veiculo->status_nome }}"
                >
                    <td>{{ $veiculo->id }}</td>
                    <td>
                        <div class="vehicle-info-container">
                            <span class="vehicle-name">{{ $veiculo->marca }} {{ $veiculo->modelo }}</span>
                        </div>
                    </td>
                    <td>{{ $veiculo->ano }}</td>
                    <td>{{ $veiculo->quilometragem }} Km</td>
                    <td class="price-cost">R$ {{ $veiculo->valor_custo }}</td>
                    <td class="price-sale">R$ {{ $veiculo->valor_venda }}</td>
                    <td>{{ $veiculo->tipo_combustivel }}</td>
                    <td>
                        <span class="status-badge status-{{ $veiculo->status_nome }}">
                            @if($veiculo->status_nome == "disponivel")
                                Disponível
                            @elseif($veiculo->status_nome == "vendido")
                                Vendido
                            @elseif($veiculo->status_nome == "indisponivel")
                                Indisponível
                            @elseif($veiculo->status_nome == "reservado")
                                Reservado
                            @elseif($veiculo->status_nome == "manutencao")
                                Em Manutenção
                            @endif
                        </span>
                    </td>
                    <td>
                        <button type="button" class="edit-btn">
                            <i class="fa fa-edit"></i>
                        </button>
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
                                <form method="POST" action="{{ route('veiculos.delete', $veiculo->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-footer">
                                        <button type="button" class="btn-cancel" onclick="closeModal({{ $veiculo->id }})">Cancelar</button>
                                        <button type="submit" class="btn-confirm">Excluir</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </td>
                </tr>
                <!-- Início Linha de detalhes expandida -->
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
                                    <span>{{ $veiculo->transmissao ?? 'Não informado' }}</span>
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
                <!-- Fim Linha de detalhes expandida -->
            @endforeach
            <!-- Fim do bloco de repetição -->
            </tbody>
        </table>
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

        function initializeFilters() {
            const modelSearch = document.getElementById('model_search');
            const brandSearch = document.getElementById('brand_search');
            const statusSearch = document.getElementById('status_search');
            const yearSearch = document.getElementById('year_search');

            // Adicionar event listeners para todos os filtros
            modelSearch.addEventListener('input', filterVehicles);
            brandSearch.addEventListener('change', filterVehicles);
            statusSearch.addEventListener('change', filterVehicles);
            yearSearch.addEventListener('change', filterVehicles);
        }

        function filterVehicles() {
            const modelFilter = document.getElementById('model_search').value.toLowerCase();
            const brandFilter = document.getElementById('brand_search').value.toLowerCase();
            const statusFilter = document.getElementById('status_search').value.toLowerCase();
            const yearFilter = document.getElementById('year_search').value;

            const vehicleRows = document.querySelectorAll('.vehicle-row');
            let visibleCount = 0;

            vehicleRows.forEach(function(row) {
                const detailsRow = document.querySelector('#details-' + row.dataset.vehicleId);

                // Extrair dados dos data attributes
                const fullName = row.dataset.fullName || '';
                const brand = row.dataset.brand || '';
                const model = row.dataset.model || '';
                const year = row.dataset.year || '';
                const status = row.dataset.status || '';

                // Aplicar filtros
                const matchModel = !modelFilter ||
                    fullName.includes(modelFilter) ||
                    model.includes(modelFilter);

                const matchBrand = !brandFilter || brand === brandFilter;
                const matchStatus = !statusFilter || status === statusFilter;
                const matchYear = !yearFilter || year === yearFilter;

                if (matchModel && matchBrand && matchStatus && matchYear) {
                    row.style.display = '';
                    if (detailsRow && detailsRow.style.display === 'table-row') {
                        detailsRow.style.display = 'table-row';
                    }
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                    if (detailsRow) {
                        detailsRow.style.display = 'none';
                    }
                }
            });

            // Atualizar contador
            updateVehicleCount(visibleCount);
        }

        function updateVehicleCount(count) {
            const totalElement = document.querySelector('.list-header p');
            const totalVehicles = {{ $veiculosArray['count'] }};

            if (count === totalVehicles) {
                totalElement.textContent = `Total: ${totalVehicles} veículos cadastrados`;
            } else {
                totalElement.textContent = `Mostrando: ${count} de ${totalVehicles} veículos`;
            }
        }

        function clearAllFilters() {
            document.getElementById('model_search').value = '';
            document.getElementById('brand_search').value = '';
            document.getElementById('status_search').value = '';
            document.getElementById('year_search').value = '';

            filterVehicles(); // Aplicar filtros limpos
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
    </script>
@endsection
