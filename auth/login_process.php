<?php
/**
 * Processamento do login
 * 
 * Verifica credenciais e autentica o usuário
 */

require_once '../includes/functions.php';
require_once '../includes/db.php';

// Redireciona se já estiver logado
if (is_logged_in()) {
    redirect(url('/'));
}

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('/auth/login.php'));
}

// Verifica CSRF token
if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
    $_SESSION['login_error'] = 'Erro de segurança. Por favor, tente novamente.';
    redirect(url('/auth/login.php'));
}

// Obtém os dados do formulário
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$remember_me = isset($_POST['remember_me']) ? true : false;

// Validação básica
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = 'Por favor, preencha todos os campos.';
    redirect(url('/auth/login.php'));
}

// Busca o usuário no banco de dados
$query = "SELECT id, username, email, password_hash FROM users WHERE email = ?";
$user = db_fetch_one($query, "s", [$email]);

// Verifica se o usuário existe e a senha está correta
if (!$user || !verify_password($password, $user['password_hash'])) {
    // Registra tentativa de login falha para auditoria
    log_audit('login_failed', ['email' => $email]);
    
    $_SESSION['login_error'] = 'Email ou senha incorretos.';
    redirect(url('/auth/login.php'));
}

// Autentica o usuário
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];

// Se "Lembrar de mim" estiver marcado, define um cookie
if ($remember_me) {
    $token = bin2hex(random_bytes(32));
    $hash = hash_password($token);
    $expiration = time() + 30 * 24 * 60 * 60; // 30 dias
    
    // Salva o token no banco de dados
    $remember_data = [
        'user_id' => $user['id'],
        'token_hash' => $hash,
        'expires_at' => date('Y-m-d H:i:s', $expiration),
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    ];
    
    db_insert('remember_tokens', $remember_data);
    
    // Define o cookie
    setcookie('remember_token', $token, $expiration, '/', '', true, true);
}

// Atualiza o último login
db_update('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', 'i', [$user['id']]);

// Registra login bem-sucedido para auditoria
log_audit('login_success', ['user_id' => $user['id']]);

// Redireciona para a página solicitada ou página inicial
$redirect_to = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : '/';
unset($_SESSION['redirect_after_login']);

redirect(url($redirect_to));