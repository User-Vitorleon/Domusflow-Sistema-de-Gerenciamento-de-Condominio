# DomusFlow

Sistema de gerenciamento de condomínio desenvolvido com **PHP puro**, **PDO** e **MySQL**, seguindo arquitetura **MVC** e rodando localmente com **XAMPP**.

---

## Stack

- PHP 8+
- MySQL / MariaDB + PDO
- JavaScript + Chart.js
- Bootstrap 5
- Boxicons
- XAMPP

---

## Como rodar

1. Clone dentro de `C:/xampp/htdocs/`
2. Importe `database/migrations/domusflow_bd.sql` no phpMyAdmin
3. Importe `database/migrations/domusflow_seed.sql` para popular o banco com dados de exemplo
4. Ajuste `BASE_URL` em `config/app.php`
5. Confira a conexão em `config/database.php`
6. Execute `http://localhost/Domusflow-Sistema-de-Gerenciamento-de-Condominio/setup.php`
7. **Apague o `setup.php`** após executar
8. Acesse `http://localhost/Domusflow-Sistema-de-Gerenciamento-de-Condominio`

---

## Usuários padrão

| Perfil | Privilégio | CPF | Senha |
|---|:---:|---|---|
| Admin | 4 | `000.000.000-00` | `123456` |
| Síndico | 2 | `432.099.578-35` | `123456` |
| Porteiro | 3 | `111.111.111-11` | `123456` |
| Morador | 1 | `117.604.018-97` | `123456` |

---

## Perfis de acesso

| Perfil | Acesso |
|---|---|
| **Morador** `1` | Dashboards, veículos (próprios, máx. 2), reservas, atualizar dados |
| **Síndico** `2` | Dashboards, veículos, reservas, aprovação de moradores, dashboard |
| **Porteiro** `3` | Dashboards, vonsulta de veículo por placa, atualizar dados |
| **Admin** `4` | Acesso total |

---

## Módulos

- **Autenticação** — login por CPF + senha, controle por perfil
- **Moradores** — cadastro com aprovação pelo síndico/admin
- **Veículos** — cadastro (máx. 2 por morador), consulta por placa, veículo principal
- **Reservas** — solicitação e gestão de espaços comuns
- **Dashboard** — indicadores do condomínio
- **Parâmetros** — configurações gerais (em desenvolvimento)

---

## Estrutura

```text
├── app/
│   ├── controllers/
│   ├── models/
│   ├── repositories/
│   └── services/
├── config/
│   ├── app.php
│   ├── database.php
│   └── routes.php
├── database/migrations/
├── public/
│   ├── css/        → app.css, header.css, painel.css, [tela].css
│   ├── js/         → [tela].js
│   └── assets/img/
├── resources/views/
└── index.php
```

**Fluxo MVC:**
`controller` → recebe requisição → `service` → regra de negócio → `repository` → SQL → `view` → interface

---

## Banco de dados

| Tabela | Descrição |
|---|---|
| `morador` | Usuários do sistema |
| `veiculos` | Veículos dos moradores |
| `reservas` | Reservas de espaços |
| `locais_festivos` | Espaços disponíveis para reserva |

Campo `previlegio`: `1` Morador · `2` Síndico · `3` Funcionário · `4` Admin