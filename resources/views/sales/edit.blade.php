@extends('layouts.app')

@section('title', 'Editar Venda')

@section('content')
    <div class="container">
        <div class="add-header">
            <a href="{{ route(auth()->user()->role .'.vendas.list') }}" class="back-button">
                <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>
            <div>
                <h1 class="page-title">Editar Venda</h1>
                <p class="page-subtitle">Atualize os dados da venda</p>
            </div>
        </div>

        <form action="{{ route(auth()->user()->role . '.vendas.update', $venda->id) }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-container">
                <div class="form-section">
                    <h2 class="section-title">Informações dos Envolvidos</h2>
                    <p class="section-subtitle">Dados dos envolvidos na venda</p>

                    <div class="form-grid">
                        <!-- Nome do cliente -->
                        <div class="form-group">
                            <label for="cliente_id">Nome do Cliente</label>
                            <select name="cliente_id" id="cliente_id"
                                    class="form-select @error('cliente_id') error-input @enderror"
                                    @if(auth()->user()->role === 'seller') disabled @endif>
                                <option value="">Selecione um usuário</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ (old('cliente_id', $venda->cliente_id) == $cliente->id) ? 'selected' : '' }}>
                                        {{ $cliente->nome_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nome do vendedor -->
                        <div class="form-group">
                            <label for="vendedor_id">Nome do Vendedor</label>
                            <select name="vendedor_id" id="vendedor_id"
                                    class="form-select @error('vendedor_id') error-input @enderror"
                                    @if(auth()->user()->role === 'seller') disabled @endif>
                                <option value="">Selecione um vendedor</option>
                                @foreach ($vendedores as $vendedor)
                                    <option value="{{ $vendedor->id }}"
                                            data-comissao="{{ $vendedor->comissao }}"
                                        {{ (old('vendedor_id', $venda->vendedor_id) == $vendedor->id) ? 'selected' : '' }}>
                                        {{ $vendedor->nome_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendedor_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <!-- Veículo -->
                        <div class="form-group">
                            <label for="veiculo_id">Veículo</label>
                            @if(auth()->user()->role === 'seller')
                                {{-- mantém o valor no POST mesmo com <select> desabilitado --}}
                                <input type="hidden" name="veiculo_id" value="{{ old('veiculo_id', $venda->veiculo_id) }}">
                            @endif
                            <select name="veiculo_id" id="veiculo_id"
                                    class="form-select @error('veiculo_id') error-input @enderror"
                                    @if(auth()->user()->role === 'seller') disabled @endif>
                                <option value="">Selecione o veículo</option>
                                @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}"
                                        {{ old('veiculo_id', $venda->veiculo_id)==$veiculo->id ? 'selected' : '' }}>
                                        {{ $veiculo->marca }} {{ $veiculo->modelo }} - {{ $veiculo->ano }}
                                    </option>
                                @endforeach
                            </select>
                            @error('veiculo_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Informações da venda -->
                <div class="form-section">
                    <h2 class="section-title">Informações da venda</h2>
                    <p class="section-subtitle">Informações do veículo e valores</p>

                    <div class="form-grid">
                        <div class="form-row">
                            <!-- Data da venda -->
                            <div class="form-group">
                                <label for="data_venda">Data da Venda</label>
                                <input type="date" id="data_venda" name="data_venda"
                                       class="form-input @error('data_venda') error-input @enderror"
                                       value="{{ old('data_venda', $venda->data_venda ? \Carbon\Carbon::parse($venda->data_venda)->format('Y-m-d') : '') }}">
                                @error('data_venda') <p class="error-message">{{ $message }}</p> @enderror
                            </div>

                            <!-- Valor total -->
                            <div class="form-group">
                                <label for="valor_total">Valor da Venda</label>
                                <input type="text" name="valor_total" id="valor_total"
                                       class="form-input @error('valor_total') error-input @enderror"
                                       placeholder="R$ 50.000,00"
                                       value="{{ old('valor_total', number_format($venda->valor_total ?? 0, 2, ',', '.')) }}">
                                @error('valor_total') <p class="error-message">{{ $message }}</p> @enderror
                            </div>

                            <!-- Comissão -->
                            <div class="form-group">
                                <label for="comissao">Comissão</label>
                                <input type="text" name="comissao" id="comissao"
                                       class="form-input @error('comissao') error-input @enderror"
                                       placeholder="R$ 0,00"
                                       value="{{ old('comissao', number_format($venda->comissao ?? 0, 2, ',', '.')) }}"
                                       @if(auth()->user()->role === 'seller') readonly @endif>
                                @error('comissao') <p class="error-message">{{ $message }}</p> @enderror
                            </div>

                            <!-- Método de pagamento -->
                            <div class="form-group">
                                <label for="metodo_pagamento">Método de Pagamento</label>
                                <select name="metodo_pagamento" id="metodo_pagamento"
                                        class="form-select @error('metodo_pagamento') error-input @enderror">
                                    <option value="">Selecione o método</option>
                                    @php
                                        $methods = [
                                            'Cartão de Crédito',
                                            'PIX',
                                            'Dinheiro',
                                            'Transferência Bancária',
                                        ];
                                    @endphp
                                    @foreach($methods as $m)
                                        <option value="{{ $m }}"
                                            {{ old('metodo_pagamento', $venda->metodo_pagamento)===$m ? 'selected' : '' }}>
                                            {{ $m }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('metodo_pagamento') <p class="error-message">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" rows="4"
                                      class="form-textarea @error('observacoes') error-input @enderror">{{ old('observacoes', $venda->observacoes) }}</textarea>
                            @error('observacoes') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route(auth()->user()->role .'.vendas.list') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://unpkg.com/imask"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const valorInput     = document.getElementById('valor_total');
                const comissaoInput  = document.getElementById('comissao');
                const vendedorSelect = document.getElementById('vendedor_id');

                const moneyMaskOptions = {
                    mask: 'R$ num',
                    blocks: {
                        num: {
                            mask: Number,
                            scale: 2,
                            signed: false,
                            thousandsSeparator: '.',
                            padFractionalZeros: true,
                            radix: ',',
                            mapToRadix: ['.']
                        }
                    }
                };

                const valorMask    = IMask(valorInput, moneyMaskOptions);
                const comissaoMask = IMask(comissaoInput, moneyMaskOptions);

                function atualizarComissao() {
                    const opt   = vendedorSelect.options[vendedorSelect.selectedIndex];
                    const taxa  = parseFloat(opt?.dataset?.comissao ?? 0);
                    const bruto = valorMask.typedValue ? parseFloat(valorMask.typedValue) : 0;

                    if (taxa > 0 && bruto > 0) {
                        const resultado = bruto * taxa;
                        comissaoMask.typedValue = resultado;
                    } else {
                        comissaoMask.value = '';
                    }
                }

                vendedorSelect.addEventListener('change', atualizarComissao);

                let debounceTimeout;
                valorInput.addEventListener('input', () => {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(atualizarComissao, 2000);
                });
            });
        </script>
    @endpush
@endsection
