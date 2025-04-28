<?php
/**
 * Hotmart Webhook Handler
 * 
 * Recebe e processa notificações de eventos da Hotmart (compras, reembolsos, etc.)
 * para gerenciar licenças de acesso às versões premium das calculadoras.
 */
require_once '../config/config.php';
require_once '../includes/functions.php';
require_once '../includes/db.php';

// 1. Validar método de requisição (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// 2. Validar assinatura Hotmart (usando HOTMART_WEBHOOK_SECRET e cabeçalho 'x-hotmart-hottok')
$hotmart_signature = $_SERVER['HTTP_X_HOTMART_HOTTOK'] ?? '';
$webhook_secret = HOTMART_WEBHOOK_SECRET;

if (empty($hotmart_signature)) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Missing Hotmart signature']);
    log_audit('hotmart_webhook_error', ['error' => 'Missing signature']);
    exit;
}

// Verificação básica da assinatura (seria implementada uma verificação mais robusta)
if ($hotmart_signature !== $webhook_secret) {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Invalid signature']);
    log_audit('hotmart_webhook_error', ['error' => 'Invalid signature']);
    exit;
}

// 3. Obter payload JSON
$payload = file_get_contents('php://input');

// 4. Decodificar payload JSON
$data = json_decode($payload, true);

// 5. Verificar se a decodificação foi bem-sucedida
if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON payload']);
    log_audit('hotmart_webhook_error', ['error' => 'Invalid JSON']);
    exit;
}

// 6. Extrair dados relevantes (email do comprador, código da transação, ID do produto, status, etc.)
$event = $data['event'] ?? '';
$email = $data['buyer']['email'] ?? '';
$transaction_code = $data['purchase']['transaction'] ?? '';
$product_id = $data['product']['id'] ?? '';
$status = $data['purchase']['status'] ?? '';

// Log para depuração
log_audit('hotmart_webhook_received', [
    'event' => $event,
    'email' => $email,
    'transaction' => $transaction_code,
    'product' => $product_id,
    'status' => $status
]);

// 7. Com base no status ('approved', 'billet_printed', 'canceled', 'expired', 'refunded', etc.):
if (empty($email) || empty($transaction_code) || empty($product_id) || empty($status)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    log_audit('hotmart_webhook_error', ['error' => 'Missing fields']);
    exit;
}

// Verificar status e tomar ações apropriadas
switch ($status) {
    case 'approved':
        // Encontrar usuário pelo email na tabela 'users'
        $user_query = "SELECT id FROM users WHERE email = ?";
        $user = db_fetch_one($user_query, "s", [$email]);
        
        if ($user) {
            $user_id = $user['id'];
            
            // Verificar se já existe licença para este usuário e produto
            $license_query = "SELECT id FROM licenses WHERE user_id = ? AND product_id = ?";
            $existing_license = db_fetch_one($license_query, "is", [$user_id, $product_id]);
            
            if ($existing_license) {
                // Atualizar licença existente
                $update_query = "UPDATE licenses SET 
                                  hotmart_code = ?, 
                                  status = 'active', 
                                  updated_at = NOW() 
                                WHERE user_id = ? AND product_id = ?";
                db_execute($update_query, "sis", [$transaction_code, $user_id, $product_id]);
                
                log_audit('hotmart_license_updated', [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'transaction' => $transaction_code
                ]);
            } else {
                // Inserir nova licença
                $insert_query = "INSERT INTO licenses 
                                 (user_id, hotmart_code, product_id, status, created_at) 
                                 VALUES (?, ?, ?, 'active', NOW())";
                db_execute($insert_query, "iss", [$user_id, $transaction_code, $product_id]);
                
                log_audit('hotmart_license_created', [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'transaction' => $transaction_code
                ]);
            }
        } else {
            // Usuário não encontrado - possibilidade de armazenar em tabela de espera
            // ou enviar email para usuário criar conta
            log_audit('hotmart_user_not_found', [
                'email' => $email,
                'transaction' => $transaction_code,
                'product_id' => $product_id
            ]);
        }
        break;
        
    case 'canceled':
    case 'refunded':
        // Atualizar status da licença para 'revoked'
        $update_query = "UPDATE licenses SET 
                        status = 'revoked', 
                        updated_at = NOW() 
                        WHERE hotmart_code = ?";
        db_execute($update_query, "s", [$transaction_code]);
        
        log_audit('hotmart_license_revoked', [
            'transaction' => $transaction_code,
            'reason' => $status
        ]);
        break;
        
    case 'expired':
        // Atualizar status da licença para 'expired'
        $update_query = "UPDATE licenses SET 
                        status = 'expired', 
                        updated_at = NOW() 
                        WHERE hotmart_code = ?";
        db_execute($update_query, "s", [$transaction_code]);
        
        log_audit('hotmart_license_expired', [
            'transaction' => $transaction_code
        ]);
        break;
        
    default:
        // Outros status: billet_printed, denied, dispute, etc.
        log_audit('hotmart_status_' . $status, [
            'email' => $email,
            'transaction' => $transaction_code
        ]);
        break;
}

// 8. Registrar evento (sucesso ou falha) usando log_audit()
// Já implementado nos blocos switch acima

// 9. Responder à Hotmart com HTTP 200 OK após processamento bem-sucedido
http_response_code(200);
echo json_encode(['status' => 'success', 'message' => 'Webhook processed successfully']);
