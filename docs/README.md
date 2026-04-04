# DomusFlow — Documentação Técnica do Projeto

> Sistema de gestão de condomínio desenvolvido com PHP puro (sem framework), MySQL, Vue.js e Chart.js.
> Stack: XAMPP · PHP 8+ · PDO · Vue 3 · Chart.js · Boxicons

---

## 1. Arquitetura do Projeto

O projeto segue o padrão **MVC (Model-View-Controller)** com separação clara de responsabilidades em camadas. A estrutura foi organizada para facilitar manutenção, escalabilidade e legibilidade do código.

### 1.1 Estrutura de Diretórios

```
Domusflow_novo/
├── .htaccess                        ← Roteamento via mod_rewrite (XAMPP)
│
├── public/                          ← Front Controller (único ponto de entrada)
│   ├── index.php                    ← Inicializa app, sessão e rotas
│   ├── config/
│   │   ├── app.php                  ← Constantes globais (BASE_URL, timezone, APIs)
│   │   ├── database.php             ← Conexão PDO centralizada (getConnection())
│   │   └── routes.php               ← Mapeamento URI → Controller::método
│   ├── css/
│   │   ├── app.css                  ← Estilos globais (variáveis, sidebar, botões, forms)
│   │   ├── login.css                ← Estilos exclusivos da tela de login/home
│   │   ├── dashboard.css            ← Estilos exclusivos do dashboard (KPIs, gráfico)
│   │   └── pendente.css             ← Estilos exclusivos da tela de aprovação pendente
│   ├── js/
│   │   ├── app.js                   ← JS global (sidebar toggle, máscaras CPF/Tel)
│   │   ├── dashboard.js             ← Vue 3 + Chart.js do dashboard
│   │   ├── reserva.js               ← Capacidade do local + validação de feriado
│   │   └── pendente.js              ← Polling de aprovação a cada 10s
│   └── assets/
│       └── img/                     ← Imagens e ícones do sistema
│
├── app/
│   ├── controllers/
│   │   ├── HomeController.php       ← Tela de login (redireciona se já logado)
│   │   ├── AuthController.php       ← Login, logout, pendente, checar aprovação
│   │   ├── MoradorController.php    ← Cadastro, listagem, aprovação de moradores
│   │   ├── DashboardController.php  ← Dashboard principal + KPIs + feriado
│   │   ├── ReservaController.php    ← Reservas e cadastro de locais
│   │   └── FeriadoController.php    ← API de feriados (BrasilAPI)
│   │
│   ├── models/
│   │   ├── Morador.php              ← Entidade morador (getters, validações)
│   │   ├── Reserva.php              ← Entidade reserva
│   │   └── Local.php                ← Entidade local (salão, churrasqueira etc.)
│   │
│   ├── repositories/
│   │   ├── MoradorRepository.php    ← Todo SQL relacionado a moradores
│   │   ├── ReservaRepository.php    ← Todo SQL relacionado a reservas
│   │   └── LocalRepository.php      ← Todo SQL relacionado a locais
│   │
│   └── services/
│       ├── AuthService.php          ← Lógica de autenticação e sessão
│       ├── MoradorService.php       ← Regras de negócio de moradores
│       ├── ReservaService.php       ← Regras de negócio de reservas
│       ├── LocalService.php         ← Regras de negócio de locais
│       └── FeriadoService.php       ← Integração BrasilAPI + próximo feriado
│
├── resources/
│   └── views/
│       ├── layout/
│       │   ├── header.php           ← <head>, CSS global + CSS específico por página
│       │   ├── footer.php           ← Scripts JS global + JS específico por página
│       │   └── sidebar.php          ← Navegação lateral (inclusa nas páginas internas)
│       ├── home/index.php           ← Tela de login com hero e tagline
│       ├── cadastro/index.php       ← Cadastro de novo morador
│       ├── dashboard/index.php      ← Dashboard principal
│       ├── reserva/index.php        ← Formulário de reserva / cadastro de local
│       ├── moradores/pendentes.php  ← Aprovação de novos moradores (síndico)
│       └── pendente/index.php       ← Tela de aguardo de aprovação
│
└── database/
    └── migrations/                  ← Scripts SQL de criação das tabelas
```

---

## 2. Regras de Cada Camada (MVC)

| Camada | Responsabilidade | NUNCA deve conter |
|---|---|---|
| **Controller** | Recebe requisição HTTP, chama Service/Repository, passa dados à View | SQL direto, HTML, chamada direta a API externa |
| **Model** | Representa a entidade do banco (atributos, getters, `fromArray`) | SQL, lógica de negócio complexa |
| **Repository** | **Único lugar com SQL** no projeto — usa PDO | HTML, regras de negócio, chamadas a API |
| **Service** | Lógica de negócio, validações, chamadas a APIs externas | SQL direto, HTML |
| **View** | Apenas apresentação HTML + dados recebidos do Controller | SQL, lógica de negócio, `echo` de erros brutos |

---

## 3. Roteamento

O sistema usa um **Front Controller** (`public/index.php`) com roteamento via `.htaccess`. Todas as requisições são redirecionadas para `index.php`, que consulta `config/routes.php` e instancia o Controller correto.

### 3.1 public/index.php

```php
<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
session_start();
require_once __DIR__ . '/config/routes.php';
```

### 3.2 Tabela de Rotas

| URI | Controller | Método | Descrição |
|---|---|---|---|
| `/` | HomeController | index | Tela de login |
| `/login` | AuthController | login | Processa login (POST) |
| `/logout` | AuthController | logout | Encerra sessão |
| `/cadastro` | MoradorController | formCadastro | Formulário de cadastro |
| `/cadastro/salvar` | MoradorController | salvar | Salva novo morador (POST) |
| `/dashboard` | DashboardController | index | Dashboard principal |
| `/pendente` | AuthController | pendente | Tela de aguardo de aprovação |
| `/pendente/checar` | AuthController | checar | Retorna JSON `{aprovado: bool}` |
| `/reserva` | ReservaController | index | Formulário de reserva |
| `/reserva/salvar` | ReservaController | salvar | Salva reserva ou local (POST) |
| `/moradores/pendentes` | MoradorController | pendentes | Lista moradores pendentes (síndico) |
| `/moradores/liberar` | MoradorController | liberar | Aceita ou nega morador (POST) |
| `/api/feriados` | FeriadoController | index | Retorna JSON de feriados do ano |

### 3.3 Adicionando Nova Rota

```php
// public/config/routes.php
$routes['nome-da-rota'] = ['NomeController', 'nomeMetodo'];
```

Crie o Controller em `app/controllers/NomeController.php` e o método correspondente.

---

## 4. Configurações Globais

### 4.1 public/config/app.php

```php
<?php
date_default_timezone_set('America/Sao_Paulo'); // fuso horário Brasil

define('BASE_URL',             '/Domusflow_novo');
define('BRASIL_API_FERIADOS',  'https://brasilapi.com.br/api/feriados/v1/');
```

### 4.2 public/config/database.php

```php
<?php
function getConnection(): PDO {
    $dsn = "mysql:host=localhost;dbname=domusflow_bd;charset=utf8mb4";
    return new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
    ]);
}
```

> ⚠️ O `SET NAMES utf8mb4` é obrigatório para exibir corretamente acentos (ã, ç, é etc.)

---

## 5. Carregamento de CSS e JS por Página

Cada view define variáveis antes do `header.php`:

```php
<?php
$paginaTitulo = 'Nome da Página';   // título na aba do navegador
$paginaAtiva  = 'chave-menu';       // destaca item ativo na sidebar
$cssExtra     = 'nome.css';         // CSS específico desta página (opcional)
$jsExtra      = 'nome.js';          // JS específico desta página (opcional)
require_once __DIR__ . '/../layout/header.php';
```

### 5.1 Tabela de CSS e JS por Página

| Página | `$paginaAtiva` | CSS extra | JS extra |
|---|---|---|---|
| Login (`home/index.php`) | — | `login.css` | — |
| Cadastro (`cadastro/index.php`) | — | — | — |
| Dashboard (`dashboard/index.php`) | `dashboard` | `dashboard.css` | `dashboard.js` |
| Reserva (`reserva/index.php`) | `reserva` | — | `reserva.js` |
| Pendente (`pendente/index.php`) | — | `pendente.css` | `pendente.js` |
| Moradores (`moradores/pendentes.php`) | `moradores` | — | — |

---

## 6. Design System — Paleta Oficial DomusFlow

### 6.1 Cores Primárias (Brand Core)

| Nome | Hex | Variável CSS | Uso |
|---|---|---|---|
| Primary Dark | `#11446E` | `--primary-dark` | Sidebar, fundo do login, textos em destaque |
| Primary | `#0F80B6` | `--primary` | Botões principais, links, bordas de foco |
| Primary Light | `#0E9FD1` | `--primary-light` | Hover de links, badges, ícones |

### 6.2 Cores Secundárias

| Nome | Hex | Variável CSS | Uso |
|---|---|---|---|
| Secondary Dark | `#41627C` | `--secondary-dark` | Textos de apoio, ícones inativos |
| Secondary Light | `#88B1C3` | `--secondary-light` | Bordas de cards, séries de gráficos |

### 6.3 Neutros

| Nome | Hex | Variável CSS | Uso |
|---|---|---|---|
| White | `#FFFFFF` | `--white` | Fundo de cards e formulários |
| Light Gray | `#F5F7FA` | `--bg` | Fundo geral da aplicação |
| Medium Gray | `#D1D5DB` | `--border` | Bordas, divisores |
| Dark Gray | `#374151` | `--text-muted` | Texto secundário, placeholders |
| Black Soft | `#111827` | `--text` | Texto principal |

### 6.4 Cores de Estado

| Nome | Hex | Variável CSS | Uso |
|---|---|---|---|
| Success | `#22C55E` | `--success` | Confirmações, status liberado |
| Warning | `#F59E0B` | `--warning` | Alertas, feriados, atenção |
| Error | `#EF4444` | `--error` | Erros, status bloqueado |
| Info | `#3B82F6` | `--info` | Informativos neutros |

### 6.5 Gradiente Oficial

```css
background: linear-gradient(135deg, #11446E, #0E9FD1);
```

Usado em: botões primários, brand icon da sidebar, elementos de destaque.

---

## 7. Componentes CSS Padrão

### 7.1 Botões

```html
<button class="btn-primary">Salvar</button>
<button class="btn-ghost">Cancelar</button>
<button class="btn-success-sm">Aceitar</button>
<button class="btn-danger-sm">Negar</button>
```

### 7.2 Alertas

```html
<div class="df-alert df-alert-success">Operação realizada com sucesso!</div>
<div class="df-alert df-alert-error">CPF já cadastrado.</div>
<div class="df-alert df-alert-warning">Atenção: esta data é feriado.</div>
```

### 7.3 Formulários

```html
<div class="df-field">
    <label>Nome Completo</label>
    <input type="text" name="nome" placeholder="João Silva" required>
</div>

<div class="df-grid-2">
    <div class="df-field">...</div>
    <div class="df-field">...</div>
</div>

<div class="df-grid-3">
    <div class="df-field">...</div>
    <div class="df-field">...</div>
    <div class="df-field">...</div>
</div>

<div class="df-actions">
    <button class="btn-ghost">Cancelar</button>
    <button class="btn-primary">Salvar</button>
</div>
```

### 7.4 Cards

```html
<div class="df-card">
    <div class="df-card-header">
        <h4>Título do Card</h4>
        <p>Descrição opcional</p>
    </div>
    <!-- conteúdo -->
</div>
```

### 7.5 Empty State

```html
<div class="empty-state">
    <i class='bx bx-check-shield'></i>
    <h5>Tudo em dia!</h5>
    <p>Nenhum item encontrado no momento.</p>
</div>
```

---

## 8. Tipografia

A fonte padrão é a **SF Pro** (Apple System Font):

```css
--font: -apple-system, BlinkMacSystemFont, "SF Pro Display",
        "SF Pro Text", "Helvetica Neue", Arial, sans-serif;
```

| Elemento | Tamanho | Peso |
|---|---|---|
| Título de página (`h2`) | 22px | 700 |
| Título de card (`h4`) | 20px | 700 |
| Tagline login | 32px | 800 |
| Corpo / label | 15px / 13px | 400 / 500 |
| Label KPI | 11px uppercase | 600 |
| Valor KPI | 28px | 700 |
| Texto auxiliar / muted | 13–14px | 400 |

---

## 9. FeriadoService — Próximo Feriado

Localização: `app/services/FeriadoService.php`

```php
$feriadoService = new FeriadoService();
$proximoFeriado = $feriadoService->getProximoFeriado();
// Retorna: ['name', 'date', 'data_formatada', 'dias_restantes']
```

- Usa a **BrasilAPI** para buscar feriados nacionais do ano atual
- Se não houver feriados restantes no ano, busca o primeiro do próximo ano
- Calcula automaticamente `dias_restantes` com base em `date('Y-m-d')` no fuso `America/Sao_Paulo`
- Exibido como **4º KPI card** no dashboard

---

## 10. Sidebar — Comportamento

Localização: `resources/views/layout/sidebar.php`

- **Toggle:** clique no ícone `bx-menu` recolhe/expande via classe `.close`
- **Link ativo:** definido pela variável `$paginaAtiva` na view + reforçado por JS via URL
- **Pointer-events:** `nav-link a * { pointer-events: none }` garante que elementos filhos (`<span>`, `<i>`) não bloqueiem o clique no link
- **Mobile:** sidebar inicia recolhida; fecha ao clicar fora

---

## 11. JavaScript Global — app.js

Localização: `public/js/app.js`

| Funcionalidade | Descrição |
|---|---|
| Sidebar toggle | `e.stopPropagation()` no botão toggle evita conflito com links |
| Fechar no mobile | Clique fora do sidebar fecha automaticamente em telas < 768px |
| Nav-link ativo | Detecta URL atual e aplica `.active` automaticamente |
| Máscara CPF | Aplicada em `#user_cpf` e `input[name="cpf"]` |
| Máscara Telefone | Aplicada em `input[name="user_cell"]` e `input[name="user_recado"]` |

---

## 12. Tela de Login — Estrutura

Localização: `resources/views/home/index.php`

| Coluna | Conteúdo |
|---|---|
| `.login-left` (400px) | Logo, formulário CPF/Senha, link para cadastro |
| `.login-right` (flex: 1) | Imagem hero (`DomusFlow.png`), eyebrow, tagline, subtítulo, badges |

**Elementos da tagline:**
- `.login-tagline-eyebrow` — pílula "Condomínio inteligente"
- `.login-tagline` — título 32px bold com `.login-tagline-accent` sublinhado gradiente
- `.login-tagline-sub` — descrição curta do sistema
- `.login-badges` — 3 badges: Reservas online · Gestão de moradores · Aprovação rápida

---

## 13. Banco de Dados

### 13.1 Configurações obrigatórias

```sql
CREATE DATABASE domusflow_bd
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Todas as tabelas e colunas devem usar `CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci`.

### 13.2 Tabelas

| Tabela | Descrição |
|---|---|
| `morador` | Usuários do sistema (moradores e síndico) |
| `locais_festivos` | Espaços disponíveis para reserva |
| `reservas` | Reservas de locais pelos moradores |

### 13.3 Status e Flags

| Tabela | Campo | Valores |
|---|---|---|
| `morador` | `status` | `P`=Pendente · `L`=Liberado · `B`=Bloqueado |
| `morador` | `previlegio` | `1`=Morador · `2`=Síndico |
| `morador` | `sexo` | `M`=Masculino · `F`=Feminino |
| `locais_festivos` | `disp_uso` | `S`=Disponível · `N`=Indisponível |
| `reservas` | `status` | `P`=Pendente · `A`=Aprovada · `N`=Negada |

---

## 14. Segurança

| Prática | Implementação |
|---|---|
| Senhas | `password_hash()` no cadastro · `password_verify()` no login |
| SQL Injection | PDO com prepared statements em todos os repositories |
| XSS | `htmlspecialchars()` em todos os outputs nas views |
| Encoding | `SET NAMES utf8mb4` na conexão PDO + `charset=utf8mb4` no DSN |
| Controle de acesso | Verificação de `$_SESSION['usuario_id']` em todos os controllers internos |
| Permissão síndico | `previlegio == 2` verificado antes de ações administrativas |

---

## 15. Níveis de Acesso

| Nível | `previlegio` | `status` | Permissões |
|---|---|---|---|
| Morador | `1` | `L` | Dashboard, reservar locais |
| Síndico | `2` | `L` | Tudo + aprovar moradores + cadastrar locais |
| Pendente | qualquer | `P` | Apenas tela de aguardo |
| Bloqueado | qualquer | `B` | Acesso negado |

---

## 16. Convenções de Código

### PHP
- Classes em **PascalCase**: `MoradorRepository`, `AuthService`
- Métodos em **camelCase**: `findByCpf()`, `listarPendentes()`
- Variáveis em **snake_case**: `$id_logado`, `$dados_usuario`
- Um arquivo por classe
- Todo SQL **exclusivamente** nos `Repository`

### JavaScript
- Arquivos encapsulados em **IIFE**: `(function(){ 'use strict'; })()`
- Dados do PHP → JS via `window.APP_*` (ex: `window.APP_DASHBOARD`)
- Nunca escrever SQL ou lógica de negócio em arquivos `.js`
- Vue.js e Chart.js **somente** em `public/js/`

### CSS
- Variáveis sempre via `var(--nome-variavel)`
- **Nunca** usar valores de cor ou espaçamento hardcoded
- Classes seguem prefixo `df-` para componentes DomusFlow
- CSS global → `app.css` · CSS específico → arquivo da respectiva página
- `pointer-events: none` em filhos de links para garantir clicabilidade

---

## 17. Como Adicionar Nova Funcionalidade

1. **Criar rota** em `public/config/routes.php`
2. **Criar Controller** em `app/controllers/`
3. **Criar Service** em `app/services/` (lógica de negócio)
4. **Criar Repository** em `app/repositories/` (SQL)
5. **Criar Model** em `app/models/` (entidade)
6. **Criar View** em `resources/views/nome-funcionalidade/`
7. **Criar CSS** em `public/css/nome.css` (se necessário)
8. **Criar JS** em `public/js/nome.js` (se necessário)
9. Definir `$paginaTitulo`, `$paginaAtiva`, `$cssExtra`, `$jsExtra` no topo da view

---

## 18. Dependências e CDNs

| Biblioteca | Versão | Uso | CDN |
|---|---|---|---|
| Boxicons | 2.1.4 | Ícones da sidebar e interface | unpkg |
| Vue.js | 3 (prod) | Reatividade no dashboard | jsDelivr |
| Chart.js | latest | Gráficos do dashboard | jsDelivr |

> Bootstrap foi **removido** da stack — o projeto usa CSS próprio com Design System DomusFlow.
