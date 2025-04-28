<?php
/**
 * Header padrão do site
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title><?php echo isset($page_title) ? $page_title . ' | Luaraujo Premium' : 'Luaraujo Premium - Educação Financeira e Calculadoras'; ?></title>
    
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Educação financeira e calculadoras premium para planejamento de investimentos.'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo url('/assets/images/favicon.png'); ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo url('/assets/css/styles.min.css'); ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' | Luaraujo Premium' : 'Luaraujo Premium - Educação Financeira e Calculadoras'; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'Educação financeira e calculadoras premium para planejamento de investimentos.'; ?>">
    <meta property="og:image" content="<?php echo url('/assets/images/og-image.jpg'); ?>">
    <meta property="og:url" content="<?php echo isset($canonical_url) ? $canonical_url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">
    
    <?php if (isset($extra_head)) echo $extra_head; ?>
</head>
<body class="<?php echo isset($body_class) ? $body_class : ''; ?>">
    <!-- Header -->
    <header class="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="<?php echo url('/'); ?>">
                    <img src="<?php echo url('/assets/images/logo.png'); ?>" alt="Luaraujo Premium" height="40">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link<?php echo $_SERVER['REQUEST_URI'] === '/' ? ' active' : ''; ?>" href="<?php echo url('/'); ?>">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php echo strpos($_SERVER['REQUEST_URI'], '/calculadoras/') === 0 ? ' active' : ''; ?>" href="<?php echo url('/calculadoras/demo/'); ?>">Calculadoras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php echo strpos($_SERVER['REQUEST_URI'], '/blog/') === 0 ? ' active' : ''; ?>" href="<?php echo url('/blog/'); ?>">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo hotmart_product_link(); ?>" target="_blank">Acesso Premium</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex align-items-center">
                        <?php if (is_logged_in()): ?>
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Minha Conta
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <?php if (has_premium_access()): ?>
                                        <li><a class="dropdown-item" href="<?php echo url('/calculadoras/premium/'); ?>">Calculadoras Premium</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="<?php echo url('/auth/perfil.php'); ?>">Meu Perfil</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('/auth/logout.php'); ?>">Sair</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo url('/auth/login.php'); ?>" class="btn btn-outline-light me-2">Entrar</a>
                            <a href="<?php echo url('/auth/register.php'); ?>" class="btn btn-light">Cadastrar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Conteúdo principal começa aqui -->