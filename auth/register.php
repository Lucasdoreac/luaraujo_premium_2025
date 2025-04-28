<?php
/**
 * Página de registro
 * 
 * Formulário de cadastro com mínimo de dados para LGPD
 */

require_once '../includes/functions.php';

// Se já estiver logado, redireciona para a página inicial
if (is_logged_in()) {
    redirect(url('/'));
}

// Define título e descrição da página
$page_title = 'Cadastro';
$page_description = 'Crie sua conta para acessar o conteúdo premium.';

// Verifica se há erro de registro
$register_error = isset($_SESSION['register_error']) ? $_SESSION['register_error'] : '';
unset($_SESSION['register_error']);

// Inclui o cabeçalho
include_once '../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="h3 mb-4 text-center">Criar uma conta</h1>
                    
                    <?php if (!empty($register_error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $register_error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo url('/auth/register_process.php'); ?>" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Nome de usuário</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                            <div class="form-text">Mínimo de 8 caracteres.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar senha</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" minlength="8" required>
                        </div>
                        
                        <!-- Consentimento para LGPD -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="privacy_consent" name="privacy_consent" required>
                            <label class="form-check-label" for="privacy_consent">
                                Li e concordo com a <a href="<?php echo url('/legal/privacidade.php'); ?>" target="_blank">Política de Privacidade</a> e os <a href="<?php echo url('/legal/termos.php'); ?>" target="_blank">Termos de Uso</a>.
                            </label>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="marketing_consent" name="marketing_consent">
                            <label class="form-check-label" for="marketing_consent">
                                Aceito receber conteúdos e novidades por email (opcional).
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p class="mb-0">
                            Já tem uma conta? <a href="<?php echo url('/auth/login.php'); ?>" class="text-decoration-none">Faça login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Inclui o footer
include_once '../includes/footer.php';
?>