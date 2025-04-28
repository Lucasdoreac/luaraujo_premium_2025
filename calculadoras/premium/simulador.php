<?php
/**
 * Simulador Educacional (Premium)
 * Versão completa do simulador de investimentos em renda fixa
 */
require_once '../../includes/functions.php';
require_premium_access('/acesso-premium'); // Redireciona se não tiver acesso premium

$page_title = "Simulador Educacional Premium | Luaraujo";
$page_description = "Versão completa do simulador de investimentos em renda fixa com funcionalidades avançadas.";

include '../../includes/header.php';
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold">Simulador Educacional Premium</h1>
            <p class="lead">Versão completa do simulador com todas as funcionalidades e sem limitações de período.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <!-- Formulário da calculadora premium -->
            <form id="calculator-form" class="card shadow-sm p-4 mb-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="initial" class="form-label">Valor Inicial (R$)</label>
                        <input type="number" class="form-control" id="initial" name="initial" min="100" step="100" value="10000" required>
                    </div>
                    <div class="col-md-6">
                        <label for="months" class="form-label">Período (meses)</label>
                        <input type="number" class="form-control" id="months" name="months" min="1" max="360" value="60" required>
                        <div class="form-text text-muted">Sem limitação de período</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="rate_type" class="form-label">Tipo de Taxa</label>
                        <select class="form-select" id="rate_type" name="rate_type">
                            <option value="cdi" selected>CDI</option>
                            <option value="cdi_percent">% do CDI</option>
                            <option value="fixed">Taxa Fixa</option>
                            <option value="ipca_plus">IPCA+</option>
                            <option value="custom">Personalizada</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="rate" class="form-label">Taxa (%)</label>
                        <input type="number" class="form-control" id="rate" name="rate" min="0.1" step="0.1" value="100" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tax_type" class="form-label">Tipo de Tributação</label>
                        <select class="form-select" id="tax_type" name="tax_type">
                            <option value="none">Isento</option>
                            <option value="fixed" selected>Tabela Regressiva IR</option>
                            <option value="custom">Personalizada</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inflation" class="form-label">Inflação Anual (%)</label>
                        <input type="number" class="form-control" id="inflation" name="inflation" min="0" step="0.1" value="4.5">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="monthly_contribution_toggle" name="monthly_contribution_toggle">
                            <label class="form-check-label" for="monthly_contribution_toggle">Adicionar aporte mensal</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group monthly-contribution-group d-none">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="monthly_contribution" name="monthly_contribution" min="0" step="50" value="500">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Calcular</button>
                    <button type="button" id="save-simulation" class="btn btn-outline-secondary">Salvar Simulação</button>
                </div>
            </form>

            <!-- Resultados premium -->
            <div id="results" class="card shadow-sm p-4 d-none">
                <h2 class="h4 mb-4">Resultados Detalhados</h2>
                
                <!-- Abas para diferentes visualizações -->
                <ul class="nav nav-tabs mb-4" id="resultTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab" aria-controls="summary" aria-selected="true">Resumo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly" aria-selected="false">Mensal</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="chart-tab" data-bs-toggle="tab" data-bs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="false">Gráfico</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="inflation-tab" data-bs-toggle="tab" data-bs-target="#inflation" type="button" role="tab" aria-controls="inflation" aria-selected="false">Inflação Ajustada</button>
                    </li>
                </ul>
                
                <!-- Conteúdo das abas -->
                <div class="tab-content" id="resultTabsContent">
                    <!-- Aba de Resumo -->
                    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100 bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Investimento</h5>
                                        <p class="card-text fw-bold fs-4" id="result-summary-initial">R$ 0,00</p>
                                        <p class="card-text text-muted">Valor investido inicialmente</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Valor Final</h5>
                                        <p class="card-text fw-bold fs-4" id="result-summary-final">R$ 0,00</p>
                                        <p class="card-text text-muted">Montante após o período</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive mt-4">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Rendimento Total</th>
                                        <th>Rendimento (%)</th>
                                        <th>Imposto</th>
                                        <th>Rendimento Líquido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="result-summary-earnings">R$ 0,00</td>
                                        <td id="result-summary-percentage">0%</td>
                                        <td id="result-summary-tax">R$ 0,00</td>
                                        <td id="result-summary-net">R$ 0,00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Outras abas com placeholders -->
                    <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="monthly-table">
                                <thead>
                                    <tr>
                                        <th>Mês</th>
                                        <th>Saldo</th>
                                        <th>Rendimento</th>
                                        <th>Aporte</th>
                                    </tr>
                                </thead>
                                <tbody id="monthly-table-body">
                                    <!-- Dados serão preenchidos via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                        <canvas id="results-chart" height="300"></canvas>
                    </div>
                    
                    <div class="tab-pane fade" id="inflation" role="tabpanel" aria-labelledby="inflation-tab">
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle"></i> Valores ajustados pela inflação mostram o poder de compra real.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Valor Final Nominal</th>
                                        <th>Valor Final Real (ajustado)</th>
                                        <th>Perda Inflacionária</th>
                                        <th>Ganho Real (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="result-inflation-nominal">R$ 0,00</td>
                                        <td id="result-inflation-real">R$ 0,00</td>
                                        <td id="result-inflation-loss">R$ 0,00</td>
                                        <td id="result-inflation-gain">0%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="export-pdf" class="btn btn-success">
                        <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <!-- Dicas e informações -->
            <div class="card shadow-sm p-3 mb-4">
                <h3 class="h5 mb-3">Dicas de Uso</h3>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Compare diferentes taxas de juros</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Analise o impacto da inflação</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Considere aportes mensais regulares</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Salve suas simulações para referência</li>
                </ul>
            </div>
            
            <!-- Simulações salvas -->
            <div class="card shadow-sm p-3">
                <h3 class="h5 mb-3">Simulações Salvas</h3>
                <div id="saved-simulations">
                    <p class="text-muted">Nenhuma simulação salva ainda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Placeholder para lógica JavaScript premium - seria implementado com funcionalidades completas
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para aporte mensal
    const monthlyToggle = document.getElementById('monthly_contribution_toggle');
    const monthlyGroup = document.querySelector('.monthly-contribution-group');
    
    monthlyToggle.addEventListener('change', function() {
        if (this.checked) {
            monthlyGroup.classList.remove('d-none');
        } else {
            monthlyGroup.classList.add('d-none');
        }
    });

    // Aqui seria implementada a lógica completa da calculadora premium
    // Por ora, apenas um placeholder para demonstração da estrutura
});
</script>

<?php include '../../includes/footer.php'; ?>
