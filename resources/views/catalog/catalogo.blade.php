@extends('layouts.app')

@section('title', 'Catálogo de Veículos')

@section('content')
    @php
        $marcas = $veiculosDisponiveis->pluck('marca')->unique()->sort()->values();
        $status = $veiculosDisponiveis->pluck('status_nome')->unique()->sort()->values();
        $anos = $veiculosDisponiveis->pluck('ano')->unique()->sortDesc()->values();
    @endphp

    <div class="catalog-container">
        <!-- FILTROS -->
        <div class="filter-box">
            <h2><strong>Filtrar Veículos</strong></h2>
            <p class="filter-subtitle">Use os filtros para encontrar o veículo ideal</p>

            <div class="filter-options">
                <input type="text" id="model_search" placeholder="Buscar por modelo..." />

                <select id="brand_search">
                    <option value="">Todas as Marcas</option>
                    @foreach($marcas as $marca)
                        <option value="{{ strtolower($marca) }}">{{ $marca }}</option>
                    @endforeach
                </select>

                <select id="year_search">
                    <option value="">Todos os Anos</option>
                    @foreach($anos as $ano)
                        <option value="{{ $ano }}">{{ $ano }}</option>
                    @endforeach
                </select>

                <button type="button" class="clear-filters-btn" onclick="clearAllFilters()">
                    <i class="fa fa-times"></i> Limpar Filtros
                </button>
            </div>
        </div>

        <!-- CONTADOR -->
        <div id="total-vehicles-text" class="vehicle-count">
            Total de Veículos exibidos: {{ $veiculosDisponiveis->count() }}
        </div>

        <!-- GRID DE VEÍCULOS -->
        <div class="vehicle-grid">
            @foreach ($veiculosDisponiveis as $veiculo)
                <div class="vehicle-card vehicle-row"
                     data-vehicle-id="{{ $veiculo->id }}"
                     data-model="{{ strtolower($veiculo->modelo) }}"
                     data-brand="{{ strtolower($veiculo->marca) }}"
                     data-year="{{ $veiculo->ano }}"
                     data-full-name="{{ strtolower($veiculo->marca . ' ' . $veiculo->modelo) }}"
                >
                    <div class="vehicle-image">
                        @php
                            $marca = strtolower(str_replace(' ', '_', $veiculo->marca));
                            $modelo = strtolower(str_replace(' ', '_', $veiculo->modelo));
                            $veiculo->imagem = $marca . '_' . $modelo . '.png';
                        @endphp
                        <img src="{{ asset('assets/images/vehicles/' . $veiculo->imagem) }}" alt="Imagem do Veículo" />
                    </div>
                    <div class="vehicle-info">
                        <div style="display: flex; justify-content: space-between">
                            <h3>{{ $veiculo->marca }} {{ $veiculo->modelo }}</h3>
                            <a href="#" onclick="openModal({{ $veiculo->id }})" class="open-modal-btn" alt="Modal Informações do Veículo">
                                <i class="fa fa-info-circle"></i>
                            </a>
                        </div>
                        <p class="price">R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</p>
                        <ul>
                            <li>{{ $veiculo->ano }}</li>
                            <li>{{ __('combustiveis.' . $veiculo->tipo_combustivel) }}</li>
                            <li>{{ $veiculo->quilometragem }} Km</li>
                        </ul>
                        <span class="badge">{{ $veiculo->cor ?? 'Branco' }}</span>
                        <a href="https://wa.me/5538998546298?text=Olá,%20tudo%20bem?%20Gostaria%20de%20mais%20informações%20sobre%20o%20veículo%20{{ $veiculo->marca }}%20{{ $veiculo->modelo }}%20na%20cor%20{{ $veiculo->cor }}."
                            class="interest-button">
                            Tenho Interesse
                        </a>
                    </div>
                </div>

                <div id="modal-{{ $veiculo->id }}" class="custom-modal catalog-modal">
                    <div class="modal-box catalog-modal-box">
                        <div class="modal-header catalog-modal-header">
                            <span class="modal-title catalog-modal-title">
                                <i class="fa fa-info-circle"></i>
                                <strong class="text-danger"> Informações do Veículo:</strong>
                            </span>
                            <span class="close-btn" onclick="closeModal({{ $veiculo->id }})">&times;</span>
                        </div>

                        <div class="modal-body catalog-modal-body">
                            <div class="vehicle-details">
                                <p><strong>Marca:</strong> {{ $veiculo->marca }}</p>
                                <p><strong>Modelo:</strong> {{ $veiculo->modelo }}</p>
                                <p><strong>Ano:</strong> {{ $veiculo->ano }}</p>
                                <p><strong>Combustível:</strong> {{ __('combustiveis.' . $veiculo->tipo_combustivel) }}</p>
                                <p><strong>Quilometragem:</strong> {{ $veiculo->quilometragem }} Km</p>
                                <p><strong>Cor:</strong> {{ $veiculo->cor }}</p>
                                <p><strong>Transmissão:</strong> {{ __('transmissoes.' . $veiculo->transmissao) }}</p>
                                <p><strong>Valor de Venda:</strong> R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function initializeFilters() {
            document.getElementById('model_search').addEventListener('input', filterVehicles);
            document.getElementById('brand_search').addEventListener('change', filterVehicles);
            document.getElementById('year_search').addEventListener('change', filterVehicles);
        }

        function clearAllFilters() {
            document.getElementById('model_search').value = '';
            document.getElementById('brand_search').value = '';
            document.getElementById('year_search').value = '';

            filterVehicles();
        }

        function filterVehicles() {
            const modelFilter = document.getElementById('model_search').value.toLowerCase();
            const brandFilter = document.getElementById('brand_search').value.toLowerCase();
            const yearFilter = document.getElementById('year_search').value;

            const vehicleRows = document.querySelectorAll('.vehicle-row');
            let visibleCount = 0;

            vehicleRows.forEach(row => {
                const fullName = row.dataset.fullName;
                const model = row.dataset.model;
                const brand = row.dataset.brand;
                const year = row.dataset.year;

                const matchModel = !modelFilter || fullName.includes(modelFilter) || model.includes(modelFilter);
                const matchBrand = !brandFilter || brand === brandFilter;
                // Comparar valores como string para evitar falha de comparação
                const matchYear = !yearFilter || String(year) === yearFilter;

                if (matchModel && matchBrand && matchYear) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            updateVehicleCount(visibleCount);
        }

        function updateVehicleCount(count) {
            const totalElement = document.getElementById('total-vehicles-text');
            const totalVehicles = {{ $veiculosDisponiveis->count() }};

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

        document.addEventListener('DOMContentLoaded', function () {
            initializeFilters();
            updateCollapseAllButton();
        });
    </script>
@endsection
