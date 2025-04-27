# Luaraujo Premium - Calculadoras Financeiras e Educação Financeira

Versão premium do site luaraujo.com com sistema de acesso controlado, venda de livros e conformidade LGPD. Este projeto transforma as calculadoras financeiras gratuitas em um modelo de negócio onde a página principal promove livros via Amazon e produtos digitais via Hotmart, enquanto as calculadoras se tornam conteúdo premium.

## Visão Geral

O projeto Luaraujo Premium evolui o site original para um modelo de negócio sustentável:

- **Página Inicial**: Vitrine para venda de livros e produtos digitais sobre educação financeira
- **Calculadoras**: Acesso controlado mediante pagamento, com versões demo para atração de clientes
- **Blog**: Conteúdo gratuito sobre educação financeira para SEO e atração de tráfego
- **Conformidade LGPD**: Coleta mínima de dados pessoais dos usuários

## Calculadoras Disponíveis

1. **Simulador Educacional**
   - Versão demo: funcionalidade limitada para experimentação
   - Versão premium: funcionalidade completa para assinantes

2. **Comparador PGBL vs CDB**
   - Versão demo: análise básica para experimentação
   - Versão premium: análise detalhada e personalizada

3. **Simulador de Investimentos**
   - Versão demo: projeções básicas para experimentação
   - Versão premium: projeções detalhadas com múltiplos cenários

## Tecnologias Utilizadas

- **Backend**: PHP 8.x otimizado para servidores compartilhados
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Banco de Dados**: MySQL com consultas otimizadas
- **Autenticação**: Sistema leve baseado em sessões PHP
- **Integrações**: Amazon (afiliados) e Hotmart (produtos digitais)

## Estrutura do Projeto

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

## Instalação e Configuração

### Requisitos

- PHP 8.0 ou superior
- MySQL 5.7 ou superior
- Servidor web compatível (Apache recomendado)
- Extensões PHP: mysqli, json, session, gd

### Procedimento de Instalação

1. Clone este repositório:
   ```
   git clone https://github.com/Lucasdoreac/luaraujo_premium_2025.git
   ```

2. Configure o banco de dados:
   - Crie um banco de dados MySQL
   - Importe o arquivo `database/schema.sql`
   - Configure as credenciais em `config/config.php`

3. Configure o servidor web:
   - Aponte o document root para a pasta do projeto
   - Verifique se o mod_rewrite está habilitado (Apache)
   - Certifique-se de que o .htaccess está funcionando corretamente

4. Configure as integrações:
   - Defina suas credenciais de API da Hotmart em `config/config.php`
   - Configure seus links de afiliado da Amazon

5. Teste a instalação:
   - Verifique se a página inicial carrega corretamente
   - Teste o sistema de login e registro
   - Verifique se as calculadoras demo funcionam sem autenticação
   - Teste se o acesso premium está corretamente protegido

## Conformidade com LGPD

Este projeto foi projetado com conformidade LGPD em mente:

1. **Minimização de Dados**:
   - Coleta apenas email (ou nome de usuário) e senha para autenticação
   - Não solicita dados pessoais desnecessários

2. **Consentimento Explícito**:
   - Formulários com checkboxes de opt-in claros
   - Separação entre consentimento obrigatório e marketing

3. **Direitos do Titular**:
   - Mecanismos para exclusão de conta e dados
   - Exportação de dados do usuário
   - Transparência sobre uso de dados

## Otimização para Servidor Compartilhado

O projeto inclui várias otimizações para funcionar bem em ambientes de hospedagem compartilhada:

1. **Performance**:
   - Arquivos CSS/JS minificados
   - Uso de cache para reduzir carga no servidor
   - Consultas SQL otimizadas

2. **Configurações**:
   - .htaccess otimizado
   - Configurações PHP recomendadas
   - Limites de uso de recursos respeitados

## Contribuição

Para contribuir com o projeto:

1. Faça um fork do repositório
2. Crie um branch para sua feature (`git checkout -b feature/nova-feature`)
3. Faça commit das alterações (`git commit -m 'Adiciona nova feature'`)
4. Faça push para o branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## Licença

Todos os direitos reservados © Luciana Araujo.