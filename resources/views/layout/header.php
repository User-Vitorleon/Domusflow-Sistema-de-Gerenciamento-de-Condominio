<?php
$paginaTitulo = $paginaTitulo ?? 'DomusFlow';
$cssExtra     = $cssExtra     ?? null;
$cssTela      = $cssTela      ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($paginaTitulo) ?> — DomusFlow</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/img/logo_icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/app.css">
    <?php if ($cssExtra): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/<?= $cssExtra ?>">
    <?php endif; ?>
    <?php if ($cssTela): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/<?= $cssTela ?>">
    <?php endif; ?>
</head>

<body>