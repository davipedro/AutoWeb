@extends('layouts.app')

@section('title', 'Cadastrar Novo Veículo')

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="add-header">
            <a href="{{ route(auth()->user()->role . '.veiculos.list') }}" class="back-button">
                <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>
            <div>
                <h1 class="page-title">Cadastrar Novo Veículo</h1>
                <p class="page-subtitle">Preencha as informações do veículo</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route(auth()->user()->role . '.veiculos.store') }}" method="POST">
            @csrf

            <div class="form-container">
                <!-- Informações Básicas -->
                <div class="form-section">
                    <h2 class="section-title">Informações Básicas</h2>
                    <p class="section-subtitle">Dados principais do veículo</p>

                    <div class="form-grid">
                        <!-- Marca e Modelo -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text"
                                       id="marca"
                                       name="marca"
                                       placeholder="Ex: Honda"
                                       value="{{ old('marca') }}"
                                       class="form-input @error('marca') error-input @enderror">
                                @error('marca')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text"
                                       id="modelo"
                                       name="modelo"
                                       placeholder="Ex: Civic, Nivus"
                                       value="{{ old('modelo') }}"
                                       class="form-input @error('modelo') error-input @enderror">
                                @error('modelo')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Ano e Quilometragem -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ano" class="form-label">Ano</label>
                                <input type="number"
                                       id="ano"
                                       name="ano"
                                       placeholder="Ex: 2022"
                                       value="{{ old('ano') }}"
                                       min="1900"
                                       max="{{ date('Y') + 1 }}"
                                       class="form-input @error('ano') error-input @enderror">
                                @error('ano')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="quilometragem" class="form-label">Quilometragem (Km)</label>
                                <input type="number"
                                       id="quilometragem"
                                       name="quilometragem"
                                       placeholder="Ex: 15.000Km"
                                       value="{{ old('quilometragem') }}"
                                       min="0"
                                       class="form-input @error('quilometragem') error-input @enderror">
                                @error('quilometragem')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Combustível e Cor -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tipo_combustivel" class="form-label">Combustível</label>
                                <select id="tipo_combustivel"
                                        name="tipo_combustivel"
                                        class="form-select @error('tipo_combustivel') error-input @enderror">
                                    <option value="">Tipo de combustível</option>
                                    <option value="gasolina" {{ old('combustivel') == 'gasolina' ? 'selected' : '' }}>Gasolina</option>
                                    <option value="etanol" {{ old('combustivel') == 'etanol' ? 'selected' : '' }}>Etanol</option>
                                    <option value="flex" {{ old('combustivel') == 'flex' ? 'selected' : '' }}>Flex</option>
                                    <option value="diesel" {{ old('combustivel') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="eletrico" {{ old('combustivel') == 'eletrico' ? 'selected' : '' }}>Elétrico</option>
                                    <option value="hibrido" {{ old('combustivel') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                    <option value="alcool" {{ old('combustivel') == 'alcool' ? 'selected' : '' }}>Álcool</option>
                                    <option value="gnv" {{ old('combustivel') == 'gnv' ? 'selected' : '' }}>GNV</option>
                                    <option value="hidrogenio" {{ old('combustivel') == 'hidrogenio' ? 'selected' : '' }}>Hidrogênio</option>
                                </select>
                                @error('tipo_combustivel')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cor" class="form-label">Cor</label>
                                <input type="text"
                                       id="cor"
                                       name="cor"
                                       placeholder="Ex: Branco, Prata"
                                       value="{{ old('cor') }}"
                                       class="form-input @error('cor') error-input @enderror">
                                @error('cor')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="transmissao" class="form-label">Transmissão</label>
                                <select id="transmissao"
                                        name="transmissao"
                                        class="form-select @error('transmissao') error-input @enderror">
                                    <option value="">Tipo de transmissão</option>
                                    <option value="automatica" {{ old('transmissao') == 'automatica' ? 'selected' : '' }}>Automática</option>
                                    <option value="manual" {{ old('transmissao') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="cvt" {{ old('transmissao') == 'cvt' ? 'selected' : '' }}>CVT</option>
                                    <option value="auto_dupla_emb" {{ old('transmissao') == 'auto_dupla_emb' ? 'selected' : '' }}>Automática de Dupla Embreagem</option>
                                </select>
                                @error('transmissao')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Valores e Documentação -->
                <div class="form-section">
                    <h2 class="section-title">Valores e Documentação</h2>
                    <p class="section-subtitle">Informações financeiras e documentais</p>

                    <div class="form-grid">
                        <!-- Valores -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="valor_custo" class="form-label money">Valor de Custo (R$)</label>
                                <input type="text"
                                       id="valor_custo"
                                       name="valor_custo"
                                       placeholder="Ex: 77.000,00"
                                       value="{{ old('valor_custo') }}"
                                       step="0.01"
                                       min="0"
                                       class="form-input @error('valor_custo') error-input @enderror">
                                @error('valor_custo')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="valor_venda" class="form-label money">Valor de Venda (R$)</label>
                                <input type="text"
                                       id="valor_venda"
                                       name="valor_venda"
                                       placeholder="Ex: 85.000,00"
                                       value="{{ old('valor_venda') }}"
                                       step="0.01"
                                       min="0"
                                       class="form-input @error('valor_venda') error-input @enderror">
                                @error('valor_venda')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Placa e Chassi -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text"
                                       id="placa"
                                       name="placa"
                                       placeholder="Ex: ABC-1234"
                                       value="{{ old('placa') }}"
                                       class="form-input @error('placa') error-input @enderror">
                                @error('placa')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="chassi" class="form-label">Chassi</label>
                                <input type="text"
                                       id="chassi"
                                       name="chassi"
                                       placeholder="Número do chassi"
                                       value="{{ old('chassi') }}"
                                       class="form-input @error('chassi') error-input @enderror">
                                @error('chassi')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status_id" class="form-label">Status</label>
                            <select id="status_id"
                                    name="status_id"
                                    class="form-select @error('status_id') error-input @enderror">
                                <option value="">Selecione um status</option>
                                @foreach ($statuses as $status)
                                    @if ($status->nome !== "inativo")
                                        <option value="{{ $status->id }}"
                                            {{ old('status_id', $status->id == 1 ? $status->id : null) == $status->id ? 'selected' : '' }}>
                                            {{ __('status.' . $status->nome) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('status_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observações -->
                        <div class="form-group">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea id="observacoes"
                                      name="observacoes"
                                      rows="4"
                                      placeholder="Informações adicionais sobre o veículo..."
                                      class="form-textarea @error('observacoes') error-input @enderror">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="{{ route(auth()->user()->role . '.veiculos.list') }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Cadastrar Veículo
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function formatCurrency(input) {
                input.addEventListener('blur', function(e) {
                    let valor = e.target.value;

                    // Remove pontos e troca vírgula por ponto
                    valor = valor.replace(/\./g, '').replace(',', '.');

                    const parsed = parseFloat(valor);

                    if (!isNaN(parsed)) {
                        // Formata como pt-BR: vírgula como decimal, ponto como milhar
                        e.target.value = parsed.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else {
                        e.target.value = '';
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function() {

                const form = document.querySelector('form'); // ajuste se precisar, use o seletor correto

                // Máscara para placa
                const placaInput = document.getElementById('placa');
                placaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
                    if (value.length > 3) {
                        value = value.slice(0, 3) + '-' + value.slice(3, 7);
                    }
                    e.target.value = value;
                });

                // Formatação de valores monetários
                const valorCustoInput = document.getElementById('valor_custo');
                const valorVendaInput = document.getElementById('valor_venda');

                formatCurrency(valorCustoInput);
                formatCurrency(valorVendaInput);

                // Formatação de quilometragem
                const quilometragemInput = document.getElementById('quilometragem');
                quilometragemInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                });

                form.addEventListener('submit', function (e) {
                    // Função para converter "12.345,67" → "12345.67"
                    function convertBRLToNumber(value) {
                        if (!value) return '';
                        return value.replace(/\./g, '').replace(',', '.');
                    }

                    valorCustoInput.value = convertBRLToNumber(valorCustoInput.value);
                    valorVendaInput.value = convertBRLToNumber(valorVendaInput.value);
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                @if ($errors->any())
                    let errorMessages = '';
                    @foreach ($errors->all() as $error)
                        errorMessages += '• {{ $error }}\n';
                    @endforeach

                    Toastify({
                        text: errorMessages.trim(),
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
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

                @if(session('success'))
                    Toastify({
                        text: "{{ session('success') }}",
                        duration: 4000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    }).showToast();
                @endif
            });
        </script>
    @endpush

@endsection
