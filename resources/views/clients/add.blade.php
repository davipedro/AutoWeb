@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

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
            <a href="{{ route('clientes.list') }}" class="back-button">
                <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>
            <div>
                <h1 class="page-title">Cadastrar Novo Cliente</h1>
                <p class="page-subtitle">Preencha os dados do cliente</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="form-container">
                <!-- Informações Básicas -->
                <div class="form-section">
                    <h2 class="section-title">Informações Básicas</h2>
                    <p class="section-subtitle">Dados principais do cliente</p>

                    <div class="form-grid">
                        <!-- Nome Completo -->
                        <div class="form-group">
                            <label for="nome_completo" class="form-label">Nome do cliente</label>
                            <input type="text"
                                   id="nome_completo"
                                   name="nome_completo"
                                   placeholder="Insira o nome do cliente"
                                   value="{{ old('nome_completo') }}"
                                   class="form-input @error('nome_completo') error-input @enderror">
                            @error('nome_completo')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CPF e RG -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text"
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

                        <!-- Email e Telefone -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text"
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
                                   id="data_nascimento"
                                   name="data_nascimento"
                                   value="{{ old('data_nascimento') }}"
                                   class="form-input @error('data_nascimento') error-input @enderror">
                            @error('data_nascimento')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Informações de endereço -->
                <div class="form-section">
                    <h2 class="section-title">Enderço e Observações</h2>
                    <p class="section-subtitle">Informações sobre residência e observações</p>

                    <div class="form-grid">
                        <!-- Endereço, Cidade e Estado -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="endereco" class="form-label">Endereço</label>
                                <input type="text"
                                       id="endereco"
                                       name="endereco"
                                       placeholder="Rua Gavea, 21, Bairro Jardim"
                                       value="{{ old('endereco') }}"
                                       class="form-input @error('endereco') error-input @enderror">
                                @error('endereco')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text"
                                       id="complemento"
                                       name="complemento"
                                       placeholder="Apto 301"
                                       value="{{ old('complemento') }}"
                                       class="form-input @error('complemento') error-input @enderror">
                                @error('complemento')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text"
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
                <a href="{{ route('clientes.list') }}" class="btn btn-secondary">
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

                // === Máscara CPF ===
                const cpfInput = document.getElementById('cpf');
                cpfInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.slice(0, 11);
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    e.target.value = value;
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

                    if (cpf && !validarCPF(cpf)) {
                        alert("CPF inválido!");
                        cpfInput.classList.add("error-input");
                    } else {
                        cpfInput.classList.remove("error-input");
                    }
                });

                // === Máscara para Telefone ===
                const telefoneInput = document.getElementById('telefone');

                telefoneInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');

                    // Aplica a máscara manualmente
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
