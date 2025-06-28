@extends('layouts.app')

@section('title', 'Gestão de Clientes')

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
            <h1 class="page-title">Gestão de Clientes</h1>
            <p class="subheading">Gerencie os clientes cadastrados</p>
        </div>

        <div>
            <a href="{{ route(auth()->user()->role . '.clientes.add') }}" class="add-btn">+ Cadastrar Novo Cliente</a>
        </div>
    </div>

    <form method="GET" action="{{ route(auth()->user()->role . '.clientes.list') }}" class="filters">
        <div class="filter-options">
            <input
                type="text"
                name="nome"
                class="input-field"
                placeholder="Nome"
                value="{{ $filters['nome'] ?? '' }}"
            >

            <input
                type="text"
                name="email"
                class="input-field"
                placeholder="Email"
                value="{{ $filters['email'] ?? '' }}"
            >

            <input
                type="text"
                name="telefone"
                class="input-field"
                placeholder="Telefone"
                value="{{ $filters['telefone'] ?? '' }}"
            >

            <input
                type="text"
                name="cpf"
                class="input-field"
                placeholder="CPF"
                value="{{ $filters['cpf'] ?? '' }}"
            >

            <select name="cidade" class="input-select">
                <option value="">Cidade</option>
                @foreach($cidades as $cidade)
                    <option value="{{ $cidade }}" {{ ($filters['cidade'] ?? '') === $cidade ? 'selected' : '' }}>
                        {{ $cidade }}
                    </option>
                @endforeach
            </select>

            <select name="estado" class="input-select">
                <option value="">Estado</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado }}" {{ ($filters['estado'] ?? '') == $estado ? 'selected' : '' }}>
                        {{ $estado }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="filter-btn">
                <i class="fa fa-filter"></i> Filtrar
            </button>

            <a href="{{ route(auth()->user()->role . '.clientes.list') }}" class="clear-filters-btn">
                <i class="fa fa-times"></i> Limpar
            </a>
        </div>
    </form>

    <div class="client-list">
        <div class="list-header">
            <div>
                <h2>Lista de Clientes</h2>
                <p id="total-clients-text">Total: {{ $clientes->total() }} clientes cadastrados</p>
            </div>
            <button type="button" class="collapse-all-btn" onclick="collapseAllClients()">
                <i class="fa fa-chevron-up"></i>
                Recolher Todos
            </button>
        </div>

        @if($clientes->isEmpty())
            <div class="no-clients-message">
                Nenhum cliente cadastrado no momento
            </div>
        @else
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clientes as $cliente)
                    <tr class="client-row"
                        data-client-id="{{ $cliente->id }}"
                        data-name="{{ strtolower($cliente->nome_completo) }}"
                        data-telefone="{{ $cliente->telefone }}"
                        data-email="{{ strtolower($cliente->email) }}"
                        data-cpf="{{ $cliente->cpf }}"
                        data-cidade="{{ $cliente->cidade }}"
                    >
                        <td>{{ $cliente->id }}</td>
                        <td>
                            <div class="client-info-container">
                                <span class="client-name">{{ $cliente->nome_completo }}</span>
                            </div>
                        </td>
                        <td>
                            {{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cliente->cpf) }}
                        </td>
                        <td>
                            {{ $cliente->data_nascimento ? Carbon::parse($cliente->data_nascimento)->format('d/m/Y') : '' }}
                        </td>
                        <td>{{ $cliente->email }}</td>
                        <td>
                            <a href="https://api.whatsapp.com/send?phone=55{{$cliente->telefone}}" alt="Whatsapp link">
                                {{ formatPhone($cliente->telefone) }}
                            </a>
                            <i class="fa fa-link" id="icon-{{ $cliente->id }}"></i>
                        </td>
                        <td>{{ $cliente->cidade}}</td>
                        <td>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="edit-btn">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="delete-btn" onclick="openModal({{ $cliente->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="info-toggle-btn"
                                        onclick="toggleClientInfo({{ $cliente->id }})">
                                    <i class="fa fa-chevron-down" id="icon-{{ $cliente->id }}"></i>
                                </button>

                                <div id="modal-{{ $cliente->id }}" class="custom-modal">
                                    <div class="modal-box">
                                        <div class="modal-header">
                                            <span class="modal-title">
                                                <i class="fa fa-trash text-danger"></i>
                                                <strong class="text-danger"> Confirmar Exclusão</strong>
                                            </span>
                                            <span class="close-btn" onclick="closeModal({{ $cliente->id }})">&times;</span>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir este cliente?</p>
                                            <p><strong>Item:</strong>
                                                <strong>{{ $cliente->nome_completo }} - {{ $cliente->cpf }}</strong></p>
                                        </div>
                                        <form method="GET" action="{{ route('admin.clientes.delete', $cliente->id) }}">
                                            @csrf
                                            <div class="modal-footer">
                                                <button type="button" class="btn-cancel"
                                                        onclick="closeModal({{ $cliente->id }})">Cancelar
                                                </button>
                                                <button type="submit" class="btn-confirm">Excluir</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif(auth()->user() && auth()->user()->role === 'seller')
                                <button type="button" class="info-toggle-btn"
                                        onclick="toggleClientInfo({{ $cliente->id }})">
                                    <i class="fa fa-chevron-down" id="icon-{{ $cliente->id }}"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    <tr class="client-details-row" id="details-{{ $cliente->id }}" style="display: none;">
                        <td colspan="9">
                            <div class="client-details-content">
                                <div class="details-grid">
                                    <div class="detail-item">
                                        <strong>RG:</strong>
                                        <span>{{ $cliente->rg ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Endereço:</strong>
                                        <span>{{ $cliente->endereco ?? 'Não informado' }}</span>
                                    </div><div class="detail-item">
                                        <strong>Complemento:</strong>
                                        <span>{{ $cliente->complemento ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Cidade:</strong>
                                        <span>{{ $cliente->cidade ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Estado:</strong>
                                        <span>{{ $cliente->estado ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>CEP:</strong>
                                        <span>
                                            {{ preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cliente->cep) }}
                                        </span>
                                    </div>
                                </div>
                                @if($cliente->observacoes)
                                    <div class="observations">
                                        <strong>Observações:</strong>
                                        <p>{{ $cliente->observacoes }}</p>
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
            {{ $clientes->links('partials.pagination') }}
        </div>
    </div>

    <script>
        function toggleClientInfo(clientId) {
            const detailsRow = document.getElementById('details-' + clientId);
            const icon = document.getElementById('icon-' + clientId);
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

        function collapseAllClients() {
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

            if (activeDropdowns.length === 0) {
                collapseBtn.disabled = true;
                collapseBtn.innerHTML = '<i class="fa fa-chevron-up"></i> Nenhum Expandido';
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
            const totalClients = {{ $clientes->total() }};

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
