/**
 * Helpers para criação e manipulação de gráficos
 * Funções auxiliares para padronizar a aparência e comportamento dos gráficos
 * 
 * @author Luaraujo Premium 2025
 * @version 1.0
 */

const ChartHelpers = {
    /**
     * Formata um valor como moeda brasileira
     * @param {number} valor - O valor a ser formatado
     * @returns {string} Valor formatado como moeda (R$ 0,00)
     */
    formatarMoeda: function(valor) {
        return 'R$ ' + valor.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    },
    
    /**
     * Prepara o container de um gráfico para exibição
     * @param {string} chartId - ID do elemento canvas do gráfico
     */
    prepareChartContainer: function(chartId) {
        const canvas = document.getElementById(chartId);
        if (!canvas) return;
        
        // Adicionar classe de loading
        canvas.classList.add('loading');
        
        // Adicionar elemento de loading
        const loadingExists = canvas.parentNode.querySelector('.chart-loading');
        if (!loadingExists) {
            const loading = document.createElement('div');
            loading.className = 'chart-loading';
            loading.innerHTML = '<div class="spinner"></div><p>Carregando...</p>';
            canvas.parentNode.appendChild(loading);
        }
    },
    
    /**
     * Remove o indicador de loading de um gráfico
     * @param {string} chartId - ID do elemento canvas do gráfico
     */
    removeLoading: function(chartId) {
        const canvas = document.getElementById(chartId);
        if (!canvas) return;
        
        // Remover classe de loading
        canvas.classList.remove('loading');
        
        // Remover elemento de loading
        const loading = canvas.parentNode.querySelector('.chart-loading');
        if (loading) {
            loading.remove();
        }
    },
    
    /**
     * Configurações básicas para um tema claro
     * @returns {object} Configurações para Chart.js
     */
    lightThemeConfig: function() {
        return {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            family: "'Roboto', sans-serif",
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    padding: 15,
                    cornerRadius: 8,
                    titleFont: {
                        family: "'Roboto', sans-serif",
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: "'Roboto', sans-serif",
                        size: 12
                    },
                    boxWidth: 8,
                    boxHeight: 8,
                    usePointStyle: true
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: "'Roboto', sans-serif",
                            size: 11
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: "'Roboto', sans-serif",
                            size: 11
                        }
                    }
                }
            }
        };
    },
    
    /**
     * Configurações básicas para um tema escuro
     * @returns {object} Configurações para Chart.js
     */
    darkThemeConfig: function() {
        return {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        color: '#e0e0e0',
                        font: {
                            family: "'Roboto', sans-serif",
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 30, 30, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#ccc',
                    borderColor: '#555',
                    borderWidth: 1,
                    padding: 15,
                    cornerRadius: 8,
                    titleFont: {
                        family: "'Roboto', sans-serif",
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: "'Roboto', sans-serif",
                        size: 12
                    },
                    boxWidth: 8,
                    boxHeight: 8,
                    usePointStyle: true
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#ccc',
                        font: {
                            family: "'Roboto', sans-serif",
                            size: 11
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#ccc',
                        font: {
                            family: "'Roboto', sans-serif",
                            size: 11
                        }
                    }
                }
            }
        };
    },
    
    /**
     * Gera uma cor aleatória
     * @returns {string} Cor em formato hexadecimal
     */
    randomColor: function() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    },
    
    /**
     * Gera uma paleta de cores com base em uma cor base
     * @param {string} baseColor - Cor base em formato hexadecimal
     * @param {number} count - Número de cores a serem geradas
     * @returns {array} Array de cores em formato hexadecimal
     */
    generateColorPalette: function(baseColor, count) {
        const palette = [];
        
        // Converter cor base para RGB
        const r = parseInt(baseColor.substring(1, 3), 16);
        const g = parseInt(baseColor.substring(3, 5), 16);
        const b = parseInt(baseColor.substring(5, 7), 16);
        
        for (let i = 0; i < count; i++) {
            // Calcular variação
            const factor = 0.8 + (i * 0.4 / count);
            
            // Aplicar variação
            const newR = Math.min(255, Math.floor(r * factor));
            const newG = Math.min(255, Math.floor(g * factor));
            const newB = Math.min(255, Math.floor(b * factor));
            
            // Converter de volta para hexadecimal
            const newColor = '#' + 
                newR.toString(16).padStart(2, '0') + 
                newG.toString(16).padStart(2, '0') + 
                newB.toString(16).padStart(2, '0');
            
            palette.push(newColor);
        }
        
        return palette;
    },
    
    /**
     * Gera um PDF com os resultados da simulação
     * @param {string} chartId - ID do elemento canvas do gráfico
     * @param {object} data - Dados da simulação
     */
    exportChartToPDF: function(chartId, data) {
        alert('Esta funcionalidade está disponível apenas na versão premium.');
    }
};