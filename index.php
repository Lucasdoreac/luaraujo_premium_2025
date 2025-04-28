<?php
/**
 * Página inicial do site
 * 
 * Promove livros via Amazon Afiliados e produtos digitais via Hotmart
 */

require_once './includes/functions.php';

// Define título e descrição da página
$page_title = 'Educação Financeira e Calculadoras';
$page_description = 'Aprenda a investir com livros e calculadoras financeiras premium. Domine suas finanças com conhecimento prático.';

// Inclui o cabeçalho
include_once './includes/header.php';
?>

<!-- Hero section com destaque para livros -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Domine Suas Finanças com Conhecimento Prático</h1>
                <p class="lead">Livros e ferramentas para simplificar o mundo dos investimentos e transformar sua relação com o dinheiro.</p>
                <a href="#livros" class="btn btn-light btn-lg">Ver Livros</a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo url('/assets/images/book-mockup.png'); ?>" alt="Livro de Educação Financeira" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Seção de livros -->
<section id="livros" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Livros Essenciais para sua Jornada Financeira</h2>
        
        <div class="row">
            <!-- Livro 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo url('/assets/images/livro1.jpg'); ?>" class="card-img-top" alt="Capa do livro">
                    <div class="card-body">
                        <h5 class="card-title">Investimentos para Iniciantes</h5>
                        <p class="card-text">Aprenda os fundamentos para começar a investir com segurança e construir patrimônio de forma consistente.</p>
                        <a href="<?php echo amazon_affiliate_link('B08XXXXXXX'); ?>" class="btn btn-primary" target="_blank">Comprar na Amazon</a>
                    </div>
                </div>
            </div>
            
            <!-- Livro 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo url('/assets/images/livro2.jpg'); ?>" class="card-img-top" alt="Capa do livro">
                    <div class="card-body">
                        <h5 class="card-title">Renda Fixa Descomplicada</h5>
                        <p class="card-text">Tudo sobre CDBs, LCIs, LCAs e outros produtos de renda fixa, com estratégias práticas para maximizar rendimentos.</p>
                        <a href="<?php echo amazon_affiliate_link('B08XXXXXXX'); ?>" class="btn btn-primary" target="_blank">Comprar na Amazon</a>
                    </div>
                </div>
            </div>
            
            <!-- Livro 3 (ou curso digital) -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo url('/assets/images/curso1.jpg'); ?>" class="card-img-top" alt="Capa do curso">
                    <div class="card-body">
                        <h5 class="card-title">Curso Calculadoras Financeiras</h5>
                        <p class="card-text">Curso completo + acesso vitalício às calculadoras premium para planejamento financeiro avançado.</p>
                        <a href="<?php echo hotmart_product_link(); ?>" class="btn btn-success" target="_blank">Acessar na Hotmart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Seção preview das calculadoras -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">Calculadoras Financeiras Premium</h2>
        
        <div class="row">
            <!-- Preview Calculadora 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Simulador Educacional</h5>
                        <p class="card-text">Desvende os mistérios da renda fixa e CDI, com juros compostos e inflação na prática.</p>
                        <a href="<?php echo url('/calculadoras/demo/simulador.php'); ?>" class="btn btn-outline-primary">Testar Demo</a>
                    </div>
                </div>
            </div>
            
            <!-- Preview Calculadora 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">PGBL vs CDB</h5>
                        <p class="card-text">Compare PGBL e CDB e encontre o investimento perfeito para você, sem complicações.</p>
                        <a href="<?php echo url('/calculadoras/demo/pgbl-cdb.php'); ?>" class="btn btn-outline-primary">Testar Demo</a>
                    </div>
                </div>
            </div>
            
            <!-- Preview Calculadora 3 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Simulador de Investimentos</h5>
                        <p class="card-text">Veja seu patrimônio crescer com aportes e juros. Planejar nunca foi tão fácil e estimulante.</p>
                        <a href="<?php echo url('/calculadoras/demo/investimentos.php'); ?>" class="btn btn-outline-primary">Testar Demo</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo hotmart_product_link(); ?>" class="btn btn-primary btn-lg">Obter Acesso Premium</a>
        </div>
    </div>
</section>

<!-- Depoimentos -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">O que Dizem Nossos Leitores</h2>
        
        <div class="row">
            <!-- Depoimento 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Carlos Silva</h5>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">"As calculadoras financeiras mudaram minha visão sobre investimentos. Agora consigo planejar meu futuro financeiro com mais confiança."</p>
                    </div>
                </div>
            </div>
            
            <!-- Depoimento 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Ana Oliveira</h5>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">"O livro Investimentos para Iniciantes é fantástico! Linguagem simples e exemplos práticos que me ajudaram a entender conceitos que antes pareciam complexos."</p>
                    </div>
                </div>
            </div>
            
            <!-- Depoimento 3 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Pedro Santos</h5>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">"Uso o comparador PGBL vs CDB frequentemente para tomar decisões mais inteligentes. Uma ferramenta indispensável para quem quer otimizar seus investimentos."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter signup (minimalista para LGPD) -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Receba Conteúdo Gratuito</h3>
                <p>Inscreva-se para receber dicas de investimentos e educação financeira.</p>
                
                <form class="row g-3 justify-content-center" action="<?php echo url('/api/newsletter.php'); ?>" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="col-auto">
                        <input type="email" class="form-control" name="email" placeholder="Seu email" required>
                    </div>
                    
                    <div class="col-auto">
                        <button type="submit" class="btn btn-light">Inscrever</button>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-check text-start mt-2">
                            <input class="form-check-input" type="checkbox" id="consent_newsletter" name="consent_newsletter" required>
                            <label class="form-check-label small" for="consent_newsletter">
                                Concordo em receber conteúdo de educação financeira por email, de acordo com a <a href="<?php echo url('/legal/privacidade.php'); ?>" class="text-white" target="_blank">Política de Privacidade</a>.
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
// Inclui o footer
include_once './includes/footer.php';
?>