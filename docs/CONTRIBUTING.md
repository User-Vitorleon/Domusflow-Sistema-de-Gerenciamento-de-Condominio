# DomusFlow — Guia de Contribuição

## Colaboradores

| Colaborador | Papel |
|---|---|
| **Vitor Leon** | Maintainer — aprova e merga PRs na `main` |
| **Victor Nogueira** | Contribuidor — abre `feature/` e PR para revisão |

---

## Ambiente de desenvolvimento

Consulte o [Guia de Instalação](README.md) para configurar o XAMPP, importar o banco e rodar o projeto localmente antes de contribuir.

---

## Fluxo de branches

A branch principal é a `main`. Nunca commite diretamente nela.

```
main
 └── feature/nome-da-funcionalidade   ← você trabalha aqui
```

### Nomeando sua branch

| Prefixo | Uso |
|---|---|
| `feature/` | Nova funcionalidade |
| `fix/` | Correção de bug |
| `css/` | Ajustes de estilo |
| `docs/` | Documentação |

```bash
# Criar e entrar na branch
git checkout main
git pull origin main
git checkout -b feature/modulo-visitantes
```

---

## Padrão de commits

Use mensagens curtas e descritivas no infinitivo:

```
feat: adiciona cadastro de visitante
fix: corrige validação de CPF duplicado
css: ajusta layout da tabela de moradores
docs: atualiza guia de instalação
```

---

## Estrutura de arquivos

| Caminho | O que vai aqui |
|---|---|
| `public/css/app.css` | CSS global |
| `public/css/[tela].css` | CSS por tela |
| `public/js/[tela].js` | JS por tela |
| `repositories/` | Queries SQL |
| `services/` | Lógica de negócio |
| `config/` | Configurações (não versionar credenciais) |

---

## Perfis de acesso

| Valor | Perfil | Descrição |
|:---:|---|---|
| `1` | Morador | Acesso básico |
| `2` | Síndico | Gestão do condomínio |
| `3` | Funcionários | Consultas operacionais |
| `4` | Admin | Acesso total |

---

## Boas práticas

- Nunca suba `config/database.php` com credenciais reais
- Apague `setup.php` após gerar os hashes de senha
- Teste localmente antes de abrir o PR
- Mantenha uma `feature/` por funcionalidade — não misture mudanças não relacionadas
