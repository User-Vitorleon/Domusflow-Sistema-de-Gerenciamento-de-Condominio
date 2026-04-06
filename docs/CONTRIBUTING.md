# DomusFlow — Guia de Instalação

## Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) com Apache + MySQL rodando
- PHP 8.0 ou superior
- Git instalado

***

## 1. Clone o repositório

Clone diretamente dentro de `htdocs/` na branch principal:

```bash
git clone -b feature/ui-redesign-v2 https://github.com/User-Vitorleon/Domusflow-Sistema-de-Gerenciamento-de-Condominio.git .
```

***

## 2. Importe o banco de dados

1. Acesse `http://localhost/phpmyadmin`
2. Clique em **Importar**
3. Selecione `database/domusflow_bd.sql`
4. Clique em **Executar**

***

## 3. Configure os arquivos

**`config/app.php`** — ajuste o `BASE_URL` com o nome exato da sua pasta:

```php
define('BASE_URL', '/Domusflow_novo');
```

**`config/database.php`** — confirme as credenciais do MySQL:

```php
$host = 'localhost';
$user = 'root';
$pass = ''; // padrão XAMPP
```

***

## 4. Gere os hashes de senha

Acesse no navegador:

```
http://localhost/Domusflow_novo/setup.php
```

> **Apague o `setup.php` após executar.**

***

## 5. Acesse o sistema

```
http://localhost/Domusflow_novo
```

***

## Credenciais padrão

| Perfil   | CPF              | Senha  | Privilégio |
|----------|------------------|--------|------------|
| Admin    | `000.000.000-00` | `123456` | 4 |
| Síndico  | `432.099.578-35` | `123456` | 2 |
| Porteiro | `111.111.111-11` | `123456` | 3 |
| Morador  | `117.604.018-97` | `123456` | 1 |

> APENAS PARA TESTES !

***