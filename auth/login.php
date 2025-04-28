<?php
/**
 * Página de login
 * 
 * Sistema de autenticação leve
 */

require_once '../includes/functions.php';

// Se já estiver logado, redireciona para a página inicial
if (is_logged_in()) {
    redirect(url('/'));
}

// Define título e descrição da página
$page_title = 'Login';
$page_description = 'Faça login para acessar o conteúdo premium.';

// Verifica se há erro de login
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);

// Verifica se há mensagem de sucesso
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

// Inclui o cabeçalho
include_once '../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="h3 mb-4 text-center">Entrar na sua conta</h1>
                    
                    <?php if (!empty($login_error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $login_error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo url('/auth/login_process.php'); ?>" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                            <label class="form-check-label" for="remember_me">Lembrar de mim</label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p class="mb-2">
                            <a href="<?php echo url('/auth/forgot_password.php'); ?>" class="text-decoration-none">Esqueceu sua senha?</a>
                        </p>
                        <p class="mb-0">
                            Não tem uma conta? <a href="<?php echo url('/auth/register.php'); ?>" class="text-decoration-none">Cadastre-se</a>
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