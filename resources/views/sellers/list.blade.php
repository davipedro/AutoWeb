@extends('layouts.app')

@section('title', 'Gestão de Vendedores')

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
            <h1 class="page-title">Gestão de Vendedores</h1>
            <p class="subheading">Gerencie os vendedores cadastrados</p>
        </div>

        <div style="display: flex; flex-direction: column; align-items: flex-end;">
            @if($usuariosDisponiveis->isNotEmpty())
                <a href="{{ route('admin.vendedores.add') }}" class="add-btn">+ Cadastrar Novo Vendedor</a>
            @else
                <a href="{{ route('register') }}" class="add-btn">+ Cadastrar Novo Usuário</a>
                <p>Não há usuários disponíveis para cadastrar como vendedor.</p>
            @endif
        </div>
    </div>

    <form method="GET" action="{{ route('admin.vendedores.list') }}" class="filters">
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

            <a href="{{ route('admin.vendedores.list') }}" class="clear-filters-btn">
                <i class="fa fa-times"></i> Limpar
            </a>
        </div>
    </form>

    <div class="client-list">
        <div class="list-header">
            <div>
                <h2>Lista de Vendedores</h2>
                <p id="total-clients-text">Total: {{ $vendedores->total() }} vendedores cadastrados</p>
            </div>
            <button type="button" class="collapse-all-btn" onclick="collapseAllSellers()">
                <i class="fa fa-chevron-up"></i>
                Recolher Todos
            </button>
        </div>

        @if($vendedores->isEmpty())
            <div class="no-clients-message">
                Nenhum vendedor cadastrado no momento
            </div>
        @else
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Admissão</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vendedores as $vendedor)
                    <tr class="client-row"
                        data-client-id="{{ $vendedor->id }}"
                        data-name="{{ strtolower($vendedor->nome_completo) }}"
                        data-telefone="{{ $vendedor->telefone }}"
                        data-email="{{ strtolower($vendedor->email) }}"
                        data-cpf="{{ $vendedor->cpf }}"
                        data-cidade="{{ $vendedor->cidade }}"
                    >
                        <td>{{ $vendedor->id }}</td>
                        <td>
                            <div class="client-info-container">
                                <span class="client-name">{{ $vendedor->nome_completo }}</span>
                            </div>
                        </td>
                        <td>
                            {{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $vendedor->cpf) }}
                        </td>
                        <td>
                            {{ $vendedor->data_admissao ? Carbon::parse($vendedor->data_admissao)->format('d/m/Y') : '' }}
                        </td>
                        <td>{{ $vendedor->email }}</td>
                        <td>
                            <a href="https://api.whatsapp.com/send?phone=55{{$vendedor->telefone}}" alt="Whatsapp link">
                                {{ formatPhone($vendedor->telefone) }}
                            </a>
                            <i class="fa fa-link" id="icon-link-{{ $vendedor->id }}"></i>
                        </td>
                        <td>{{ $vendedor->cidade}}</td>
                        <td>
                            <a href="{{ route('admin.vendedores.edit', $vendedor->id) }}" class="edit-btn">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button class="delete-btn" onclick="openModal({{ $vendedor->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button type="button" class="info-toggle-btn"
                                    onclick="toggleSellerInfo({{ $vendedor->id }})">
                                <i class="fa fa-chevron-down" id="icon-{{ $vendedor->id }}"></i>
                            </button>

                            <div id="modal-{{ $vendedor->id }}" class="custom-modal">
                                <div class="modal-box">
                                    <div class="modal-header">
                                        <span class="modal-title">
                                            <i class="fa fa-trash text-danger"></i>
                                            <strong class="text-danger"> Confirmar Exclusão</strong>
                                        </span>
                                        <span class="close-btn"
                                              onclick="closeModal({{ $vendedor->id }})">&times;</span>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tem certeza que deseja excluir este vendedor?</p>
                                        <p><strong>Item:</strong>
                                            <strong>{{ $vendedor->nome_completo }} - {{ $vendedor->cpf }}</strong>
                                        </p>
                                    </div>
                                    <form method="GET"
                                          action="{{ route('admin.vendedores.delete', $vendedor->id) }}">
                                        @csrf
                                        <div class="modal-footer">
                                            <button type="button" class="btn-cancel"
                                                    onclick="closeModal({{ $vendedor->id }})">Cancelar
                                            </button>
                                            <button type="submit" class="btn-confirm">Excluir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="client-details-row" id="details-{{ $vendedor->id }}" style="display: none;">
                        <td colspan="9">
                            <div class="client-details-content">
                                <div class="details-grid">
                                    <div class="detail-item">
                                        <strong>RG:</strong>
                                        <span>{{ $vendedor->rg ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Endereço:</strong>
                                        <span>{{ $vendedor->endereco ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Complemento:</strong>
                                        <span>{{ $vendedor->complemento ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Cidade:</strong>
                                        <span>{{ $vendedor->cidade ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Estado:</strong>
                                        <span>{{ $vendedor->estado ?? 'Não informado' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>CEP:</strong>
                                        <span>
                                            {{ preg_replace('/(\d{5})(\d{3})/', '$1-$2', $vendedor->cep) }}
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Salário:</strong>
                                        <span>
                                             {{ $vendedor->salario !== null ? 'R$ ' . number_format($vendedor->salario, 2, ',', '.') : 'Não informado' }}
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Comissão:</strong>
                                        <span>
                                            {{ $vendedor->comissao . ' %' ?? 'Não informado' }}
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Data de Admissão:</strong>
                                        <span>
                                            {{ $vendedor->data_admissao ? Carbon::parse($vendedor->data_admissao)->format('d/m/Y') : 'Não informado' }}
                                        </span>
                                    </div>
                                </div>
                                @if($vendedor->observacoes)
                                    <div class="observations">
                                        <strong>Observações:</strong>
                                        <p>{{ $vendedor->observacoes }}</p>
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
            {{ $vendedores->links('partials.pagination') }}
        </div>
    </div>

    <script>
        function toggleSellerInfo(sellerId) {
            const detailsRow = document.getElementById('details-' + sellerId);
            const icon = document.getElementById('icon-' + sellerId);

            if (!icon) {
                console.error('Ícone não encontrado para sellerId:', sellerId);
                return;
            }

            const toggleBtn = icon.parentElement;
            if (!toggleBtn || !toggleBtn.classList.contains('info-toggle-btn')) {
                console.error('Botão toggle não encontrado para sellerId:', sellerId);
                return;
            }

            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                detailsRow.style.display = 'table-row';
                toggleBtn.classList.add('active');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                detailsRow.style.display = 'none';
                toggleBtn.classList.remove('active');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }

            updateCollapseAllButton();
        }

        function collapseAllSellers() {
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

            console.log("Active toggles:", activeDropdowns.length);

            if (activeDropdowns.length === 0) {
                collapseBtn.disabled = true;
                collapseBtn.innerHTML = '<i class="fa fa-chevron-down"></i> Nenhum Expandido';
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
            const totalClients = {{ $vendedores->total() }};

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
