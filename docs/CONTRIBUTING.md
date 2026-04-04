# Como Usar o DomusFlow

Guia rápido para instalar, configurar e rodar o sistema localmente.

---

## Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) com Apache + MySQL rodando
- PHP 8.0 ou superior
- Git instalado

---

## 1. Clone o repositório

```bash
git clone https://github.com/User-Vitorleon/Domusflow-Sistema-de-Gerenciamento-de-Condominio.git
```

Mova a pasta para dentro de `C:/xampp/htdocs/`:

```
C:/xampp/htdocs/Domusflow_novo/
```

---

## 2. Configure o banco de dados

1. Abra o **phpMyAdmin** em `http://localhost/phpmyadmin`
2. Clique em **Importar**
3. Selecione o arquivo `database/migrations/domusflow_bd.sql`
4. Clique em **Executar**

---

## 3. Verifique as configurações

Abra `public/config/app.php` e confirme:

```php
define('BASE_URL', '/Domusflow_novo');
```

> Se o nome da sua pasta for diferente, ajuste o `BASE_URL` aqui.

Abra `public/config/database.php` e confirme usuário e senha do MySQL:

```php
$host = 'localhost';
$user = 'root';
$pass = '';         // padrão XAMPP é sem senha
```

---

## 4. Acesse o sistema

Com o XAMPP rodando, abra no navegador:

```
http://localhost/Domusflow_novo
```

---

## 5. Credenciais de acesso padrão

| Perfil | CPF | Senha |
|---|---|---|
| Síndico | `432.099.578-35` | `123456` |
| Morador (teste) | `117.604.018-97` | `123456` |

> Altere as senhas após o primeiro acesso em produção.

---

## 6. Fluxo básico

```
Login → Dashboard → Reservar local → Síndico aprova → Concluído
```

1. **Morador** se cadastra em `/cadastro`
2. **Síndico** aprova o cadastro em `/moradores/pendentes`
3. **Morador** faz login e realiza reservas em `/reserva`
4. **Síndico** aprova ou nega reservas

---

## 7. Estrutura resumida

```
Domusflow_novo/
├── public/          ← Entrada da aplicação (index.php, CSS, JS)
├── app/             ← Controllers, Models, Repositories, Services
├── resources/views/ ← Templates PHP (HTML)
└── database/        ← Scripts SQL
```

> Documentação técnica completa em [`README.md`](README.md)

---

## 8. Solução de problemas comuns

| Problema | Solução |
|---|---|
| Página em branco | Verifique se Apache e MySQL estão rodando no XAMPP |
| Erro de conexão com banco | Confirme usuário/senha em `database.php` |
| Acentos quebrados (`??`) | Reimporte o SQL via phpMyAdmin com charset UTF-8 |
| Rota não encontrada (404) | Verifique se `mod_rewrite` está ativo no Apache |
| `BASE_URL` errado | Ajuste em `public/config/app.php` com o nome exato da pasta |

---

## Ativar mod_rewrite no XAMPP

Abra `C:/xampp/apache/conf/httpd.conf`, localize e descomente:

```
LoadModule rewrite_module modules/mod_rewrite.so
```

E garanta que o `AllowOverride` esteja como `All`:

```apache
<Directory "C:/xampp/htdocs">
    AllowOverride All
</Directory>
```

Reinicie o Apache após a alteração.
