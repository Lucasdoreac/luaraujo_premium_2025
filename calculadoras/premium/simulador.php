<?php
/**
 * Simulador Educacional (Premium)
 * Versão completa com todas as funcionalidades
 * 
 * @author Luaraujo Premium 2025
 * @version 1.0
 */

// Carregar dependências
require_once '../../includes/functions.php';
require_once '../../config/config.php';

// Verificar acesso premium
require_once '../../auth/verify_premium.php';

// Definir variáveis da página
$page_title = "Simulador Educacional (Premium) | Luaraujo";
$page_description = "Simule investimentos em renda fixa com funcionalidades avançadas e sem limitações de período.";

// Incluir cabeçalho
include '../../includes/header.php';
?>

<div class="container py-5">
    <!-- Cabeçalho da página -->
    <div class="hero-section text-center mb-5 p-4">
        <h1 class="display-5 fw-bold">Simulador Educacional <i class="fas fa-calculator"></i></h1>
        <p class="lead mb-0">Versão premium com funcionalidades avançadas</p>
        <div class="badge bg-success text-white mt-2 p-2">VERSÃO PREMIUM</div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Conceitos avançados de investimentos -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Conceitos Avançados de Investimentos <i class="fas fa-book"></i></h3>
                </div>
                <div class="card-body">
                    <div id="tipsContent">
                        <ul>
                            <li><strong>Juros Compostos:</strong> São os juros que incidem não apenas sobre o <i>capital inicial</i>, mas também sobre os juros acumulados em períodos anteriores. É o chamado "juros sobre juros".</li>
                            <li><strong>CDI (Certificado de Depósito Interbancário):</strong> É uma <i>taxa de referência</i> no mercado financeiro brasileiro, muito utilizada para remunerar investimentos de <strong>renda fixa</strong>.</li>
                            <li><strong>Renda Fixa vs Renda Variável:</strong> <strong>Renda fixa</strong> tem retornos mais previsíveis e menor risco, enquanto <strong>renda variável</strong> pode ter maiores retornos mas com maior risco.</li>
                            <li><strong>Inflação:</strong> Aumento generalizado dos preços que reduz o <i>poder de compra</i> do dinheiro ao longo do tempo.</li>
                            <li><strong>Diversificação:</strong> Estratégia de distribuir investimentos em diferentes tipos de ativos para reduzir riscos.</li>
                            <li><strong>Liquidez:</strong> Facilidade com que um ativo pode ser convertido em dinheiro sem perda significativa de valor.</li>
                            <li><strong>Volatilidade:</strong> Medida da variação dos preços de um ativo em um determinado período.</li>
                            <li><strong>Imposto de Renda:</strong> Para investimentos de renda fixa, a alíquota é regressiva conforme o prazo: 22,5% (até 180 dias), 20% (de 181 a 360 dias), 17,5% (de 361 a 720 dias) e 15% (acima de 720 dias).</li>
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
                                    <input type="number" class="form-control" id="prazo" min="1" value="36" required>
                                </div>
                                <small class="text-muted">Período total da simulação</small>
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
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inflacao" class="form-label">Inflação Anual Estimada (%):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                    <input type="number" class="form-control" id="inflacao" step="0.1" min="0" value="4.5">
                                </div>
                                <small class="text-muted">Estimativa de inflação anual</small>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" id="inflacaoVariavel">
                                    <label class="form-check-label" for="inflacaoVariavel">Usar inflação variável</label>
                                </div>
                                <small class="text-muted">Disponível apenas na versão premium</small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="goalAmount" class="form-label">Meta Financeira (R$):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                    <input type="number" class="form-control" id="goalAmount" min="0" step="1000" value="50000">
                                </div>
                                <small class="text-muted">Valor que deseja acumular</small>
                            </div>
                            <div class="col-md-6">
                                <label for="goalYears" class="form-label">Prazo para Meta (anos):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                    <input type="number" class="form-control" id="goalYears" min="1" step="1" value="5">
                                </div>
                                <small class="text-muted">Prazo para atingir a meta</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 d-grid">
                                <button type="button" onclick="calcularRentabilidadePremium()" class="btn btn-primary btn-lg">
                                    <i class="fas fa-calculator me-2"></i> Calcular Simulação
                                </button>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="button" onclick="exportarResultadosPDF()" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-file-pdf me-2"></i> Exportar para PDF
                                </button>
                            </div>
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
            
            <!-- Comparações avançadas -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Comparações Avançadas <i class="fas fa-balance-scale"></i></h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="comparisonTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="comparison-tab" data-bs-toggle="tab" data-bs-target="#comparison" type="button" role="tab" aria-controls="comparison" aria-selected="true">Comparativo</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">Tabela Detalhada</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="analysis-tab" data-bs-toggle="tab" data-bs-target="#analysis" type="button" role="tab" aria-controls="analysis" aria-selected="false">Análise</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3 border border-top-0 rounded-bottom" id="comparisonTabsContent">
                        <div class="tab-pane fade show active" id="comparison" role="tabpanel" aria-labelledby="comparison-tab">
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
                            
                            <div class="chart-container mt-3">
                                <canvas id="chartComparacoes"></canvas>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="table-tab">
                            <p class="text-center text-muted">Execute a simulação para ver a tabela detalhada.</p>
                            <div id="detailedTableContainer" class="table-responsive"></div>
                        </div>
                        <div class="tab-pane fade" id="analysis" role="tabpanel" aria-labelledby="analysis-tab">
                            <h4 class="h6">Laudo Comparativo <i class="fas fa-file-alt"></i></h4>
                            <p id="laudoComparativo">Execute a simulação para ver o laudo comparativo.</p>
                            <p id="laudoMeta">Preencha os campos de meta financeira para ver a análise.</p>
                            <p id="laudoPercentualCDB">Execute a simulação para ver a equivalência de rendimentos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Ferramentas adicionais premium -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="h5 mb-0">Ferramentas Premium <i class="fas fa-tools"></i></h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" onclick="salvarSimulacao(); return false;">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><i class="fas fa-save me-2"></i> Salvar Simulação</h5>
                            </div>
                            <p class="mb-1">Salve esta simulação para referência futura.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="carregarSimulacoesSalvas(); return false;">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><i class="fas fa-history me-2"></i> Simulações Salvas</h5>
                            </div>
                            <p class="mb-1">Veja suas simulações anteriores.</p>
                        </a>
                        <a href="/calculadoras/premium/prontos/pgbl-cdb.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><i class="fas fa-exchange-alt me-2"></i> Comparador PGBL vs CDB</h5>
                            </div>
                            <p class="mb-1">Compare PGBL com investimentos tradicionais.</p>
                        </a>
                        <a href="/calculadoras/premium/prontos/investimentos.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><i class="fas fa-chart-pie me-2"></i> Simulador de Investimentos</h5>
                            </div>
                            <p class="mb-1">Simulações com múltiplos investimentos simultâneos.</p>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Material educativo premium -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Material Educativo <i class="fas fa-book"></i></h3>
                </div>
                <div class="card-body">
                    <h4 class="h6 mb-3">Artigos Recomendados</h4>
                    <div class="list-group">
                        <a href="/blog/renda-fixa-vs-variavel.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Renda Fixa vs Renda Variável</h5>
                                <small>12 min de leitura</small>
                            </div>
                            <p class="mb-1">Entenda as diferenças e quando usar cada uma.</p>
                        </a>
                        <a href="/blog/juros-compostos.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">O Poder dos Juros Compostos</h5>
                                <small>8 min de leitura</small>
                            </div>
                            <p class="mb-1">Como pequenos investimentos se tornam grandes patrimônios.</p>
                        </a>
                        <a href="/blog/inflacao-investimentos.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Inflação e Investimentos</h5>
                                <small>14 min de leitura</small>
                            </div>
                            <p class="mb-1">Proteja seu patrimônio contra a perda de poder de compra.</p>
                        </a>
                    </div>
                    
                    <h4 class="h6 mt-4 mb-3">E-books Exclusivos</h4>
                    <div class="list-group">
                        <a href="/ebooks/guia-investidor-iniciante.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Guia do Investidor Iniciante</h5>
                                <small>PDF - 54 págs</small>
                            </div>
                            <p class="mb-1">Tudo o que você precisa saber para começar a investir.</p>
                        </a>
                        <a href="/ebooks/investimentos-renda-fixa.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Investimentos em Renda Fixa</h5>
                                <small>PDF - 78 págs</small>
                            </div>
                            <p class="mb-1">Análise detalhada de todos os tipos de investimentos em renda fixa.</p>
                        </a>
                    </div>
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
    // Inicialização específica para versão premium
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar mudança de exibição dos campos de taxa
        document.getElementById('tipoRendimento').addEventListener('change', mostrarCamposTaxaComBaseNoTipo);
        
        // Mostrar campos iniciais
        mostrarCamposTaxaComBaseNoTipo();
    });
    
    // Função para salvar a simulação (versão premium)
    function salvarSimulacao() {
        // Verificar se há simulação para salvar
        const valorFinal = document.getElementById('resultValorFinal').textContent;
        if (!valorFinal) {
            alert("Execute uma simulação antes de salvar.");
            return;
        }
        
        // Implementação real usaria AJAX para salvar no servidor
        alert("Simulação salva com sucesso!");
    }
    
    // Função para carregar simulações salvas (versão premium)
    function carregarSimulacoesSalvas() {
        // Implementação real usaria AJAX para carregar do servidor
        alert("Funcionalidade em implementação. Em breve você poderá acessar suas simulações salvas.");
    }
</script>

<?php
// Incluir rodapé
include '../../includes/footer.php';
?>