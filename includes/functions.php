<?php
/**
 * Funções utilitárias
 * 
 * Funções comuns utilizadas em todo o site
 */

require_once __DIR__ . '/../config/config.php';

/**
 * Gera um hash seguro para senhas
 * 
 * @param string $password Senha em texto plano
 * @return string Hash da senha
 */
function hash_password($password) {
    return password_hash($password . HASH_SALT, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verifica se uma senha corresponde ao hash armazenado
 * 
 * @param string $password Senha em texto plano
 * @param string $hash Hash armazenado
 * @return bool TRUE se a senha corresponde ao hash, FALSE caso contrário
 */
function verify_password($password, $hash) {
    return password_verify($password . HASH_SALT, $hash);
}

/**
 * Redireciona para uma URL específica
 * 
 * @param string $url URL para redirecionamento
 * @return void
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Gera uma URL absoluta com base na URL base
 * 
 * @param string $path Caminho relativo
 * @return string URL absoluta
 */
function url($path) {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Sanitiza dados para evitar XSS
 * 
 * @param string|array $data Dados a serem sanitizados
 * @return string|array Dados sanitizados
 */
function sanitize($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize($value);
        }
    } else {
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    return $data;
}

/**
 * Verifica se o usuário está logado
 * 
 * @return bool TRUE se o usuário está logado, FALSE caso contrário
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Requer que o usuário esteja logado
 * 
 * @param string $redirect URL para redirecionar se não estiver logado
 * @return void
 */
function require_login($redirect = '/auth/login.php') {
    if (!is_logged_in()) {
        // Salva a URL atual para redirecionar de volta após o login
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        redirect(url($redirect));
    }
}

/**
 * Verifica se o usuário tem acesso premium
 * 
 * @return bool TRUE se o usuário tem acesso premium, FALSE caso contrário
 */
function has_premium_access() {
    if (!is_logged_in()) {
        return false;
    }
    
    require_once __DIR__ . '/db.php';
    
    $user_id = $_SESSION['user_id'];
    $query = "SELECT id FROM licenses 
              WHERE user_id = ? 
              AND status = 'active' 
              AND (expires_at IS NULL OR expires_at > NOW())";
    
    $result = db_fetch_one($query, "i", [$user_id]);
    
    return $result !== null;
}

/**
 * Requer que o usuário tenha acesso premium
 * 
 * @param string $redirect URL para redirecionar se não tiver acesso premium
 * @return void
 */
function require_premium_access($redirect = '/produtos/premium.php') {
    require_login();
    
    if (!has_premium_access()) {
        redirect(url($redirect));
    }
}

/**
 * Gera um token CSRF
 * 
 * @return string Token CSRF
 */
function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Verifica se um token CSRF é válido
 * 
 * @param string $token Token CSRF a ser verificado
 * @return bool TRUE se o token é válido, FALSE caso contrário
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Formata um valor monetário
 * 
 * @param float $value Valor a ser formatado
 * @param int $decimals Número de casas decimais
 * @return string Valor formatado como moeda (R$ 1.234,56)
 */
function format_money($value, $decimals = 2) {
    return 'R$ ' . number_format($value, $decimals, ',', '.');
}

/**
 * Formata uma porcentagem
 * 
 * @param float $value Valor a ser formatado
 * @param int $decimals Número de casas decimais
 * @return string Valor formatado como porcentagem (12,34%)
 */
function format_percent($value, $decimals = 2) {
    return number_format($value, $decimals, ',', '.') . '%';
}

/**
 * Gera um link de afiliado da Amazon
 * 
 * @param string $asin ASIN do produto
 * @return string URL de afiliado
 */
function amazon_affiliate_link($asin) {
    return "https://www.amazon.com.br/dp/{$asin}?tag=" . AMAZON_TRACKING_ID;
}

/**
 * Gera um link para o produto na Hotmart
 * 
 * @return string URL do produto na Hotmart
 */
function hotmart_product_link() {
    return "https://pay.hotmart.com/" . HOTMART_PRODUCT_ID;
}

/**
 * Registra um evento de auditoria
 * 
 * @param string $event_type Tipo de evento
 * @param array $data Dados do evento
 * @return void
 */
function log_audit($event_type, $data = []) {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    require_once __DIR__ . '/db.php';
    
    $audit_data = [
        'user_id' => $user_id,
        'event_type' => $event_type,
        'ip_address' => $ip,
        'user_agent' => $user_agent,
        'event_data' => json_encode($data),
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    db_insert('audit_logs', $audit_data);
}