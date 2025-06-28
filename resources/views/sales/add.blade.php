@extends('layouts.app')

@section('title', 'Editar Vendedor')

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
                <h1 class="page-title">Cadastrar Vendas</h1>
                <p class="page-subtitle">Insira os dados da venda</p>
            </div>
        </div>

        <form action="{{ route(auth()->user()->role . '.vendas.store') }}" method="POST">
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
                                    class="form-select @error('cliente_id') error-input @enderror">
                                <option value="">Selecione um usuário</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nome_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nome do vendedor -->
                        <div class="form-group">
                            <label for="cpf">Nome do Vendedor</label>
                            <select name="vendedor_id" id="vendedor_id"
                                    class="form-select @error('vendedor_id') error-input @enderror"
                                    @if(auth()->user()->role === 'seller') disabled @endif>
                                <option value="">Selecione um vendedor</option>
                                @foreach ($vendedores as $vendedor)
                                    <option value="{{ $vendedor->id }}"
                                            data-comissao="{{ $vendedor->comissao }}"
                                            @if( (auth()->user()->role === 'seller' && auth()->user()->id == $vendedor->user_id) || old('vendedor_id') == $vendedor->id )
                                                selected
                                        @endif
                                    >
                                        {{ $vendedor->nome_completo }}
                                    </option>
                                @endforeach
                            </select>

                            @error('vendedor_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <!-- Veículo -->
                        <div class="form-group">
                            <label for="veiculo_id">Veículo</label>
                            <select name="veiculo_id" id="veiculo_id"
                                    class="form-select @error('veiculo_id') error-input @enderror">
                                <option value="">Selecione o veículo</option>
                                @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}" {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                                        {{ $veiculo->marca }} {{ $veiculo->modelo }} - {{ $veiculo->ano }}
                                    </option>
                                @endforeach
                            </select>
                            @error('veiculo_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="form-section">
                    <h2 class="section-title">Informações da venda</h2>
                    <p class="section-subtitle">Informações do veículo e valores</p>

                    <div class="form-grid">
                        <div class="form-row">
                            <!-- Data de admissão -->
                            <div class="form-group">
                                <label for="data_venda">Data da Venda</label>
                                <input type="date" id="data_venda" name="data_venda"
                                       class="form-input @error('data_venda') error-input @enderror"
                                       value="{{ old('data_venda') }}">
                                @error('data_venda') <p class="error-message">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label for="valor_total">Valor da Venda</label>
                                <input type="text" name="valor_total" id="valor_total"
                                       class="form-input @error('valor_total') error-input @enderror"
                                       placeholder="R$ 50.000,00"
                                       value="{{ old('valor_total') }}">
                                @error('valor_total') <p class="error-message">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label for="comissao">Comissao</label>
                                <input type="text" name="comissao" id="comissao"
                                       class="form-input @error('comissao') error-input @enderror"
                                       placeholder="R$ 0,00"
                                       value="{{ old('comissao') }}"
                                       readonly>
                                @error('comissao') <p class="error-message">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label for="metodo_pagamento">Método de Pagamento</label>
                                <select name="metodo_pagamento" id="metodo_pagamento"
                                        class="form-select @error('metodo_pagamento') error-input @enderror">
                                    <option value="">Selecione o método</option>
                                    <option value="credito" {{ old('metodo_pagamento') == 'credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                                    <option value="debito" {{ old('metodo_pagamento') == 'debito' ? 'selected' : '' }}>Cartão de Débito</option>
                                    <option value="dinheiro" {{ old('metodo_pagamento') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                                    <option value="pix" {{ old('metodo_pagamento') == 'pix' ? 'selected' : '' }}>PIX</option>
                                    <option value="boleto" {{ old('metodo_pagamento') == 'boleto' ? 'selected' : '' }}>Boleto Bancário</option>
                                    <option value="transferencia" {{ old('metodo_pagamento') == 'transferencia' ? 'selected' : '' }}>Transferência</option>
                                </select>
                                @error('metodo_pagamento') <p class="error-message">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" rows="4"
                                      class="form-textarea @error('observacoes') error-input @enderror">{{ old('observacoes') }}</textarea>
                            @error('observacoes') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.vendedores.list') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
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
                /* === Variáveis de elementos === */
                const valorInput     = document.getElementById('valor_total');
                const comissaoInput  = document.getElementById('comissao');
                const vendedorSelect = document.getElementById('vendedor_id');

                /* === Máscara de moeda com prefixo R$ === */
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

                /* === Cálculo da comissão === */
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

                /* === Eventos === */
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
