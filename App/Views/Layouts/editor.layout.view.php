<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?> - editor</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <script src="<?= $link->asset('js/editor.js') ?>"></script>
    <!-- Kod na pridanie fontu z: https://rsms.me/inter/ -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <!-- Koniec kodu na pridanie fontu -->
    <!-- Kod pre summernote z: https://summernote.org/ -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    
</head>
<body id="editor" onload=runeditor()>
    <header>
        <a href="<?= $link->url("create.index") ?>" id="editorvratitsa"><h2><-- Vrátiť sa späť</h2></a>
    </header>
    <?= $contentHTML ?>
    <footer>
        <p>© 2025 - Záujmový web</p>
    </footer>
</body>
</html>