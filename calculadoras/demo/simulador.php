<?php
/**
 * Simulador Educacional (Demo)
 * Versão demonstrativa do simulador de investimentos em renda fixa
 * 
 * Esta versão possui limitações estratégicas:
 * - Período máximo de 12 meses
 * - Sem opção de inflação variável
 * - Interface simplificada sem exportação de resultados
 */
require_once '../../includes/functions.php';

$page_title = "Simulador Educacional (Demo) | Luaraujo";
$page_description = "Simule investimentos em renda fixa com CDI para períodos de até 12 meses.";

// Valor atual do CDI (seria atualizado via API em produção)
$cdi_atual = 13.65;

include '../../includes/header.php';
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold">Simulador Educacional (Demo)</h1>
            <p class="lead">Simule investimentos em renda fixa e veja o impacto da rentabilidade ao longo do tempo.</p>
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill me-2"></i>
                Taxa CDI atual: <strong><?php echo number_format($cdi_atual, 2, ',', '.'); ?>% ao ano</strong>
                <small class="d-block mt-1">Valores atualizados em <?php echo date('d/m/Y'); ?></small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Formulário da calculadora -->
            <form id="calculator-form" class="card shadow-sm p-4 mb-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="initial" class="form-label">Valor Inicial (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="initial" name="initial" min="100" step="100" value="1000" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="months" class="form-label">Período (meses)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="months" name="months" min="1" max="12" value="6" required>
                            <span class="input-group-text">meses</span>
                        </div>
                        <div class="form-text text-muted">Versão demo limitada a 12 meses</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="rate_type" class="form-label">Tipo de Taxa</label>
                        <select class="form-select" id="rate_type" name="rate_type">
                            <option value="cdi" selected>CDI</option>
                            <option value="cdi_percent">% do CDI</option>
                            <option value="fixed">Taxa Fixa</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="rate" class="form-label">Taxa (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="rate" name="rate" min="0.1" step="0.1" value="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text" id="rate_description">100% do CDI (<?php echo number_format($cdi_atual, 2, ',', '.'); ?>% a.a.)</div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Calcular</button>
                </div>
            </form>

            <!-- Resultados -->
            <div id="results" class="card shadow-sm p-4 d-none">
                <h2 class="h4 mb-4">Resultados da Simulação</h2>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100 bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Valor Inicial</h5>
                                <p class="card-text fw-bold fs-4" id="result-initial">R$ 0,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Valor Final</h5>
                                <p class="card-text fw-bold fs-4" id="result-final">R$ 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Rendimento Bruto</th>
                                <th>Rendimento (%)</th>
                                <th>Rendimento Mensal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="result-earnings">R$ 0,00</td>
                                <td id="result-percentage">0%</td>
                                <td id="result-monthly-rate">0% a.m.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i> Esta é uma versão simplificada. Para simulações mais avançadas com:
                    <ul class="mt-2 mb-0">
                        <li>Períodos mais longos (até 30 anos)</li>
                        <li>Ajuste pela inflação</li>
                        <li>Cálculo de impostos</li>
                        <li>Aportes mensais</li>
                        <li>Gráficos detalhados</li>
                    </ul>
                    <div class="mt-3">
                        <a href="<?php echo hotmart_product_link(); ?>" class="btn btn-success btn-sm" target="_blank">
                            Acessar Versão Premium
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informações Premium -->
            <div class="card bg-light shadow-sm p-4">
                <h3 class="h5 mb-3">Versão Premium Inclui:</h3>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Simulações para períodos ilimitados</li>
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Opções de inflação variável</li>
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Exportação de resultados em PDF</li>
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Comparação entre diferentes investimentos</li>
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Gráficos detalhados de projeção</li>
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Cálculo de impostos personalizados</li>
                    <li class="list-group-item bg-transparent"><i class="bi bi-check-circle-fill text-success me-2"></i> Salvar simulações para referência futura</li>
                </ul>
                <div class="d-grid">
                    <a href="<?php echo hotmart_product_link(); ?>" class="btn btn-success btn-lg" target="_blank">
                        Obter Versão Premium
                    </a>
                </div>
            </div>
            
            <!-- Como funciona -->
            <div class="card shadow-sm p-4 mt-4">
                <h3 class="h5 mb-3">Como funciona?</h3>
                <p>O Simulador Educacional permite calcular o rendimento de investimentos em renda fixa com base em:</p>
                <ul class="mb-0">
                    <li>CDI (Certificado de Depósito Interbancário)</li>
                    <li>Taxa fixa personalizada</li>
                    <li>Percentual do CDI</li>
                </ul>
                <hr>
                <p class="mb-0"><small>Valores apenas para fins educacionais. Consulte um profissional de investimentos para decisões financeiras.</small></p>
            </div>
        </div>
    </div>
</div>

<script>
// Lógica JavaScript aprimorada para a calculadora demo
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('calculator-form');
    const resultsDiv = document.getElementById('results');
    const rateType = document.getElementById('rate_type');
    const rateInput = document.getElementById('rate');
    const rateDescription = document.getElementById('rate_description');
    const cdiRate = <?php echo $cdi_atual; ?>;
    
    // Atualizar descrição da taxa ao mudar o tipo ou valor
    function updateRateDescription() {
        const selectedType = rateType.value;
        const rateValue = parseFloat(rateInput.value);
        
        let description = '';
        switch(selectedType) {
            case 'cdi':
                description = '100% do CDI (' + cdiRate.toFixed(2).replace('.', ',') + '% a.a.)';
                rateInput.value = 100;
                rateInput.disabled = true;
                break;
            case 'cdi_percent':
                description = rateValue + '% do CDI (' + ((rateValue/100) * cdiRate).toFixed(2).replace('.', ',') + '% a.a.)';
                rateInput.disabled = false;
                break;
            case 'fixed':
                description = rateValue + '% ao ano';
                rateInput.disabled = false;
                break;
        }
        
        rateDescription.textContent = description;
    }
    
    rateType.addEventListener('change', updateRateDescription);
    rateInput.addEventListener('input', updateRateDescription);
    
    // Inicializar descrição
    updateRateDescription();
    
    // Processar formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Obter valores do formulário
        const initialValue = parseFloat(document.getElementById('initial').value);
        const months = parseInt(document.getElementById('months').value);
        const selectedRateType = rateType.value;
        const rateValue = parseFloat(rateInput.value);
        
        // Calcular taxa anual
        let annualRate = 0;
        switch(selectedRateType) {
            case 'cdi':
                annualRate = cdiRate;
                break;
            case 'cdi_percent':
                annualRate = cdiRate * (rateValue / 100);
                break;
            case 'fixed':
                annualRate = rateValue;
                break;
        }
        
        // Converter taxa anual para mensal
        const monthlyRate = Math.pow(1 + (annualRate / 100), 1/12) - 1;
        
        // Calcular montante final usando juros compostos
        const finalValue = initialValue * Math.pow(1 + monthlyRate, months);
        const earnings = finalValue - initialValue;
        const earningsPercentage = (earnings / initialValue) * 100;
        
        // Exibir resultados
        document.getElementById('result-initial').textContent = formatCurrency(initialValue);
        document.getElementById('result-final').textContent = formatCurrency(finalValue);
        document.getElementById('result-earnings').textContent = formatCurrency(earnings);
        document.getElementById('result-percentage').textContent = earningsPercentage.toFixed(2).replace('.', ',') + '%';
        document.getElementById('result-monthly-rate').textContent = (monthlyRate * 100).toFixed(2).replace('.', ',') + '% a.m.';
        
        // Mostrar div de resultados
        resultsDiv.classList.remove('d-none');
        
        // Scroll para resultados
        resultsDiv.scrollIntoView({ behavior: 'smooth' });
    });
    
    // Função auxiliar para formatação de moeda
    function formatCurrency(value) {
        return 'R$ ' + value.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
});
</script>

<?php include '../../includes/footer.php'; ?>
