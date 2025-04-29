<?php
/**
 * Simulador Educacional (Demo)
 * Versão demonstrativa limitada a 12 meses de simulação
 * 
 * @author Luaraujo Premium 2025
 * @version 1.0
 */

// Carregar dependências
require_once '../../includes/functions.php';
require_once '../../config/config.php';

// Definir variáveis da página
$page_title = "Simulador Educacional (Demo) | Luaraujo";
$page_description = "Simule investimentos em renda fixa com período limitado a 12 meses.";

// Incluir cabeçalho
include '../../includes/header.php';
?>

<div class="container py-5">
    <!-- Cabeçalho da página -->
    <div class="hero-section text-center mb-5 p-4">
        <h1 class="display-5 fw-bold">Simulador Educacional <i class="fas fa-calculator"></i></h1>
        <p class="lead mb-0">Versão demonstrativa limitada a 12 meses de simulação</p>
        <div class="badge bg-warning text-dark mt-2 p-2">VERSÃO DEMO</div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Conceitos básicos de investimentos -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Conceitos Básicos de Investimentos <i class="fas fa-book"></i></h3>
                </div>
                <div class="card-body">
                    <div id="tipsContent">
                        <ul>
                            <li><strong>Juros Compostos:</strong> São os juros que incidem não apenas sobre o <i>capital inicial</i>, mas também sobre os juros acumulados em períodos anteriores. É o chamado "juros sobre juros".</li>
                            <li><strong>CDI (Certificado de Depósito Interbancário):</strong> É uma <i>taxa de referência</i> no mercado financeiro brasileiro, muito utilizada para remunerar investimentos de <strong>renda fixa</strong>.</li>
                            <li><strong>Renda Fixa vs Renda Variável:</strong> <strong>Renda fixa</strong> tem retornos mais previsíveis e menor risco, enquanto <strong>renda variável</strong> pode ter maiores retornos mas com maior risco.</li>
                            <li><strong>Inflação:</strong> Aumento generalizado dos preços que reduz o <i>poder de compra</i> do dinheiro ao longo do tempo.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Formulário de simulação -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Parâmetros da Simulação <i class="fas fa-sliders-h"></i></h3>
                </div>
                <div class="card-body">
                    <form id="simulador-form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="valorInicial" class="form-label">Valor Inicial (R$):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="number" class="form-control" id="valorInicial" min="0" step="100" value="1000" required>
                                </div>
                                <small class="text-muted">Montante inicial a ser investido</small>
                            </div>
                            <div class="col-md-6">
                                <label for="aporteMensal" class="form-label">Aporte Mensal (R$):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="number" class="form-control" id="aporteMensal" min="0" step="100" value="500" required>
                                </div>
                                <small class="text-muted">Valor a ser investido mensalmente</small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipoRendimento" class="form-label">Tipo de Rendimento:</label>
                                <select class="form-select" id="tipoRendimento" required>
                                    <option value="fixa">Taxa Fixa</option>
                                    <option value="cdi">Taxa do CDI</option>
                                </select>
                                <small class="text-muted">Escolha entre uma taxa fixa ou CDI</small>
                            </div>
                            <div class="col-md-6">
                                <label for="prazo" class="form-label">Prazo (meses):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="number" class="form-control" id="prazo" min="1" max="12" value="12" required>
                                </div>
                                <small class="text-muted">Limitado a 12 meses na versão demo</small>
                            </div>
                        </div>
                        
                        <div id="taxaFixaGroup" class="mb-3">
                            <label for="taxaFixa" class="form-label">Taxa Fixa Mensal (%):</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <input type="number" class="form-control" id="taxaFixa" step="0.01" min="0" value="0.8">
                            </div>
                            <small class="text-muted">Taxa de rendimento mensal</small>
                        </div>
                        
                        <div id="cdiGroup" style="display: none;" class="mb-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="taxaCDI" class="form-label">Taxa CDI Anual (%):</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        <input type="number" class="form-control" id="taxaCDI" step="0.01" min="0" value="13.15">
                                    </div>
                                    <small class="text-muted">Taxa do CDI anual</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="percentualCDIComImposto" class="form-label">% do CDI (Com IR):</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        <input type="number" class="form-control" id="percentualCDIComImposto" step="1" min="0" max="200" value="100">
                                    </div>
                                    <small class="text-muted">% do CDI para ativos com IR</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="percentualCDISemImposto" class="form-label">% do CDI (Sem IR):</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        <input type="number" class="form-control" id="percentualCDISemImposto" step="1" min="0" max="200" value="93">
                                    </div>
                                    <small class="text-muted">% do CDI para ativos isentos de IR</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="inflacao" class="form-label">Inflação Anual Estimada (%):</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                <input type="number" class="form-control" id="inflacao" step="0.1" min="0" value="4.5">
                            </div>
                            <small class="text-muted">Estimativa de inflação anual</small>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="goalAmount" class="form-label">Meta Financeira (R$):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                    <input type="number" class="form-control" id="goalAmount" min="0" step="1000" value="10000">
                                </div>
                                <small class="text-muted">Valor que deseja acumular</small>
                            </div>
                            <div class="col-md-6">
                                <label for="goalYears" class="form-label">Prazo para Meta (anos):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                    <input type="number" class="form-control" id="goalYears" min="1" step="1" value="1">
                                </div>
                                <small class="text-muted">Prazo para atingir a meta</small>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="button" onclick="calcularRentabilidadeDemo()" class="btn btn-primary btn-lg">
                                <i class="fas fa-calculator me-2"></i> Calcular Simulação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Resultados da simulação -->
            <div id="results" class="card mb-4" style="display: none;">
                <div class="card-header bg-success text-white">
                    <h3 class="h5 mb-0">Resultados da Simulação <i class="fas fa-chart-line"></i></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Valor Inicial:</th>
                                    <td>R$ <span id="resultValorInicial"></span></td>
                                </tr>
                                <tr>
                                    <th>Aporte Mensal:</th>
                                    <td>R$ <span id="resultAporteMensal"></span></td>
                                </tr>
                                <tr>
                                    <th>Prazo:</th>
                                    <td><span id="resultPrazo"></span> meses</td>
                                </tr>
                                <tr>
                                    <th>Taxa de Rendimento:</th>
                                    <td><span id="resultTaxaRendimento"></span>% ao mês</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Valor Final:</th>
                                    <td>R$ <span id="resultValorFinal"></span></td>
                                </tr>
                                <tr>
                                    <th>Ganho Total:</th>
                                    <td>R$ <span id="resultGanhoTotal"></span></td>
                                </tr>
                                <tr>
                                    <th>Inflação Acumulada:</th>
                                    <td><span id="resultInflacaoAcumulada"></span>%</td>
                                </tr>
                                <tr>
                                    <th>Valor Final Ajustado (Inflação):</th>
                                    <td>R$ <span id="resultValorFinalAjustado"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="chart-container mt-4">
                        <canvas id="chartSimulacao"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Comparações de investimentos -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Comparações <i class="fas fa-balance-scale"></i></h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Investimento</th>
                                <th>Valor Final</th>
                                <th>Ganho Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Poupança</td>
                                <td id="comparacaoPoupancaValorFinal">-</td>
                                <td id="comparacaoPoupancaGanhoTotal">-</td>
                            </tr>
                            <tr>
                                <td>CDB</td>
                                <td id="comparacaoCDBValorFinal">-</td>
                                <td id="comparacaoCDBGanhoTotal">-</td>
                            </tr>
                            <tr>
                                <td>LCI/LCA</td>
                                <td id="comparacaoLCILCAValorFinal">-</td>
                                <td id="comparacaoLCILCAGanhoTotal">-</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="chart-container">
                        <canvas id="chartComparacoes"></canvas>
                    </div>
                    
                    <div class="mt-3">
                        <h4 class="h6">Laudo Comparativo <i class="fas fa-file-alt"></i></h4>
                        <p id="laudoComparativo" class="small">Execute a simulação para ver o laudo comparativo.</p>
                        <p id="laudoMeta" class="small">Preencha os campos de meta financeira para ver a análise.</p>
                        <p id="laudoPercentualCDB" class="small">Execute a simulação para ver a equivalência de rendimentos.</p>
                    </div>
                </div>
            </div>
            
            <!-- Banner promoção versão premium -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Versão Premium <i class="fas fa-crown"></i></h3>
                </div>
                <div class="card-body">
                    <h4 class="h6 mb-3">Desbloqueie Todas as Funcionalidades!</h4>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Simulações para períodos ilimitados</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Opções de inflação variável</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Exportação de resultados em PDF</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Comparações detalhadas entre investimentos</li>
                        <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Análise personalizada de metas financeiras</li>
                    </ul>
                    <a href="/produtos/premium?ref=simulador-demo" class="btn btn-success btn-lg d-block">
                        <i class="fas fa-unlock me-2"></i> Obter Acesso Premium
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/calculadoras/chart-helpers.js"></script>
<script src="/assets/js/calculadoras/simulador.js"></script>
<script>
    // Inicialização específica para versão demo
    document.addEventListener('DOMContentLoaded', function() {
        // Limitar campo de prazo na versão demo
        const prazoInput = document.getElementById('prazo');
        if (prazoInput) {
            prazoInput.max = 12;
            prazoInput.setAttribute('max', '12');
        }
        
        // Configurar mudança de exibição dos campos de taxa
        document.getElementById('tipoRendimento').addEventListener('change', mostrarCamposTaxaComBaseNoTipo);
        
        // Mostrar campos iniciais
        mostrarCamposTaxaComBaseNoTipo();
    });
</script>

<?php
// Incluir rodapé
include '../../includes/footer.php';
?>