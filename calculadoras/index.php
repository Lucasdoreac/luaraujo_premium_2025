<?php
/**
 * Página de índice das calculadoras
 * Lista todas as calculadoras disponíveis com links para versões demo e premium
 */
require_once '../includes/functions.php';

$page_title = "Calculadoras Financeiras | Luaraujo";
$page_description = "Ferramentas educacionais para simulação financeira, comparação de investimentos e planejamento financeiro.";

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="display-5 fw-bold text-center mb-4">Calculadoras Financeiras</h1>
            <p class="lead text-center">Ferramentas que simplificam conceitos financeiros complexos para tomadas de decisão mais inteligentes.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Simulador Educacional -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Simulador Educacional</h5>
                    <p class="card-text">Simule investimentos em renda fixa, calcule rendimentos com CDI e planeje seu futuro financeiro.</p>
                    <div class="d-grid gap-2">
                        <a href="<?php echo url('/calculadoras/demo/simulador.php'); ?>" class="btn btn-primary">Versão Demo</a>
                        <?php if(has_premium_access()): ?>
                            <a href="<?php echo url('/calculadoras/premium/simulador.php'); ?>" class="btn btn-outline-success">Versão Premium</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">Versão demo limitada a 12 meses de simulação</small>
                </div>
            </div>
        </div>

        <!-- Comparador PGBL vs CDB -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Comparador PGBL vs CDB</h5>
                    <p class="card-text">Compare investimentos em PGBL e CDB considerando diferentes cenários tributários e de rendimento.</p>
                    <div class="d-grid gap-2">
                        <a href="<?php echo url('/calculadoras/demo/pgbl-cdb.php'); ?>" class="btn btn-primary">Versão Demo</a>
                        <?php if(has_premium_access()): ?>
                            <a href="<?php echo url('/calculadoras/premium/pgbl-cdb.php'); ?>" class="btn btn-outline-success">Versão Premium</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">Versão demo limitada a valores até R$50.000</small>
                </div>
            </div>
        </div>

        <!-- Simulador de Investimentos -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Simulador de Investimentos</h5>
                    <p class="card-text">Projete o crescimento de seu patrimônio com aportes regulares e diferentes taxas de retorno.</p>
                    <div class="d-grid gap-2">
                        <a href="<?php echo url('/calculadoras/demo/investimentos.php'); ?>" class="btn btn-primary">Versão Demo</a>
                        <?php if(has_premium_access()): ?>
                            <a href="<?php echo url('/calculadoras/premium/investimentos.php'); ?>" class="btn btn-outline-success">Versão Premium</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">Versão demo limitada a projeções de até 5 anos</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action para Premium -->
    <?php if(!has_premium_access()): ?>
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-light p-4 rounded-3 text-center shadow-sm">
                <h2 class="h3">Desbloqueie Todas as Funcionalidades</h2>
                <p class="mb-4">Obtenha acesso ilimitado às versões premium de todas as calculadoras financeiras.</p>
                <a href="<?php echo hotmart_product_link(); ?>" class="btn btn-success btn-lg" target="_blank">
                    Obter Acesso Premium
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>