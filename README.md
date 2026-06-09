# DomusFlow

Sistema de gerenciamento de condomínio desenvolvido em **PHP**, **PDO** e **MySQL/MariaDB**, com arquitetura MVC, execução local via **XAMPP** e módulos voltados à rotina operacional de moradores, síndicos, porteiros e administradores.

## Stack

- PHP 8+
- MySQL/MariaDB
- PDO
- Composer
- PHPMailer
- JavaScript
- Bootstrap 5
- Chart.js
- Boxicons
- PHPUnit

## Como Rodar Localmente

1. Clone o projeto dentro de `C:/xampp/htdocs/`.
2. Instale as dependências:

```bash
composer install
```

3. Crie o banco pelo arquivo:

```text
database/migrations/domusflow_bd_prod.sql
```

4. Configure o arquivo `.env` com URL, timezone, hash salt e SMTP.
5. Confira a conexão em `config/database.php`.
6. Povoe o banco com:

```bash
C:\xampp\php\php.exe database/seeds/seed.php
```

7. Acesse:

```text
http://localhost/Domusflow-Sistema-de-Gerenciamento-de-Condominio
```

## Usuários Padrão do Seed

Todas as senhas do seed são `123456`.

| Perfil | Nome | CPF | Senha |
|---|---|---|---|
| Admin | Admin Principal | `00000000000` | `123456` |
| Admin | Admin Reserva | `99999999999` | `123456` |
| Síndico | Vitor Leon | `43209957835` | `123456` |
| Síndico | Mariana Alves | `98765432100` | `123456` |
| Porteiro | Carlos Lima | `11111111111` | `123456` |
| Porteiro | Eduardo Moreira | `22222222222` | `123456` |

O seed também imprime ao final um usuário-chave de cada perfil, incluindo um morador gerado dinamicamente. Além disso, popula 1000 moradores, veículos, reservas, ocorrências, assembleias, avisos, auditoria e dados financeiros para simular um condomínio real.

## Perfis de Acesso

| Privilégio | Perfil | Acesso principal |
|:---:|---|---|
| `1` | Morador | Reservas, ocorrências, financeiro, assembleias, avisos, veículos próprios e atualização cadastral |
| `2` | Síndico | Gestão operacional de moradores, reservas, ocorrências, avisos, assembleias, veículos e financeiro |
| `3` | Porteiro | Consulta operacional, principalmente veículos e informações de apoio |
| `4` | Admin | Gestão total do sistema, parâmetros, moradores, financeiro, reservas e dashboards administrativos |

## Módulos

- **Autenticação**: login por CPF e senha, controle de sessão e bloqueio por status.
- **Cadastro**: validação de CPF, regras de bloco/apartamento e aprovação de novos usuários.
- **Moradores**: gestão de privilégios, status, unidade, recusa, bloqueio, inativação e exclusão lógica com anonimização.
- **Veículos**: cadastro, limite parametrizado, veículo principal, catálogo de marcas/modelos de carros e motos, filtros e consulta por placa.
- **Reservas**: locais, solicitações pendentes, histórico do morador, aprovação, recusa e limpeza de reservas pendentes vencidas.
- **Financeiro**: taxas/multas padrão, lançamentos, faturas, filtros e confirmação por senha.
- **Ocorrências**: abertura, painel de gestão, tramitação, status, fotos e histórico.
- **Assembleias**: convocação, presença e painel de presenças.
- **Avisos**: publicação e remoção de comunicados.
- **Parâmetros**: limite de moradores ativos, limite de veículos por morador e regra de reserva pendente.
- **Dashboard**: visões por perfil com indicadores operacionais e próximos feriados via BrasilAPI.

## LGPD e Segurança

- Nome, CPF, e-mail e telefones são criptografados no banco.
- CPF e e-mail possuem hash técnico para busca e validação sem expor o valor original.
- Senhas são armazenadas com hash seguro via `password_hash`.
- Exclusão de morador é lógica, com anonimização dos dados pessoais e substituição visual por `***`.
- Usuários inativos, bloqueados ou excluídos são impedidos de continuar usando o sistema na próxima requisição protegida.
- Alterações administrativas sensíveis usam confirmação de senha.
- Contas administrativas são protegidas contra bloqueio, inativação, exclusão, reset de senha e alteração de privilégio por outro admin.

## Estrutura

```text
app/
  controllers/
  middleware/
  models/
  repositories/
  services/
config/
  database.php
  routes.php
database/
  migrations/
  seeds/
public/
  css/
  js/
  assets/
resources/
  views/
tests/
docs/
index.php
```

## Testes

Execute os testes com:

```bash
C:\xampp\php\php.exe vendor/bin/phpunit
```

ou, se estiver usando o `phpunit.phar`:

```bash
C:\xampp\php\php.exe phpunit.phar
```

## Observações

- Não versionar credenciais reais.
- Em hospedagem gratuita, ajuste `config/database.php` e `.env` conforme os dados do provedor.
- O arquivo `.env.exemple` deve ser usado como referência para novas instalações.
