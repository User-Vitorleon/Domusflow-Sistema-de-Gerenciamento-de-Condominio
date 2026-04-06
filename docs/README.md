# DomusFlow

Sistema de gerenciamento de condomínio desenvolvido com **PHP puro**, **PDO** e **MySQL**.  
O projeto segue uma estrutura simples em **MVC** e roda localmente com **XAMPP** [file:41].

---

## stack

- php 8+
- mysql / mariadb
- pdo
- xampp
- javascript
- chart.js
- vue 3
- boxicons [file:41]

---

## como rodar

1. clone o projeto dentro de `C:/xampp/htdocs/`
2. importe o banco `database/migrations/domusflow_bd.sql` no phpMyAdmin
3. ajuste o `BASE_URL` em `config/app.php`
4. confira a conexão em `config/database.php`
5. acesse `http://localhost/Domusflow_novo/setup.php`
6. apague o `setup.php`
7. abra `http://localhost/Domusflow_novo`

---

## usuários padrão

| perfil | privilégio | login | senha |
|---|---:|---|---|
| admin | 4 | `000.000.000-00` | `123456` |
| síndico | 2 | `432.099.578-35` | `123456` |
| porteiro | 3 | `111.111.111-11` | `123456` |
| morador | 1 | `117.604.018-97` | `123456` |

> após importar o banco, execute o `setup.php` para gerar os hashes corretamente na máquina local.

---

## módulos principais

- autenticação com controle por perfil [file:41]
- cadastro e aprovação de moradores [file:41]
- reservas de locais [file:41]
- dashboard com indicadores [file:41]
- controle de veículos:
  - cadastro de veículos
  - consulta por placa
  - visualização por perfil [file:41]

---

## perfis de acesso

| perfil | acesso principal |
|---|---|
| morador | dashboard, reservas e visualização dos próprios veículos |
| síndico | dashboard, reservas, aprovação de moradores e veículos |
| porteiro | dashboard, cadastro de veículos e consulta por placa |
| admin | acesso total ao sistema |

---

## estrutura

```text
Domusflow_novo/
├── app/
│   ├── controllers/
│   ├── models/
│   ├── repositories/
│   └── services/
├── config/
│   ├── app.php
│   ├── database.php
│   └── routes.php
├── database/
│   └── migrations/
├── public/
│   ├── css/
│   ├── js/
│   └── assets/
├── resources/
│   └── views/
├── docs/
└── index.php
```

A regra do projeto é simples:
- `controller` recebe a requisição
- `service` trata a lógica
- `repository` faz o sql
- `view` mostra a interface

---

## banco de dados

Tabelas principais:

- `morador`
- `locais_festivos`
- `reservas`
- `veiculos` 

O campo `previlegio` usa:
- `1` = morador
- `2` = síndico
- `3` = porteiro
- `4` = admin

---

## padrão de arquivos

- css global em `public/css/app.css`
- js global em `public/js/app.js`
- css e js específicos por página em arquivos separados
- sql apenas nos `repositories`

## observação

Este projeto foi desenvolvido com foco acadêmico, usando código simples, organizado e fácil de manter [file:41].