<?php

/** @var string $contentHTML */
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \Framework\Support\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?> - administrácia</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <script src="<?= $link->asset('js/admin.js') ?>"></script>
    <!-- Kod na pridanie fontu z: https://rsms.me/inter/ -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <!-- Koniec kodu na pridanie fontu -->
</head>
<body class="administration">
    <header>
        <a href="<?= $link->url("home.index") ?>" id="adminspatnaweb"><h2>Vrátiť sa na web</h2><img src="/images/logo.png" alt=""></a>
        <a href="<?= $link->url("admin.index") ?>"><h2>Administratorský web</h2></a>
    </header>
    <?= $contentHTML ?>
</body>
</html>