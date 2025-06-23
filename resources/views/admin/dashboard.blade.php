@extends('layouts.app')

@section('title', 'Dashboard Administrativo')

@section('content')
    <div class="dashboard-admin">
        <!-- Cabeçalho -->
        <div class="dashboard-admin__header">
            <h1 class="dashboard-admin__title">Dashboard Administrativo</h1>
            <p class="dashboard-admin__subtitle">Visão geral do sistema de vendas</p>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="dashboard-admin__stats-grid">
            <!-- Vendas do Mês -->
            <div class="dashboard-admin__stat-card dashboard-admin__stat-card--primary">
                <div class="dashboard-admin__stat-content">
                    <div class="dashboard-admin__stat-label">Vendas do Mês</div>
                    <div class="dashboard-admin__stat-value">{{ $vendasMes ?? '-' }}</div>
                    @if(isset($porcentAumento))
                        <div class="dashboard-admin__stat-growth">
                            <i class="fas fa-arrow-up"></i> {{ $porcentAumento }} % em relação ao mês anterior
                        </div>
                    @endif
                </div>
            </div>

            <!-- Veículos Disponíveis -->
            <div class="dashboard-admin__stat-card dashboard-admin__stat-card--success">
                <div class="dashboard-admin__stat-content">
                    <div class="dashboard-admin__stat-label">Veículos Disponíveis</div>
                    <div class="dashboard-admin__stat-value">{{ $veiculosDisponiveis ?? '-' }}</div>
                    <div class="dashboard-admin__stat-description">Em estoque</div>
                </div>
            </div>

            <!-- Valor em Estoque -->
            <div class="dashboard-admin__stat-card dashboard-admin__stat-card--info">
                <div class="dashboard-admin__stat-content">
                    <div class="dashboard-admin__stat-label">Valor em Estoque</div>
                    <div class="dashboard-admin__stat-value">
                        R$ {{ number_format($valorEstoque ?? '0', 2, ',', '.') }}
                    </div>
                    <div class="dashboard-admin__stat-description">Total investido</div>
                </div>
            </div>

            <!-- Vendedores Ativos -->
            <div class="dashboard-admin__stat-card dashboard-admin__stat-card--warning">
                <div class="dashboard-admin__stat-content">
                    <div class="dashboard-admin__stat-label">Vendedores Ativos</div>
                    <div class="dashboard-admin__stat-value">{{ $vendedoresAtivos ?? '0' }}</div>
                    <div class="dashboard-admin__stat-description">Equipe de vendas</div>
                </div>
            </div>
        </div>

        <!-- Seção Principal -->
        <div class="dashboard-admin__main-section">
            <!-- Ranking de Vendedores -->
            <div class="dashboard-admin__ranking-section">
                <div class="dashboard-admin__ranking-card">
                    <div class="dashboard-admin__ranking-header">
                        <h6 class="dashboard-admin__ranking-title">Ranking de Vendedores</h6>
                        <small class="dashboard-admin__ranking-subtitle">Comissões do mês atual</small>
                    </div>
                    <div class="dashboard-admin__ranking-body">
                        @if(isset($rankingVendedores) && count($rankingVendedores) > 0)
                            @foreach($rankingVendedores as $vendedor)
                                <div class="dashboard-admin__ranking-item">
                                    <div class="dashboard-admin__ranking-info">
                                        <h6 class="dashboard-admin__ranking-name">{{ $vendedor->nome }}</h6>
                                        <small class="dashboard-admin__ranking-sales">{{ $vendedor->vendas }} vendas</small>
                                    </div>
                                    <div class="dashboard-admin__ranking-commission">
                                        R$ {{ number_format($vendedor->comissao, 3, '.', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Dados estáticos para demonstração -->
                            <div class="dashboard-admin__ranking-item">
                                <div class="dashboard-admin__ranking-info">
                                    <h6 class="dashboard-admin__ranking-name">João Silva</h6>
                                    <small class="dashboard-admin__ranking-sales">12 vendas</small>
                                </div>
                                <div class="dashboard-admin__ranking-commission">R$ 8.200</div>
                            </div>

                            <div class="dashboard-admin__ranking-item">
                                <div class="dashboard-admin__ranking-info">
                                    <h6 class="dashboard-admin__ranking-name">Maria Santos</h6>
                                    <small class="dashboard-admin__ranking-sales">10 vendas</small>
                                </div>
                                <div class="dashboard-admin__ranking-commission">R$ 8.200</div>
                            </div>

                            <div class="dashboard-admin__ranking-item">
                                <div class="dashboard-admin__ranking-info">
                                    <h6 class="dashboard-admin__ranking-name">Pedro Costa</h6>
                                    <small class="dashboard-admin__ranking-sales">8 vendas</small>
                                </div>
                                <div class="dashboard-admin__ranking-commission">R$ 8.200</div>
                            </div>

                            <div class="dashboard-admin__ranking-item dashboard-admin__ranking-item--last">
                                <div class="dashboard-admin__ranking-info">
                                    <h6 class="dashboard-admin__ranking-name">Ana Oliveira</h6>
                                    <small class="dashboard-admin__ranking-sales">6 vendas</small>
                                </div>
                                <div class="dashboard-admin__ranking-commission">R$ 8.200</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acesso Rápido -->
            <div class="dashboard-admin__quick-access-section">
                <div class="dashboard-admin__quick-access-card">
                    <div class="dashboard-admin__quick-access-header">
                        <h6 class="dashboard-admin__quick-access-title">Acesso Rápido</h6>
                        <small class="dashboard-admin__quick-access-subtitle">Atalhos para funcionalidades principais</small>
                    </div>
                    <div class="dashboard-admin__quick-access-body">
                        <!-- Cadastrar Novo Veículo -->
                        <a href="{{ route('veiculos.add') }}" class="dashboard-admin__quick-access-btn dashboard-admin__quick-access-btn--primary">
                            <div class="dashboard-admin__quick-access-btn-content">
                                <i class="fas fa-car dashboard-admin__quick-access-icon"></i>
                                <span>Cadastrar Novo Veículo</span>
                            </div>
                            <i class="fas fa-arrow-right dashboard-admin__quick-access-arrow"></i>
                        </a>

                        <!-- Cadastrar Novo Vendedor -->
                        <a href="" class="dashboard-admin__quick-access-btn dashboard-admin__quick-access-btn--success">
                            <div class="dashboard-admin__quick-access-btn-content">
                                <i class="fas fa-user-plus dashboard-admin__quick-access-icon"></i>
                                <span>Cadastrar Novo Vendedor</span>
                            </div>
                            <i class="fas fa-arrow-right dashboard-admin__quick-access-arrow"></i>
                        </a>

                        <!-- Relatório de Vendas -->
                        <a href="" class="dashboard-admin__quick-access-btn dashboard-admin__quick-access-btn--info">
                            <div class="dashboard-admin__quick-access-btn-content">
                                <i class="fas fa-chart-bar dashboard-admin__quick-access-icon"></i>
                                <span>Relatório de Vendas</span>
                            </div>
                            <i class="fas fa-arrow-right dashboard-admin__quick-access-arrow"></i>
                        </a>

                        <!-- Catálogo de veículos -->
                        <a href="{{ route('catalogo') }}" class="dashboard-admin__quick-access-btn dashboard-admin__quick-access-btn--danger">
                            <div class="dashboard-admin__quick-access-btn-content">
                                <i class="fas fa-chart-bar dashboard-admin__quick-access-icon"></i>
                                <span>Catálogo de Veículos</span>
                            </div>
                            <i class="fas fa-arrow-right dashboard-admin__quick-access-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Atualização automática dos dados a cada 5 minutos
            setInterval(function() {
                // Aqui você pode implementar uma chamada AJAX para atualizar os dados
                console.log('Atualizando dados do dashboard...');
            }, 300000); // 5 minutos
        </script>
    @endpush
@endsection
