# Luaraujo Premium 2025

Recriação do site luaraujo.com, transformando-o de um modelo de calculadoras gratuitas para um formato premium com venda de livros e acesso controlado às calculadoras.

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
│   ├── css/                  # CSS consolidado e minificado
│   ├── js/                   # JavaScript consolidado e minificado
│   └── images/               # Imagens e recursos visuais
├── auth/                     # Sistema de autenticação leve
├── blog/                     # Blog para SEO e atração de leads
├── api/                      # API interna para cálculos
├── includes/                 # Componentes reutilizáveis
├── config/                   # Configurações globais
└── legal/                    # Políticas LGPD
```

## Configuração

1. Clone o repositório
2. Configure o arquivo `config/config.php` com suas credenciais
3. Importe o esquema do banco de dados de `database/schema.sql`
4. Configure o servidor web para apontar para o diretório raiz do projeto

## Banco de Dados

O projeto utiliza um banco de dados MySQL com as seguintes tabelas principais:
- `users`: Armazena informações básicas dos usuários (mínimo para LGPD)
- `licenses`: Gerencia licenças e acessos via Hotmart

## Requisitos

- PHP 8.0+
- MySQL 5.7+
- Servidor web com suporte a PHP (Apache ou Nginx)

## Integração

- Hotmart: Para gerenciamento de licenças e acesso premium
- Amazon Afiliados: Para venda de livros

## Continuidade do Desenvolvimento

### Estado Atual

O projeto está em fase inicial de estruturação, com foco na implementação da infraestrutura básica para suportar:
1. Sistema de autenticação de usuários
2. Verificação de licenças via Hotmart
3. Versões demo e premium das calculadoras
4. Página inicial com promoção de livros via Amazon Afiliados

### Arquivos Implementados

Até o momento, foram implementados os seguintes arquivos principais:

- **README.md**: Documentação principal do projeto
- **.htaccess**: Configurações de servidor para performance e segurança
- **config/config.php**: Configurações globais do sistema
- **includes/db.php**: Sistema de conexão com banco de dados otimizado
- **includes/functions.php**: Funções utilitárias do sistema
- **includes/header.php**: Cabeçalho padrão do site
- **includes/footer.php**: Rodapé padrão do site
- **index.php**: Página inicial com promoção de livros
- **auth/login.php**: Página de login
- **auth/login_process.php**: Processamento do login
- **auth/register.php**: Página de cadastro
- **calculadoras/index.php**: Página índice das calculadoras
- **calculadoras/demo/simulador.php**: Versão demo do simulador educacional
- **calculadoras/premium/simulador.php**: Versão premium do simulador educacional
- **api/hotmart_webhook.php**: Endpoint para gerenciamento de licenças via Hotmart

### Próximos Passos

1. **Fase de Estruturação**
   - [x] Configurar estrutura de diretórios
   - [x] Criar arquivos principais
   - [ ] Consolidar e otimizar arquivos CSS/JS existentes

2. **Fase de Desenvolvimento PHP**
   - [x] Implementar sistema de autenticação leve
   - [x] Desenvolver middlewares de verificação de acesso
   - [ ] Adaptar calculadoras para versões demo e premium (Simulador scaffolded)
   - [ ] Implementar integração Hotmart/Amazon (Webhook endpoint created)

3. **Fase de Banco de Dados**
   - [x] Criar esquema de banco de dados
   - [x] Implementar conexões otimizadas
   - [ ] Configurar consultas para relatórios

4. **Fase de Otimização**
   - [ ] Minificar CSS/JS
   - [ ] Otimizar imagens
   - [ ] Implementar cache
   - [x] Configurar .htaccess

5. **Fase de Conteúdo**
   - [x] Criar página inicial para livros
   - [ ] Desenvolver blog inicial
   - [ ] Escrever políticas de privacidade LGPD
   - [ ] Implementar depoimentos

6. **Fase de Testes**
   - [ ] Testar todas as calculadoras
   - [ ] Verificar responsividade
   - [ ] Testar sistema de autenticação
   - [ ] Validar integração Hotmart/Amazon

### Notas de Implementação

O sistema está sendo desenvolvido para ser executado em ambiente de servidor compartilhado da Hostinger, com especial atenção às otimizações de desempenho e segurança. A autenticação é mantida leve para minimizar o impacto em recursos do servidor.

O sistema foi projetado com conformidade LGPD em mente, coletando apenas o mínimo necessário de dados pessoais e implementando mecanismos adequados de consentimento explícito.

## Atualizações Recentes

- **28/04/2025**: Implementação de calculadoras demo/premium e webhook Hotmart
- **28/04/2025**: Implementação da estrutura básica do projeto e arquivos principais
- **27/04/2025**: Criação do repositório e definição da arquitetura
- **22/04/2025**: Análise das calculadoras originais e planejamento da conversão

## ⚠️ IMPORTANTE: CONTINUIDADE DO PROJETO ⚠️

**Este README deve ser mantido atualizado com o estado atual do desenvolvimento para facilitar a continuidade do projeto.**

Para os próximos passos, o foco deve ser:

1. - [ ] Adaptar calculadoras para versões demo e premium (Simulador scaffolded)
2. - [ ] Implementar integração Hotmart/Amazon (Webhook endpoint created)
3. - [ ] Desenvolver a funcionalidade de blog para SEO
4. - [ ] Finalizar o sistema de autenticação e perfil de usuário