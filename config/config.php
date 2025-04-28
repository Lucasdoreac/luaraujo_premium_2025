<?php
/**
 * Configurações globais do site
 * 
 * Este arquivo contém todas as configurações globais do site,
 * incluindo conexão com banco de dados, URLs, e outras constantes.
 */

// Ambiente (development, production)
define('ENVIRONMENT', 'development');

// Configurações de URL
define('BASE_URL', 'http://localhost/luaraujo_premium_2025'); // Alterar para URL de produção quando for o caso

// Configurações de Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'luaraujo_premium');
define('DB_USER', 'root'); // Alterar para usuário de produção quando for o caso
define('DB_PASS', ''); // Alterar para senha de produção quando for o caso

// Configurações de E-mail
define('MAIL_HOST', 'smtp.hostinger.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'contato@luaraujo.com'); // Alterar para email real
define('MAIL_PASSWORD', ''); // Alterar para senha real
define('MAIL_FROM', 'contato@luaraujo.com');
define('MAIL_FROM_NAME', 'Luaraujo Premium');

// Configurações da Hotmart
define('HOTMART_APP_ID', ''); // Preencher com ID real
define('HOTMART_APP_SECRET', ''); // Preencher com secret real
define('HOTMART_PRODUCT_ID', ''); // Preencher com ID do produto

// Configurações da Amazon (Afiliados)
define('AMAZON_TRACKING_ID', ''); // Preencher com ID de afiliado

// Configurações de Segurança
define('HASH_SALT', 'luaraujo_premium_2025'); // Alterar para um valor único e secreto em produção
define('SESSION_LIFETIME', 86400); // 24 horas em segundos

// Configurações LGPD
define('PRIVACY_POLICY_VERSION', '1.0');
define('TERMS_VERSION', '1.0');

// Controle de erros
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}