@extends('layouts.app')

@section('title', 'Registrar Nova Venda')

@section('content')

    @php
        $estados = [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        ];
    @endphp

    <div class="container">
        <!-- Header -->
        <div class="add-header">
            <a href="{{ route(auth()->user()->role . '.clientes.list') }}" class="back-button">
                <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>
            <div>
                <h1 class="page-title">Registrar Nova Venda</h1>
                <p class="page-subtitle">Preencha os dados do cliente</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route(auth()->user()->role . '.sell.store') }}" method="POST">
            @csrf

            <div class="form-container">
                <!-- Informações Básicas -->
                <div class="form-section">
                    <h2 class="section-title">Informações Pessoais</h2>
                    <p class="section-subtitle">Dados principais do cliente</p>

                    <div class="form-grid">
                        <!-- CPF e RG -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text"
                                       required
                                       id="cpf"
                                       name="cpf"
                                       placeholder="123.456.789-00"
                                       value="{{ old('cpf') }}"
                                       class="form-input @error('cpf') error-input @enderror">
                                @error('cpf')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rg" class="form-label">RG</label>
                                <input type="text"
                                       required
                                       id="rg"
                                       name="rg"
                                       placeholder="12.345.678-9"
                                       value="{{ old('rg') }}"
                                       class="form-input @error('rg') error-input @enderror">
                                @error('rg')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Nome Completo -->
                        <div class="form-group">
                            <label for="nome_completo" class="form-label">Nome do cliente</label>
                            <input type="text"
                                   required
                                   id="nome_completo"
                                   name="nome_completo"
                                   placeholder="Insira o nome do cliente"
                                   minlength="2"
                                   value="{{ old('nome_completo') }}"
                                   class="form-input @error('nome_completo') error-input @enderror">
                            @error('nome_completo')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email e Telefone -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text"
                                       required
                                       id="email"
                                       name="email"
                                       placeholder="email@example.com"
                                       value="{{ old('email') }}"
                                       class="form-input @error('email') error-input @enderror">
                                @error('email')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text"
                                       required
                                       id="telefone"
                                       name="telefone"
                                       placeholder="(01) 23456-7890"
                                       value="{{ old('telefone') }}"
                                       class="form-input @error('telefone') error-input @enderror">
                                @error('telefone')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="form-group">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date"
                                   required
                                   id="data_nascimento"
                                   name="data_nascimento"
                                   value="{{ old('data_nascimento') }}"
                                   class="form-input @error('data_nascimento') error-input @enderror">
                            @error('data_nascimento')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text"
                                   required
                                   id="endereco"
                                   name="endereco"
                                   placeholder="Rua Gavea, 21, Bairro Jardim"
                                   value="{{ old('endereco') }}"
                                   class="form-input @error('endereco') error-input @enderror">
                            @error('endereco')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text"
                                       required
                                       id="cidade"
                                       name="cidade"
                                       placeholder="Belo Horizonte"
                                       value="{{ old('cidade') }}"
                                       class="form-input @error('cidade') error-input @enderror">
                                @error('cidade')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <select id="estado"
                                        name="estado"
                                        class="form-select @error('estado') error-input @enderror">
                                    <option value="">Selecione um estado</option>
                                    @foreach ($estados as $sigla => $nome)
                                        <option value="{{ $sigla }}" {{ old('estado') == $sigla ? 'selected' : '' }}>
                                            {{ $nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text"
                                       required
                                       id="cep"
                                       name="cep"
                                       placeholder="37203-000"
                                       value="{{ old('cep') }}"
                                       class="form-input @error('cep') error-input @enderror">
                                @error('cep')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações de endereço -->
                <div class="form-section">
                    <h2 class="section-title">Informações da Venda</h2>
                    <p class="section-subtitle">Dados principais da transação</p>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="veiculo" class="form-label">Veículo</label>
                            <select id="veiculo"
                                    name="veiculo"
                                    class="form-select @error('estado') error-input @enderror">
                                <option value="">Selecione um veículo</option>
                                @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}" {{ old('estado') == $veiculo->nome ? 'selected' : '' }}>
                                        {{ $veiculo->marca }} {{ $veiculo->modelo }} - {{ $veiculo->ano }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="vendedor_cpf" class="form-label">CPF do Vendedor</label>
                            <input type="text"
                                   required
                                   id="vendedor_cpf"
                                   name="vendedor_cpf"
                                   placeholder="00.000.000-00"
                                   value="{{ old('vendedor_cpf') }}"
                                   class="form-input @error('vendedor_cpf') error-input @enderror">
                            @error('vendedor_cpf')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data_venda" class="form-label">Data da Venda</label>
                            <input type="date"
                                   required
                                   id="data_venda"
                                   name="data_venda"
                                   value="{{ old('data_venda') }}"
                                   class="form-input @error('data_venda') error-input @enderror">
                            @error('data_venda')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <br>
                        <h2 class="section-title">Informações Financeiras</h2>
                        <p class="section-subtitle">Valores e forma de pagamento</p>

                        <!-- Valor da Venda -->
                        <div class="form-group">
                            <label for="valor_venda" class="form-label">Valor da Venda (R$)</label>
                            <input type="text"
                                   id="valor_venda"
                                   name="valor_venda"
                                   placeholder="R$ 0,00"
                                   value="{{ old('valor_venda') }}"
                                   inputmode="decimal"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="metodo_pagamento" class="form-label">Método Pagamento</label>
                            <select id="metodo_pagamento"
                                    name="metodo_pagamento"
                                    class="form-select @error('estado') error-input @enderror">
                                <option value="metodo_pagamento">Selecione o Método</option>
                                @foreach ($metodosPagamento as $metodo)
                                    <option value="{{ $metodo }}" {{ old('estado') == $metodo ? 'selected' : '' }}>
                                        {{ $metodo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('metodo_pagamento')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Valor da Comissao -->
                        <div class="form-group">
                            <label for="valor_comissao" class="form-label">Comissão Calculada</label>
                            <input type="text"
                                   id="valor_comissao"
                                   name="valor_comissao"
                                   placeholder="R$ 0,00"
                                   value="{{ old('valor_comissao') }}"
                                   inputmode="decimal"
                                   readonly
                                   class="form-input form-input-readonly">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Cadastrar Cliente
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('form');
                const valorVendaInput = document.getElementById('valor_venda');
                const valorComissaoInput = document.getElementById('valor_comissao');
                const vendedorCpfInput = document.getElementById('vendedor_cpf');
                const rawCommissions = @json($porcentagemComissao ?? []);
                const cpfInput = document.getElementById('cpf');

                const cleanCommissions = {};
                for (const punctuatedCpf in rawCommissions) {
                    const cleanCpf = punctuatedCpf.replace(/\D/g, ''); // Limpa a chave
                    cleanCommissions[cleanCpf] = rawCommissions[punctuatedCpf]; // Associa a comissão à chave limpa
                }

                // === Máscara CPF ===
                cpfInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.slice(0, 11);
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    e.target.value = value;
                });

                vendedorCpfInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.slice(0, 11);
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    e.target.value = value;
                });


                function formatCurrency(value) {
                    if (isNaN(value) || value === 0) {
                        return 'R$ 0,00';
                    }
                    return new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(value);
                }

                function cleanCurrency(value) {
                    if (!value) return 0.00;
                    let numericString = value.replace(/\D/g, '');
                    return parseFloat(numericString) / 100;
                }

                function calculateAndDisplayCommission() {
                    const inputCpf = vendedorCpfInput.value.replace(/\D/g, '');
                    const commissionRate = cleanCommissions[inputCpf] || 0;
                    const saleValue = cleanCurrency(valorVendaInput.value);
                    const commissionValue = saleValue * commissionRate;
                    valorComissaoInput.value = formatCurrency(commissionValue);
                }

                valorVendaInput.addEventListener('input', function() {
                    let rawValue = this.value.replace(/\D/g, '');
                    this.value = formatCurrency(parseFloat(rawValue) / 100);
                    calculateAndDisplayCommission();
                });

                vendedorCpfInput.addEventListener('blur', function() {
                    calculateAndDisplayCommission();
                });

                form.addEventListener('submit', function(e) {
                    valorVendaInput.value = cleanCurrency(valorVendaInput.value).toFixed(2);
                    valorComissaoInput.value = cleanCurrency(valorComissaoInput.value).toFixed(2);
                });

                if (valorVendaInput.value && vendedorCpfInput.value) {
                    calculateAndDisplayCommission();
                }

                valorVendaInput.addEventListener('input', function(e) {
                    formatCurrency(e.target);
                });

                // === Máscara RG ===
                const rgInput = document.getElementById('rg');
                rgInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 9) value = value.slice(0, 9);
                    value = value.replace(/(\d{2})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1})$/, '$1-$2');
                    e.target.value = value;
                });

                // === Validação de Email ===
                const emailInput = document.getElementById('email');
                emailInput.addEventListener('blur', function () {
                    const email = emailInput.value;
                    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    if (!isValid && email !== '') {
                        alert("Email inválido!");
                        emailInput.classList.add("error-input");
                    } else {
                        emailInput.classList.remove("error-input");
                    }
                });

                // === Validação de CPF ===
                cpfInput.addEventListener('blur', function () {
                    const cpf = cpfInput.value.replace(/\D/g, '');

                    function validarCPF(cpf) {
                        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

                        let soma = 0;
                        for (let i = 0; i < 9; i++) {
                            soma += parseInt(cpf.charAt(i)) * (10 - i);
                        }
                        let digito1 = 11 - (soma % 11);
                        digito1 = digito1 >= 10 ? 0 : digito1;

                        if (digito1 !== parseInt(cpf.charAt(9))) return false;

                        soma = 0;
                        for (let i = 0; i < 10; i++) {
                            soma += parseInt(cpf.charAt(i)) * (11 - i);
                        }
                        let digito2 = 11 - (soma % 11);
                        digito2 = digito2 >= 10 ? 0 : digito2;

                        return digito2 === parseInt(cpf.charAt(10));
                    }
                });

                // === Máscara para Telefone ===
                const telefoneInput = document.getElementById('telefone');

                telefoneInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');

                    // Máscara manual
                    if (value.length > 11) {
                        value = value.slice(0, 11);
                    }

                    if (value.length > 0) {
                        value = '(' + value;
                    }
                    if (value.length > 3) {
                        value = value.slice(0, 3) + ') ' + value.slice(3);
                    }
                    if (value.length > 10) {
                        value = value.slice(0, 10) + '-' + value.slice(10);
                    }

                    e.target.value = value;
                });

                // Validação ao sair do campo
                telefoneInput.addEventListener('blur', function () {
                    const telefone = telefoneInput.value.replace(/\D/g, '');
                    const telefoneValido = /^(\d{2})9\d{8}$/.test(telefone);
                    if (telefone && !telefoneValido) {
                        alert('Telefone inválido! Use o formato (99) 9XXXX-XXXX');
                        telefoneInput.classList.add('error-input');
                    } else {
                        telefoneInput.classList.remove('error-input');
                    }
                });

                // === Validação data de nascimento ===
                const dataNascimentoInput = document.getElementById('data_nascimento');

                dataNascimentoInput.addEventListener('blur', function () {
                    const value = dataNascimentoInput.value;

                    if (!value) return;

                    const dataNascimento = new Date(value + 'T00:00:00'); // evita erro de fuso
                    const hoje = new Date();
                    const anoAtual = hoje.getFullYear();

                    const anoNascimento = dataNascimento.getFullYear();

                    // Verifica se o ano é maior que o atual
                    if (anoNascimento > anoAtual) {
                        alert('Ano de nascimento não pode ser maior que o ano atual.');
                        dataNascimentoInput.classList.add('error-input');
                        return;
                    }

                    // Verifica se tem 18 anos
                    const idade = hoje.getFullYear() - dataNascimento.getFullYear();
                    const mes = hoje.getMonth() - dataNascimento.getMonth();
                    const dia = hoje.getDate() - dataNascimento.getDate();

                    const maiorDeIdade =
                        idade > 18 ||
                        (idade === 18 && (mes > 0 || (mes === 0 && dia >= 0)));

                    if (!maiorDeIdade) {
                        alert('Cliente deve ter pelo menos 18 anos.');
                        dataNascimentoInput.classList.add('error-input');
                    } else {
                        dataNascimentoInput.classList.remove('error-input');
                    }
                });

                // === Máscara para CEP ===
                const cepInput = document.getElementById('cep');

                cepInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');

                    if (value.length > 8) {
                        value = value.slice(0, 8);
                    }

                    if (value.length > 5) {
                        value = value.slice(0, 5) + '-' + value.slice(5);
                    }

                    e.target.value = value;
                });

                cepInput.addEventListener('blur', function () {
                    const cep = cepInput.value;
                    const isValid = /^\d{5}-\d{3}$/.test(cep);

                    if (cep && !isValid) {
                        alert("CEP inválido! Use o formato 99999-999.");
                        cepInput.classList.add("error-input");
                    } else {
                        cepInput.classList.remove("error-input");
                    }
                });

                // === Toasts de Erro / Sucesso ===
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
