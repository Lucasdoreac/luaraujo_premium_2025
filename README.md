# Luaraujo Premium - Calculadoras Financeiras e Educação Financeira

Versão premium do site luaraujo.com com sistema de acesso controlado, venda de livros e conformidade LGPD. Este projeto transforma as calculadoras financeiras gratuitas em um modelo de negócio onde a página principal promove livros via Amazon e produtos digitais via Hotmart, enquanto as calculadoras se tornam conteúdo premium.

## ⚠️ IMPORTANTE: CONTINUIDADE DO PROJETO ⚠️

**Este README deve SEMPRE ser atualizado com o prompt master de desenvolvimento quando houver modificações no projeto. Este prompt serve como guia de referência completo para o desenvolvimento e deve ser mantido sincronizado com todas as atualizações e decisões do projeto.**

Ao retomar o desenvolvimento:
1. Revise o prompt master completo abaixo
2. Atualize sempre este README quando houver alterações no prompt
3. Use o prompt como base para todas as decisões de implementação

---

# PROMPT MASTER: RECRIAÇÃO DO LUARAUJO.COM EM PHP COM VENDA DE LIVROS E CALCULADORAS PRIVADAS

## VISÃO GERAL DO PROJETO
Recriar o site luaraujo.com utilizando PHP para servidor compartilhado da Hostinger, transformando o modelo atual de calculadoras gratuitas para um formato onde a página principal promove livros à venda na Amazon e Hotmart, enquanto as calculadoras se tornam conteúdo premium de acesso controlado, com conformidade LGPD.

## ANÁLISE DO SITE ATUAL

O site atual (luaraujo.com) possui uma estrutura simples e direta, focada em três calculadoras financeiras educativas:
- Simulador Educacional: para renda fixa e CDI
- Comparador PGBL vs CDB: para análise comparativa de investimentos
- Simulador de Investimentos: para projeções de patrimônio com aportes e juros

A identidade visual utiliza predominantemente tons de azul (#b4e0e8 e #2c3e50), com design limpo e responsivo.

## OBJETIVOS DA RECRIAÇÃO

1. **Transformar a Página Principal**:
   - Foco em venda de livros de educação financeira via Amazon (afiliados)
   - Promoção de produtos digitais via Hotmart
   - Apresentação das calculadoras como conteúdo premium

2. **Sistema de Acesso às Calculadoras**:
   - Conversão das calculadoras existentes para acesso controlado
   - Versões demo/simplificadas para atração de clientes
   - Sistema de verificação de licença via Hotmart

3. **Infraestrutura Otimizada**:
   - Implementação em PHP puro ou framework leve
   - Otimização para servidor compartilhado Hostinger
   - Consolidação de arquivos CSS/JS redundantes

4. **Conformidade com LGPD**:
   - Minimização na coleta de dados pessoais
   - Política de privacidade clara e acessível
   - Mecanismos técnicos de proteção de dados

## ESPECIFICAÇÕES TÉCNICAS

### Arquitetura PHP

```
/
├── index.php                 # Página inicial com promoção de livros
├── calculadoras/             # Diretório de calculadoras
│   ├── demo/                 # Versões demonstrativas
│   │   ├── simulador.php     # Demo do simulador educacional
│   │   ├── pgbl-cdb.php      # Demo do comparador PGBL vs CDB
│   │   └── investimentos.php # Demo do simulador de investimentos
│   └── premium/              # Versões completas (acesso controlado)
│       ├── simulador.php     # Simulador educacional completo
│       ├── pgbl-cdb.php      # Comparador PGBL vs CDB completo
│       └── investimentos.php # Simulador de investimentos completo
├── assets/
│   ├── css/
│   │   └── styles.min.css    # CSS consolidado e minificado
│   ├── js/
│   │   └── app.min.js        # JavaScript consolidado e minificado
│   └── images/               # Imagens e recursos visuais
├── auth/
│   ├── login.php             # Sistema simplificado de login
│   ├── register.php          # Registro com mínimo de dados
│   └── verify.php            # Verificação de licença Hotmart
├── blog/                     # Blog de educação financeira para SEO
│   ├── index.php             # Listagem de artigos
│   └── artigo.php            # Template de artigo
├── api/                      # API interna para processamento AJAX
│   └── calculate.php         # Endpoint para cálculos
├── includes/                 # Componentes reutilizáveis
│   ├── header.php            # Cabeçalho do site
│   ├── footer.php            # Rodapé do site
│   ├── db.php                # Conexão com banco de dados
│   └── functions.php         # Funções utilitárias
├── config/
│   ├── config.php            # Configurações globais
│   └── routes.php            # Rotas simplificadas
└── legal/
    ├── privacidade.php       # Política de privacidade LGPD
    └── termos.php            # Termos de uso
```

### Banco de Dados Minimalista

```sql
-- Usuários (mínimo de dados para LGPD)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    consent_marketing BOOLEAN DEFAULT FALSE,
    last_login TIMESTAMP NULL
);

-- Licenças/Acessos via Hotmart
CREATE TABLE licenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hotmart_code VARCHAR(100) UNIQUE,
    product_id VARCHAR(20) NOT NULL,
    status ENUM('active', 'expired', 'revoked') DEFAULT 'active',
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Opcionalmente, para features futuras
CREATE TABLE user_preferences (
    user_id INT PRIMARY KEY,
    theme ENUM('light', 'dark') DEFAULT 'light',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Autenticação e Autorização

```php
<?php
// Exemplo simplificado de middleware de autenticação
function require_login() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /auth/login.php');
        exit;
    }
}

// Exemplo de verificação de acesso premium
function verify_premium_access() {
    require_login();
    $user_id = $_SESSION['user_id'];
    
    $db = get_db_connection();
    $stmt = $db->prepare("SELECT * FROM licenses WHERE user_id = ? AND status = 'active' AND (expires_at IS NULL OR expires_at > NOW())");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        header('Location: /produtos/premium.php');
        exit;
    }
}
?>
```

### Integração com Hotmart

```php
<?php
// Processamento de webhook da Hotmart
function process_hotmart_webhook() {
    // Verificar autenticidade do webhook
    $hotmart_secret = $_ENV['HOTMART_SECRET'];
    $received_signature = $_SERVER['HTTP_X_HOTMART_SIGNATURE'] ?? '';
    
    // Obter dados do webhook
    $payload = file_get_contents('php://input');
    
    // Validar assinatura
    $calculated_signature = hash_hmac('sha256', $payload, $hotmart_secret);
    if (!hash_equals($calculated_signature, $received_signature)) {
        http_response_code(403);
        exit('Invalid signature');
    }
    
    $data = json_decode($payload, true);
    
    // Processar diferentes eventos
    switch ($data['event']) {
        case 'PURCHASE_APPROVED':
            register_new_license($data);
            break;
        case 'PURCHASE_CANCELED':
        case 'PURCHASE_REFUNDED':
            revoke_license($data);
            break;
        case 'SUBSCRIPTION_CANCELED':
            expire_license($data);
            break;
    }
    
    http_response_code(200);
    echo 'Webhook processed';
}

// Registrar nova licença
function register_new_license($data) {
    // Implementação...
}
?>
```

### Calculadoras: Exemplo Simplificado

```php
<?php
// /calculadoras/premium/simulador.php
require_once '../../includes/functions.php';
verify_premium_access(); // Verificar acesso premium

// HTML da calculadora com formulário
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador Educacional Premium | Luaraujo</title>
    <link rel="stylesheet" href="/assets/css/styles.min.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    
    <main class="container my-5">
        <h1>Simulador Educacional Premium</h1>
        
        <form id="calculator-form" class="needs-validation" novalidate>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="initial" class="form-label">Valor Inicial (R$)</label>
                    <input type="number" class="form-control" id="initial" step="0.01" min="0" required>
                </div>
                <div class="col-md-6">
                    <label for="monthly" class="form-label">Aporte Mensal (R$)</label>
                    <input type="number" class="form-control" id="monthly" step="0.01" min="0" required>
                </div>
            </div>
            
            <!-- Mais campos do formulário -->
            
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>
        
        <div id="results" class="mt-5 d-none">
            <!-- Resultados serão inseridos via JavaScript -->
        </div>
    </main>
    
    <?php include '../../includes/footer.php'; ?>
    <script src="/assets/js/app.min.js"></script>
    <script>
        // JavaScript específico para esta calculadora
    </script>
</body>
</html>
```

### Conformidade LGPD

```php
<?php
// Exemplo de formulário de registro com consentimento explícito
?>
<form action="register_process.php" method="post">
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
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="privacy_consent" name="privacy_consent" required>
        <label class="form-check-label" for="privacy_consent">Li e concordo com a <a href="/legal/privacidade.php" target="_blank">Política de Privacidade</a></label>
    </div>
    
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="marketing_consent" name="marketing_consent">
        <label class="form-check-label" for="marketing_consent">Aceito receber conteúdos e novidades por email (opcional)</label>
    </div>
    
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
```

## PÁGINA INICIAL REDESENHADA

A nova página inicial será focada em venda de livros, com o seguinte layout:

```html
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luaraujo - Educação Financeira e Calculadoras</title>
    <link rel="stylesheet" href="/assets/css/styles.min.css">
</head>
<body>
    <!-- Header com menu de navegação -->
    <?php include './includes/header.php'; ?>
    
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
                    <img src="/assets/images/book-mockup.png" alt="Livro de Educação Financeira" class="img-fluid">
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
                        <img src="/assets/images/livro1.jpg" class="card-img-top" alt="Capa do livro">
                        <div class="card-body">
                            <h5 class="card-title">Investimentos para Iniciantes</h5>
                            <p class="card-text">Aprenda os fundamentos para começar a investir com segurança e construir patrimônio de forma consistente.</p>
                            <a href="https://amazon.com/link-do-livro" class="btn btn-primary" target="_blank">Comprar na Amazon</a>
                        </div>
                    </div>
                </div>
                
                <!-- Livro 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/assets/images/livro2.jpg" class="card-img-top" alt="Capa do livro">
                        <div class="card-body">
                            <h5 class="card-title">Renda Fixa Descomplicada</h5>
                            <p class="card-text">Tudo sobre CDBs, LCIs, LCAs e outros produtos de renda fixa, com estratégias práticas para maximizar rendimentos.</p>
                            <a href="https://amazon.com/link-do-livro" class="btn btn-primary" target="_blank">Comprar na Amazon</a>
                        </div>
                    </div>
                </div>
                
                <!-- Livro 3 (ou curso digital) -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/assets/images/curso1.jpg" class="card-img-top" alt="Capa do curso">
                        <div class="card-body">
                            <h5 class="card-title">Curso Calculadoras Financeiras</h5>
                            <p class="card-text">Curso completo + acesso vitalício às calculadoras premium para planejamento financeiro avançado.</p>
                            <a href="https://hotmart.com/link-do-produto" class="btn btn-success" target="_blank">Acessar na Hotmart</a>
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
                            <a href="/calculadoras/demo/simulador.php" class="btn btn-outline-primary">Testar Demo</a>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Calculadora 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">PGBL vs CDB</h5>
                            <p class="card-text">Compare PGBL e CDB e encontre o investimento perfeito para você, sem complicações.</p>
                            <a href="/calculadoras/demo/pgbl-cdb.php" class="btn btn-outline-primary">Testar Demo</a>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Calculadora 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Simulador de Investimentos</h5>
                            <p class="card-text">Veja seu patrimônio crescer com aportes e juros. Planejar nunca foi tão fácil e estimulante.</p>
                            <a href="/calculadoras/demo/investimentos.php" class="btn btn-outline-primary">Testar Demo</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="https://hotmart.com/link-do-produto" class="btn btn-primary btn-lg">Obter Acesso Premium</a>
            </div>
        </div>
    </section>
    
    <!-- Depoimentos -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">O que Dizem Nossos Leitores</h2>
            
            <!-- Carrossel de depoimentos -->
            <!-- ... -->
        </div>
    </section>
    
    <!-- Blog preview -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Conteúdo Gratuito de Educação Financeira</h2>
            
            <div class="row">
                <!-- Artigos recentes do blog -->
                <!-- ... -->
            </div>
            
            <div class="text-center mt-4">
                <a href="/blog/" class="btn btn-outline-primary">Ver Todos os Artigos</a>
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
                    
                    <form class="row g-3 justify-content-center">
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="Seu email">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-light">Inscrever</button>
                        </div>
                        <div class="form-text text-white mt-2">
                            Respeitamos sua privacidade. Você pode cancelar a qualquer momento.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include './includes/footer.php'; ?>
    
    <script src="/assets/js/app.min.js"></script>
</body>
</html>
```

## OTIMIZAÇÕES PARA HOSTINGER

### Configuração .htaccess

```apacheconf
# Ativar compressão Gzip
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/x-javascript application/json
</IfModule>

# Configurar cache de navegador
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType text/html "access plus 1 day"
</IfModule>

# Melhorar segurança
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Redirecionar para HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Configurações PHP (php.ini ou .user.ini)

```ini
; Aumentar limite de memória (se possível no servidor compartilhado)
memory_limit = 128M

; Tempo máximo de execução
max_execution_time = 60

; Upload de arquivos (se necessário)
upload_max_filesize = 8M
post_max_size = 8M

; Otimizações de performance
realpath_cache_size = 128k
realpath_cache_ttl = 86400

; Habilitar opcache
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
opcache.revalidate_freq = 60
```

## CHECKLIST DE IMPLEMENTAÇÃO

1. **Fase de Estruturação**
   - [ ] Configurar estrutura de diretórios
   - [ ] Criar esqueleto de todas as páginas
   - [ ] Consolidar e otimizar arquivos CSS/JS existentes

2. **Fase de Desenvolvimento PHP**
   - [ ] Implementar sistema de autenticação leve
   - [ ] Criar formulários mínimos para LGPD
   - [ ] Desenvolver middlewares de verificação de acesso
   - [ ] Implementar integração Hotmart/Amazon
   - [ ] Adaptar calculadoras para versões demo e premium

3. **Fase de Banco de Dados**
   - [ ] Criar esquema de banco de dados
   - [ ] Implementar conexões otimizadas
   - [ ] Configurar consultas eficientes

4. **Fase de Otimização**
   - [ ] Minificar CSS/JS
   - [ ] Otimizar imagens
   - [ ] Implementar cache
   - [ ] Configurar .htaccess

5. **Fase de Conteúdo**
   - [ ] Criar páginas de venda para livros
   - [ ] Desenvolver blog inicial
   - [ ] Escrever políticas de privacidade LGPD
   - [ ] Implementar depoimentos

6. **Fase de Testes**
   - [ ] Testar todas as calculadoras
   - [ ] Verificar responsividade
   - [ ] Testar sistema de autenticação
   - [ ] Validar integração Hotmart/Amazon

## CONSIDERAÇÕES FINAIS

O projeto deve manter a qualidade e funcionalidade das calculadoras existentes, enquanto evolui o modelo de negócio para venda de livros e acesso premium. A implementação deve ser otimizada para servidor compartilhado da Hostinger, com especial atenção à conformidade com a LGPD e minimização de coleta de dados pessoais.

A autenticação leve e integração com Hotmart permitirão monetizar o conteúdo sem a necessidade de implementar sistemas complexos de pagamento próprios, enquanto a venda de livros via Amazon fornecerá uma fonte adicional de receita.

O blog servirá como estratégia de atração de tráfego orgânico, direcionando visitantes para os produtos à venda e versões demo das calculadoras.