<?php
/**
 * Footer padrão do site
 */
?>
    <!-- Conteúdo principal termina aqui -->
    
    <!-- Footer -->
    <footer class="site-footer bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Luaraujo Premium</h5>
                    <p>Educação financeira e calculadoras premium para planejamento de investimentos.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-2" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white me-2" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo url('/'); ?>" class="text-white">Início</a></li>
                        <li><a href="<?php echo url('/calculadoras/demo/'); ?>" class="text-white">Calculadoras</a></li>
                        <li><a href="<?php echo url('/blog/'); ?>" class="text-white">Blog</a></li>
                        <li><a href="<?php echo hotmart_product_link(); ?>" class="text-white" target="_blank">Acesso Premium</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Calculadoras</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo url('/calculadoras/demo/simulador.php'); ?>" class="text-white">Simulador Educacional</a></li>
                        <li><a href="<?php echo url('/calculadoras/demo/pgbl-cdb.php'); ?>" class="text-white">Comparador PGBL vs CDB</a></li>
                        <li><a href="<?php echo url('/calculadoras/demo/investimentos.php'); ?>" class="text-white">Simulador de Investimentos</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo url('/legal/privacidade.php'); ?>" class="text-white">Política de Privacidade</a></li>
                        <li><a href="<?php echo url('/legal/termos.php'); ?>" class="text-white">Termos de Uso</a></li>
                        <li><a href="<?php echo url('/legal/cookies.php'); ?>" class="text-white">Política de Cookies</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="mt-4 mb-4 border-secondary">
            
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="small mb-0">&copy; <?php echo date('Y'); ?> Luaraujo Premium. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small mb-0">Desenvolvido com <i class="bi bi-heart-fill text-danger"></i> por Lucas Dórea</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="<?php echo url('/assets/js/app.min.js'); ?>"></script>
    
    <?php if (isset($extra_scripts)) echo $extra_scripts; ?>
</body>
</html>