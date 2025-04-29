/**
 * Simulador Educacional - Funções compartilhadas
 * Este arquivo contém funções para as versões demo e premium do Simulador Educacional
 * 
 * @author Luaraujo Premium 2025
 * @version 1.0
 */

// Funções de formatação e utilidades
function formatarMoeda(valor) {
    return 'R$ ' + valor.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function converterTaxaAnualParaMensal(taxaAnual) {
    return Math.pow(1 + (taxaAnual / 100), 1/12) - 1;
}

function converterTaxaMensalParaAnual(taxaMensal) {
    return (Math.pow(1 + taxaMensal, 12) - 1) * 100;
}

// Função para calcular a alíquota de IR com base no prazo
function calcularAliquotaIR(prazoMeses) {
    if (prazoMeses <= 6) {
        return 0.225; // 22,5%
    } else if (prazoMeses <= 12) {
        return 0.20; // 20%
    } else if (prazoMeses <= 24) {
        return 0.175; // 17,5%
    } else {
        return 0.15; // 15%
    }
}

// Versão demo - Com limitações
function calcularRentabilidadeDemo() {
    // Preparar containers dos gráficos se disponíveis
    if (window.ChartHelpers) {
        ChartHelpers.prepareChartContainer('chartSimulacao');
        ChartHelpers.prepareChartContainer('chartComparacoes');
    }
    
    // Obter valores do formulário
    const valorInicial = parseFloat(document.getElementById('valorInicial').value) || 0;
    const aporteMensal = parseFloat(document.getElementById('aporteMensal').value) || 0;
    let prazo = parseInt(document.getElementById('prazo').value) || 0;
    const tipoRendimento = document.getElementById('tipoRendimento').value;
    const taxaFixa = parseFloat(document.getElementById('taxaFixa').value) / 100 || 0;
    const taxaCDI = parseFloat(document.getElementById('taxaCDI').value) / 100 || 0.1315;
    const percentualCDIComImposto = parseFloat(document.getElementById('percentualCDIComImposto').value) / 100 || 1;
    const percentualCDISemImposto = parseFloat(document.getElementById('percentualCDISemImposto').value) / 100 || 0.93;
    const inflacao = parseFloat(document.getElementById('inflacao').value) / 100 || 0.045;
    
    // Limitação da versão demo (máximo 12 meses)
    if (prazo > 12) {
        alert("A versão demo está limitada a 12 meses. Para períodos maiores, adquira a versão premium.");
        document.getElementById('prazo').value = 12;
        prazo = 12;
    }
    
    // Validar dados
    if (valorInicial < 0 || aporteMensal < 0 || prazo <= 0) {
        alert("Preencha todos os campos obrigatórios com valores válidos para calcular a simulação.");
        if (window.ChartHelpers) {
            ChartHelpers.removeLoading('chartSimulacao');
            ChartHelpers.removeLoading('chartComparacoes');
        }
        return;
    }
    
    // Calcular taxa mensal
    let taxaMensal;
    if (tipoRendimento === 'fixa') {
        if (isNaN(taxaFixa) || taxaFixa <= 0) {
            alert("Preencha a taxa fixa mensal com um valor válido.");
            if (window.ChartHelpers) {
                ChartHelpers.removeLoading('chartSimulacao');
                ChartHelpers.removeLoading('chartComparacoes');
            }
            return;
        }
        taxaMensal = taxaFixa;
    } else {
        if (isNaN(taxaCDI) || isNaN(percentualCDIComImposto) || isNaN(percentualCDISemImposto)) {
            alert("Preencha todos os campos relacionados ao CDI.");
            if (window.ChartHelpers) {
                ChartHelpers.removeLoading('chartSimulacao');
                ChartHelpers.removeLoading('chartComparacoes');
            }
            return;
        }
        taxaMensal = (taxaCDI / 12) * percentualCDIComImposto;
    }
    
    // Calcular evolução do investimento
    let valorFinal = valorInicial;
    let evolucaoMensal = [valorInicial];
    let aportesMensais = [valorInicial]; // O primeiro é o valor inicial
    let totalAportado = valorInicial;
    
    for (let i = 0; i < prazo; i++) {
        valorFinal = valorFinal * (1 + taxaMensal) + aporteMensal;
        evolucaoMensal.push(valorFinal);
        totalAportado += aporteMensal;
        aportesMensais.push(totalAportado);
    }
    
    const ganhoTotal = valorFinal - valorInicial - (aporteMensal * prazo);
    const inflacaoAcumulada = Math.pow(1 + inflacao, prazo / 12) - 1;
    const valorFinalAjustado = valorFinal / (1 + inflacaoAcumulada);
    
    // Atualizar resultados
    document.getElementById('resultValorInicial').textContent = valorInicial.toFixed(2);
    document.getElementById('resultAporteMensal').textContent = aporteMensal.toFixed(2);
    document.getElementById('resultPrazo').textContent = prazo;
    document.getElementById('resultTaxaRendimento').textContent = (taxaMensal * 100).toFixed(2);
    document.getElementById('resultValorFinal').textContent = valorFinal.toFixed(2);
    document.getElementById('resultGanhoTotal').textContent = ganhoTotal.toFixed(2);
    document.getElementById('resultInflacaoAcumulada').textContent = (inflacaoAcumulada * 100).toFixed(2);
    document.getElementById('resultValorFinalAjustado').textContent = valorFinalAjustado.toFixed(2);
    
    // Mostrar container de resultados
    document.getElementById('results').style.display = 'block';
    
    // Gráfico de Simulação - usando Chart.js
    const ctxSimulacao = document.getElementById('chartSimulacao').getContext('2d');
    
    // Destruir gráfico anterior se existir
    if (window.chartSimulacao) {
        window.chartSimulacao.destroy();
    }
    
    // Criar labels para o eixo X (meses)
    const labels = Array.from({ length: prazo + 1 }, (_, i) => i === 0 ? 'Início' : `Mês ${i}`);
    
    // Configuração do gráfico
    const configSimulacao = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Valor Acumulado',
                    data: evolucaoMensal,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Total Investido',
                    data: aportesMensais,
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderWidth: 2,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formatarMoeda(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return formatarMoeda(value);
                        }
                    }
                }
            }
        }
    };
    
    // Criar gráfico
    window.chartSimulacao = new Chart(ctxSimulacao, configSimulacao);
    
    // Limitação de comparações na versão demo
    document.getElementById('comparacaoPoupancaValorFinal').textContent = "Versão Premium";
    document.getElementById('comparacaoPoupancaGanhoTotal').textContent = "Versão Premium";
    document.getElementById('comparacaoCDBValorFinal').textContent = "Versão Premium";
    document.getElementById('comparacaoCDBGanhoTotal').textContent = "Versão Premium";
    document.getElementById('comparacaoLCILCAValorFinal').textContent = "Versão Premium";
    document.getElementById('comparacaoLCILCAGanhoTotal').textContent = "Versão Premium";
    
    document.getElementById('laudoComparativo').innerHTML = "<strong>Comparações detalhadas disponíveis na versão premium.</strong>";
    document.getElementById('laudoMeta').innerHTML = "<strong>Análise de metas financeiras disponível na versão premium.</strong>";
    document.getElementById('laudoPercentualCDB').innerHTML = "<strong>Equivalência entre investimentos disponível na versão premium.</strong>";
    
    // Remover indicadores de loading
    if (window.ChartHelpers) {
        ChartHelpers.removeLoading('chartSimulacao');
        ChartHelpers.removeLoading('chartComparacoes');
    }
    
    // Scroll para ver os resultados
    setTimeout(() => {
        document.getElementById('results').scrollIntoView({behavior: 'smooth'});
    }, 500);
}

// Versão premium - Completa
function calcularRentabilidadePremium() {
    // Preparar containers dos gráficos
    if (window.ChartHelpers) {
        ChartHelpers.prepareChartContainer('chartSimulacao');
        ChartHelpers.prepareChartContainer('chartComparacoes');
    }
    
    // Obter valores do formulário
    const valorInicial = parseFloat(document.getElementById('valorInicial').value) || 0;
    const aporteMensal = parseFloat(document.getElementById('aporteMensal').value) || 0;
    const prazo = parseInt(document.getElementById('prazo').value) || 0;
    const tipoRendimento = document.getElementById('tipoRendimento').value;
    const taxaFixa = parseFloat(document.getElementById('taxaFixa').value) / 100 || 0;
    const taxaCDI = parseFloat(document.getElementById('taxaCDI').value) / 100 || 0.1315;
    const percentualCDIComImposto = parseFloat(document.getElementById('percentualCDIComImposto').value) / 100 || 1;
    const percentualCDISemImposto = parseFloat(document.getElementById('percentualCDISemImposto').value) / 100 || 0.93;
    const inflacao = parseFloat(document.getElementById('inflacao').value) / 100 || 0.045;
    
    // Validar dados
    if (valorInicial < 0 || aporteMensal < 0 || prazo <= 0) {
        alert("Preencha todos os campos obrigatórios com valores válidos para calcular a simulação.");
        if (window.ChartHelpers) {
            ChartHelpers.removeLoading('chartSimulacao');
            ChartHelpers.removeLoading('chartComparacoes');
        }
        return;
    }
    
    // Cálculo do percentual do CDI do CDB necessário para bater o LCI/LCA considerando o prazo
    const aliquotaIREquivalencia = calcularAliquotaIR(prazo);
    const percentualCDIComIRNecessario = percentualCDISemImposto / (1 - aliquotaIREquivalencia);
    
    // Calcular taxa mensal
    let taxaMensal;
    if (tipoRendimento === 'fixa') {
        if (isNaN(taxaFixa) || taxaFixa <= 0) {
            alert("Preencha a taxa fixa mensal com um valor válido.");
            if (window.ChartHelpers) {
                ChartHelpers.removeLoading('chartSimulacao');
                ChartHelpers.removeLoading('chartComparacoes');
            }
            return;
        }
        taxaMensal = taxaFixa;
    } else {
        if (isNaN(taxaCDI) || isNaN(percentualCDIComImposto) || isNaN(percentualCDISemImposto)) {
            alert("Preencha todos os campos relacionados ao CDI.");
            if (window.ChartHelpers) {
                ChartHelpers.removeLoading('chartSimulacao');
                ChartHelpers.removeLoading('chartComparacoes');
            }
            return;
        }
        taxaMensal = (taxaCDI / 12) * percentualCDIComImposto;
    }
    
    // Calcular evolução do investimento
    let valorFinal = valorInicial;
    let evolucaoMensal = [valorInicial];
    let aportesMensais = [valorInicial]; // O primeiro é o valor inicial
    let totalAportado = valorInicial;
    
    for (let i = 0; i < prazo; i++) {
        valorFinal = valorFinal * (1 + taxaMensal) + aporteMensal;
        evolucaoMensal.push(valorFinal);
        totalAportado += aporteMensal;
        aportesMensais.push(totalAportado);
    }
    
    const ganhoTotal = valorFinal - valorInicial - (aporteMensal * prazo);
    const inflacaoAcumulada = Math.pow(1 + inflacao, prazo / 12) - 1;
    const valorFinalAjustado = valorFinal / (1 + inflacaoAcumulada);
    
    // Atualizar resultados
    document.getElementById('resultValorInicial').textContent = valorInicial.toFixed(2);
    document.getElementById('resultAporteMensal').textContent = aporteMensal.toFixed(2);
    document.getElementById('resultPrazo').textContent = prazo;
    document.getElementById('resultTaxaRendimento').textContent = (taxaMensal * 100).toFixed(2);
    document.getElementById('resultValorFinal').textContent = valorFinal.toFixed(2);
    document.getElementById('resultGanhoTotal').textContent = ganhoTotal.toFixed(2);
    document.getElementById('resultInflacaoAcumulada').textContent = (inflacaoAcumulada * 100).toFixed(2);
    document.getElementById('resultValorFinalAjustado').textContent = valorFinalAjustado.toFixed(2);
    
    // Mostrar container de resultados
    document.getElementById('results').style.display = 'block';
    
    // Comparações
    const taxaPoupanca = 0.005; // 0.5% ao mês
    const taxaCDB = (taxaCDI / 12) * percentualCDIComImposto;
    const taxaLCILCA = (taxaCDI / 12) * percentualCDISemImposto; // LCI/LCA sem IR
    
    let valorFinalPoupanca = valorInicial;
    let valorFinalCDB = valorInicial;
    let valorFinalLCILCA = valorInicial;
    
    for (let i = 0; i < prazo; i++) {
        valorFinalPoupanca = valorFinalPoupanca * (1 + taxaPoupanca) + aporteMensal;
        valorFinalCDB = valorFinalCDB * (1 + taxaCDB) + aporteMensal;
        valorFinalLCILCA = valorFinalLCILCA * (1 + taxaLCILCA) + aporteMensal;
    }
    
    // Aplicar imposto de renda regressivo no CDB
    const aliquotaIR = calcularAliquotaIR(prazo);
    
    const ganhoBrutoCDB = valorFinalCDB - valorInicial - (aporteMensal * prazo);
    const impostoCDB = ganhoBrutoCDB * aliquotaIR;
    const ganhoLiquidoCDB = ganhoBrutoCDB - impostoCDB;
    const valorFinalLiquidoCDB = valorFinalCDB - impostoCDB;
    
    document.getElementById('comparacaoPoupancaValorFinal').textContent = formatarMoeda(valorFinalPoupanca);
    document.getElementById('comparacaoPoupancaGanhoTotal').textContent = formatarMoeda(valorFinalPoupanca - valorInicial - (aporteMensal * prazo));
    document.getElementById('comparacaoCDBValorFinal').textContent = formatarMoeda(valorFinalLiquidoCDB);
    document.getElementById('comparacaoCDBGanhoTotal').textContent = formatarMoeda(ganhoLiquidoCDB);
    document.getElementById('comparacaoLCILCAValorFinal').textContent = formatarMoeda(valorFinalLCILCA);
    document.getElementById('comparacaoLCILCAGanhoTotal').textContent = formatarMoeda(valorFinalLCILCA - valorInicial - (aporteMensal * prazo));
    
    // Gráfico de Simulação - usando Chart.js
    const ctxSimulacao = document.getElementById('chartSimulacao').getContext('2d');
    
    // Destruir gráfico anterior se existir
    if (window.chartSimulacao) {
        window.chartSimulacao.destroy();
    }
    
    // Criar labels para o eixo X (meses)
    const labels = Array.from({ length: prazo + 1 }, (_, i) => i === 0 ? 'Início' : `Mês ${i}`);
    
    // Configuração do gráfico
    const configSimulacao = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Valor Acumulado',
                    data: evolucaoMensal,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Total Investido',
                    data: aportesMensais,
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderWidth: 2,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formatarMoeda(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return formatarMoeda(value);
                        }
                    }
                }
            }
        }
    };
    
    // Criar gráfico
    window.chartSimulacao = new Chart(ctxSimulacao, configSimulacao);
    
    // Gráfico de Comparações
    const ctxComparacoes = document.getElementById('chartComparacoes').getContext('2d');
    
    // Destruir gráfico anterior se existir
    if (window.chartComparacoes) {
        window.chartComparacoes.destroy();
    }
    
    // Configuração do gráfico
    const configComparacoes = {
        type: 'bar',
        data: {
            labels: ['Poupança', 'CDB', 'LCI/LCA'],
            datasets: [{
                label: 'Valor Final',
                data: [valorFinalPoupanca, valorFinalLiquidoCDB, valorFinalLCILCA],
                backgroundColor: ['#2ecc71', '#3498db', '#e74c3c']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formatarMoeda(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return formatarMoeda(value);
                        }
                    }
                }
            }
        }
    };
    
    // Criar gráfico
    window.chartComparacoes = new Chart(ctxComparacoes, configComparacoes);
    
    // Remover indicadores de loading
    if (window.ChartHelpers) {
        ChartHelpers.removeLoading('chartSimulacao');
        ChartHelpers.removeLoading('chartComparacoes');
    }
    
    // Laudo Comparativo
    const laudoComparativo = document.getElementById('laudoComparativo');
    if (valorFinalPoupanca > valorFinalLiquidoCDB && valorFinalPoupanca > valorFinalLCILCA) {
        laudoComparativo.innerHTML = "<strong class='text-success'>A poupança foi a opção mais vantajosa neste cenário.</strong>";
    } else if (valorFinalLiquidoCDB > valorFinalPoupanca && valorFinalLiquidoCDB > valorFinalLCILCA) {
        laudoComparativo.innerHTML = "<strong class='text-primary'>O CDB foi a opção mais vantajosa neste cenário.</strong>";
    } else {
        laudoComparativo.innerHTML = "<strong class='text-danger'>O LCI/LCA foi a opção mais vantajosa neste cenário.</strong>";
    }
    
    // Cálculo do valor necessário para atingir a meta
    const goalAmount = parseFloat(document.getElementById('goalAmount').value);
    const goalYears = parseFloat(document.getElementById('goalYears').value);
    
    if (!isNaN(goalAmount) && !isNaN(goalYears) && goalAmount > 0 && goalYears > 0) {
        const goalMonths = goalYears * 12;
        const taxaMensalMeta = (taxaCDI / 12) * percentualCDISemImposto; // Usando LCI/LCA para cálculo da meta
        const valorNecessario = (goalAmount * taxaMensalMeta) / (Math.pow(1 + taxaMensalMeta, goalMonths) - 1);
        const valorNecessarioAjustado = valorNecessario * Math.pow(1 + inflacao, goalYears);
        document.getElementById('laudoMeta').innerHTML = `<strong>Análise de Meta:</strong> Para atingir a meta de ${formatarMoeda(goalAmount)} em ${goalYears} anos, considerando a rentabilidade do LCI/LCA e a inflação, você precisaria investir aproximadamente ${formatarMoeda(valorNecessarioAjustado)} mensalmente.`;
    } else {
        document.getElementById('laudoMeta').textContent = "Preencha os campos de meta financeira e prazo para calcular o valor necessário.";
    }
    
    // Exibir o percentual do CDI do CDB necessário para bater o LCI/LCA
    document.getElementById('laudoPercentualCDB').innerHTML = `<strong>Equivalência CDB x LCI/LCA:</strong> Para o CDB ter o mesmo rendimento líquido do LCI/LCA, ele precisa render <span class="text-primary">${(percentualCDIComIRNecessario * 100).toFixed(2)}%</span> do CDI.`;
    
    // Scroll para ver os resultados
    setTimeout(() => {
        document.getElementById('results').scrollIntoView({behavior: 'smooth'});
    }, 500);
}

// Funções auxiliares para controle da UI
function mostrarCamposTaxaComBaseNoTipo() {
    const tipoRendimento = document.getElementById('tipoRendimento').value;
    if (tipoRendimento === 'fixa') {
        document.getElementById('taxaFixaGroup').style.display = 'block';
        document.getElementById('cdiGroup').style.display = 'none';
    } else {
        document.getElementById('taxaFixaGroup').style.display = 'none';
        document.getElementById('cdiGroup').style.display = 'block';
    }
}

// Exportação para PDF (Apenas versão premium)
function exportarResultadosPDF() {
    alert("Gerando PDF com os resultados da simulação...");
    // Implementação completa na versão premium
}