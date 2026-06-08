# Guia de Contribuição

Este guia define o padrão para evoluir o DomusFlow sem perder organização, segurança e consistência visual.

## Ambiente

Antes de contribuir:

1. Configure o projeto seguindo o [README](README.md).
2. Rode o sistema localmente pelo XAMPP.
3. Importe `database/migrations/domusflow_bd_prod.sql`.
4. Execute `database/seeds/seed.php` quando precisar recriar dados.
5. Nunca use credenciais reais em commits.

## Fluxo de Branches

Não trabalhe diretamente na `main`.

Use branches descritivas:

| Prefixo | Quando usar |
|---|---|
| `feature/` | Nova funcionalidade |
| `fix/` | Correção de bug |
| `css/` | Ajuste visual/responsivo |
| `docs/` | Documentação |
| `refactor/` | Organização sem mudar regra de negócio |

Exemplo:

```bash
git checkout main
git pull origin main
git checkout -b feature/dashboard-admin
```

## Commits

Use mensagens curtas e objetivas:

```text
feat: adiciona parametros de veiculos
fix: corrige bloqueio de usuario inativo
css: ajusta responsividade da gestao de moradores
docs: atualiza guia do projeto
refactor: separa javascript da tela de presencas
```

## Organização do Código

Siga o fluxo MVC:

```text
Controller -> Service -> Repository -> View
```

Responsabilidades:

| Camada | Responsabilidade |
|---|---|
| Controller | Receber requisição, validar acesso, chamar serviços e carregar views |
| Service | Regras de negócio |
| Repository | SQL e acesso ao banco |
| View | HTML/PHP de apresentação |
| public/css | Estilos globais ou por tela |
| public/js | Scripts globais ou por tela |

## CSS e JavaScript

- Evite CSS e JS inline dentro das views.
- Use `public/css/[tela].css` para estilos específicos.
- Use `public/js/[tela].js` para comportamento específico.
- Configure `$cssExtra`, `$cssTela` ou `$jsExtra` na view quando necessário.
- Use atributos `data-*` para ligar botões e elementos ao JavaScript.
- Mantenha responsividade em desktop e celular.
- Preserve o padrão visual do projeto.

## Segurança e LGPD

Ao alterar funcionalidades:

- Não exponha dados sensíveis desnecessários no front.
- Não remova anonimização da exclusão lógica.
- Não grave senha em texto puro.
- Não compare CPF/e-mail criptografado diretamente; use os hashes próprios.
- Alterações sensíveis devem pedir confirmação de senha quando já existir esse fluxo.
- Usuários com status diferente de liberado não devem acessar rotas protegidas.
- Valide regras importantes também no back-end, mesmo que exista validação no front.

## Banco de Dados e Seed

- Atualizações estruturais devem refletir em `database/migrations/domusflow_bd_prod.sql`.
- Dados de demonstração devem refletir em `database/seeds/seed.php`.
- O seed deve manter dados realistas para apresentação.
- Evite criar novas tabelas sem necessidade clara.

## Testes

Antes de abrir PR ou subir feature:

```bash
C:\xampp\php\php.exe vendor/bin/phpunit
```

Quando a alteração for pequena e localizada, rode pelo menos:

```bash
C:\xampp\php\php.exe -l caminho/do/arquivo.php
```

Para JavaScript:

```bash
node --check public/js/arquivo.js
```

## Checklist Antes de Subir

- A tela funciona no desktop.
- A tela funciona no celular.
- Não há JS/CSS inline novo sem necessidade.
- Não há credenciais reais no commit.
- As regras críticas foram validadas no back-end.
- O banco/seed foram atualizados se a mudança exigir.
- A documentação foi atualizada quando necessário.

## Pull Request

No PR, informe:

- O que foi alterado.
- Quais telas/módulos foram impactados.
- Quais validações foram feitas.
- Se houve alteração no banco ou seed.

Exemplo:

```text
Resumo:
- Ajusta dashboard administrativo.
- Remove dados operacionais desnecessários.
- Mantém layout responsivo.

Validação:
- php -l resources/views/dashboard/admin.php
- node --check public/js/dashboard.js
```
