<?php
/**
 * Simulador Educacional (Demo)
 * Versão demonstrativa do simulador de investimentos em renda fixa
 */
require_once '../../includes/functions.php';

$page_title = "Simulador Educacional (Demo) | Luaraujo";
$page_description = "Simule investimentos em renda fixa com CDI para períodos de até 12 meses.";

include '../../includes/header.php';
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold">Simulador Educacional (Demo)</h1>
            <p class="lead">Simule investimentos em renda fixa e veja o impacto da rentabilidade ao longo do tempo.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Formulário da calculadora -->
            <form id="calculator-form" class="card shadow-sm p-4 mb-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="initial" class="form-label">Valor Inicial (R$)</label>
                        <input type="number" class="form-control" id="initial" name="initial" min="100" step="100" value="1000" required>
                    </div>
                    <div class="col-md-6">
                        <label for="months" class="form-label">Período (meses)</label>
                        <input type="number" class="form-control" id="months" name="months" min="1" max="12" value="6" required>
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
                        <input type="number" class="form-control" id="rate" name="rate" min="0.1" step="0.1" value="100" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Calcular</button>
                </div>
            </form>

            <!-- Resultados -->
            <div id="results" class="card shadow-sm p-4 d-none">
                <h2 class="h4 mb-4">Resultados da Simulação</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Valor Inicial</th>
                                <th>Valor Final</th>
                                <th>Rendimento</th>
                                <th>Rendimento (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="result-initial">R$ 0,00</td>
                                <td id="result-final">R$ 0,00</td>
                                <td id="result-earnings">R$ 0,00</td>
                                <td id="result-percentage">0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i> Esta é uma versão simplificada. Para simulações mais avançadas, acesse a <a href="<?php echo hotmart_product_link(); ?>" target="_blank">versão premium</a>.
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informações Premium -->
            <div class="card bg-light shadow-sm p-4">
                <h3 class="h5 mb-3">Versão Premium Inclui:</h3>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item bg-transparent">Simulações para períodos ilimitados</li>
                    <li class="list-group-item bg-transparent">Opções de inflação variável</li>
                    <li class="list-group-item bg-transparent">Exportação de resultados em PDF</li>
                    <li class="list-group-item bg-transparent">Comparação entre diferentes investimentos</li>
                    <li class="list-group-item bg-transparent">Gráficos detalhados de projeção</li>
                </ul>
                <div class="d-grid">
                    <a href="<?php echo hotmart_product_link(); ?>" class="btn btn-success" target="_blank">
                        Obter Versão Premium
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Lógica JavaScript simplificada para a calculadora demo
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('calculator-form');
    const resultsDiv = document.getElementById('results');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Obter valores do formulário
        const initialValue = parseFloat(document.getElementById('initial').value);
        const months = parseInt(document.getElementById('months').value);
        const rateType = document.getElementById('rate_type').value;
        const rateValue = parseFloat(document.getElementById('rate').value);
        
        // Calcular com base no tipo de taxa
        let annualRate = 0;
        switch(rateType) {
            case 'cdi':
                annualRate = 13.65; // Valor fixo do CDI para demo (normalmente seria dinâmico)
                break;
            case 'cdi_percent':
                annualRate = 13.65 * (rateValue / 100);
                break;
            case 'fixed':
                annualRate = rateValue;
                break;
        }
        
        // Converter taxa anual para mensal
        const monthlyRate = Math.pow(1 + (annualRate / 100), 1/12) - 1;
        
        // Calcular montante final
        const finalValue = initialValue * Math.pow(1 + monthlyRate, months);
        const earnings = finalValue - initialValue;
        const earningsPercentage = (earnings / initialValue) * 100;
        
        // Exibir resultados
        document.getElementById('result-initial').textContent = formatCurrency(initialValue);
        document.getElementById('result-final').textContent = formatCurrency(finalValue);
        document.getElementById('result-earnings').textContent = formatCurrency(earnings);
        document.getElementById('result-percentage').textContent = earningsPercentage.toFixed(2) + '%';
        
        // Mostrar div de resultados
        resultsDiv.classList.remove('d-none');
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
