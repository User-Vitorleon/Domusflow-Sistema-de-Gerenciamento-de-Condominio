<?php

declare(strict_types=1);

$root = realpath(__DIR__ . '/..');
$excluir = ['vendor', 'node_modules', '.git', 'scripts', 'tests'];

function stripPhp(string $src): string
{
    $tokens = token_get_all($src);
    $out = '';
    foreach ($tokens as $tok) {
        if (is_array($tok)) {
            [$id, $text] = $tok;
            if ($id === T_COMMENT || $id === T_DOC_COMMENT) {
                if (str_contains($text, "\n")) {
                    $out .= "\n";
                }
                continue;
            }
            $out .= $text;
        } else {
            $out .= $tok;
        }
    }
    $out = preg_replace("/\n[ \t]+\n/", "\n\n", $out);
    $out = preg_replace("/\n{3,}/", "\n\n", $out);
    return $out;
}

function stripCss(string $src): string
{
    $src = preg_replace('!/\*.*?\*/!s', '', $src);
    return preg_replace("/\n{3,}/", "\n\n", $src);
}

function stripJs(string $src): string
{
    $out = '';
    $len = strlen($src);
    $i = 0;
    $inSingle = false;
    $inDouble = false;
    $inTemplate = false;
    $inRegex = false;
    $prevSignificant = '';
    while ($i < $len) {
        $c = $src[$i];
        $n = $i + 1 < $len ? $src[$i + 1] : '';

        if (!$inSingle && !$inDouble && !$inTemplate && !$inRegex) {
            if ($c === '/' && $n === '/') {
                while ($i < $len && $src[$i] !== "\n") {
                    $i++;
                }
                continue;
            }
            if ($c === '/' && $n === '*') {
                $end = strpos($src, '*/', $i + 2);
                if ($end === false) { break; }
                $block = substr($src, $i, $end - $i + 2);
                if (str_contains($block, "\n")) { $out .= "\n"; }
                $i = $end + 2;
                continue;
            }
        }

        if (!$inDouble && !$inTemplate && !$inRegex && $c === "'") {
            if ($i === 0 || $src[$i - 1] !== '\\') {
                $inSingle = !$inSingle;
            }
        } elseif (!$inSingle && !$inTemplate && !$inRegex && $c === '"') {
            if ($i === 0 || $src[$i - 1] !== '\\') {
                $inDouble = !$inDouble;
            }
        } elseif (!$inSingle && !$inDouble && !$inRegex && $c === '`') {
            if ($i === 0 || $src[$i - 1] !== '\\') {
                $inTemplate = !$inTemplate;
            }
        }

        $out .= $c;
        $i++;
    }
    $out = preg_replace("/\n[ \t]+\n/", "\n\n", $out);
    $out = preg_replace("/\n{3,}/", "\n\n", $out);
    return $out;
}

function stripSql(string $src): string
{
    $src = preg_replace('!/\*.*?\*/!s', '', $src);
    $src = preg_replace('/^\s*--.*$/m', '', $src);
    $src = preg_replace('/\s+--\s.*$/m', '', $src);
    return preg_replace("/\n{3,}/", "\n\n", $src);
}

function stripHtmlInPhp(string $src): string
{
    return preg_replace('/<!--(?!\[if|<!\[endif).*?-->/s', '', $src);
}

function listar(string $dir, array $exclude): array
{
    $arquivos = [];
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
        $path = $f->getPathname();
        foreach ($exclude as $ex) {
            if (str_contains(str_replace('\\', '/', $path), '/' . $ex . '/')) {
                continue 2;
            }
        }
        $arquivos[] = $path;
    }
    return $arquivos;
}

$total = 0;
foreach (listar($root, $excluir) as $arquivo) {
    $ext = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
    $conteudo = file_get_contents($arquivo);
    if ($conteudo === false) { continue; }
    $novo = match ($ext) {
        'php'  => stripHtmlInPhp(stripPhp($conteudo)),
        'js'   => stripJs($conteudo),
        'css'  => stripCss($conteudo),
        'sql'  => stripSql($conteudo),
        'html' => stripHtmlInPhp($conteudo),
        default => null,
    };
    if ($novo !== null && $novo !== $conteudo) {
        file_put_contents($arquivo, $novo);
        echo "limpo: $arquivo\n";
        $total++;
    }
}
echo "\nTotal de arquivos modificados: $total\n";
