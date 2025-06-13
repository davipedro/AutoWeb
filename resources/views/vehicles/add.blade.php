@extends('layouts.app')

@section('title', 'Cadastrar Novo Veículo')

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="add-header">
            <a href="{{ route('veiculos.list') }}" class="back-button">
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
        <form action="{{ route('veiculos.store') }}" method="POST">
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
                                <label for="combustivel" class="form-label">Combustível</label>
                                <select id="combustivel"
                                        name="combustivel"
                                        class="form-select @error('combustivel') error-input @enderror">
                                    <option value="">Tipo de combustível</option>
                                    <option value="gasolina" {{ old('combustivel') == 'gasolina' ? 'selected' : '' }}>Gasolina</option>
                                    <option value="etanol" {{ old('combustivel') == 'etanol' ? 'selected' : '' }}>Etanol</option>
                                    <option value="flex" {{ old('combustivel') == 'flex' ? 'selected' : '' }}>Flex</option>
                                    <option value="diesel" {{ old('combustivel') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="eletrico" {{ old('combustivel') == 'eletrico' ? 'selected' : '' }}>Elétrico</option>
                                    <option value="hibrido" {{ old('combustivel') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                                @error('combustivel')
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
                                <label for="valor_custo" class="form-label">Valor de Custo (R$)</label>
                                <input type="number"
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
                                <label for="valor_venda" class="form-label">Valor de Venda (R$)</label>
                                <input type="number"
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
                            <label for="status" class="form-label">Status</label>
                            <select id="status"
                                    name="status"
                                    class="form-select @error('status') error-input @enderror">
                                <option value="disponivel" {{ old('status') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                                <option value="vendido" {{ old('status') == 'vendido' ? 'selected' : '' }}>Vendido</option>
                                <option value="indisponivel" {{ old('status') == 'indisponivel' ? 'selected' : '' }}>Indisponível</option>
                                <option value="reservado" {{ old('status') == 'reservado' ? 'selected' : '' }}>Reservado</option>
                                <option value="manutencao" {{ old('status') == 'manutencao' ? 'selected' : '' }}>Em Manutenção</option>
                            </select>
                            @error('status')
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
                <a href="{{ route('veiculos.list') }}" class="btn btn-secondary">
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
            document.addEventListener('DOMContentLoaded', function() {
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

                function formatCurrency(input) {
                    input.addEventListener('blur', function(e) {
                        const value = parseFloat(e.target.value);
                        if (!isNaN(value)) {
                            e.target.value = value.toFixed(2);
                        }
                    });
                }

                formatCurrency(valorCustoInput);
                formatCurrency(valorVendaInput);

                // Formatação de quilometragem
                const quilometragemInput = document.getElementById('quilometragem');
                quilometragemInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                });
            });
        </script>
    @endpush
@endsection
