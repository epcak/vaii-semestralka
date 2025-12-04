<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <!-- Kod na pridanie fontu z: https://rsms.me/inter/ -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <!-- Koniec kodu na pridanie fontu -->
</head>
<body>
    <header>
        <nav>
            <a id="logonav" href="#"><img src="<?= $link->asset('images/logo.png') ?>" alt="logo zauj*web"></a>
            <div id="navsetion">
                <a class="sectiontab" href="#">Top</a>
                <a class="sectiontab" href="#">Najnovšie</a>
                <a class="sectiontab" href="#">Populárne</a>
            </div>
            <div id="navtools">
                <div id="search"><a href=""><img src="<?= $link->asset('images/search.svg') ?>" alt="Vyhľadávanie"></a></div>
                <?php if (false) { ?>
                    <a class="buttons" href="#"><?= $auth?->user?->name ?></a>
                <?php } else { ?>
                    <a class="buttons" href="<?= App\Configuration::LOGIN_URL ?>">Prihlásiť sa</a>
                <?php } ?>
            </div>
        </nav>
    <header>
    <?= $contentHTML ?>
    <footer>
        <p>© 2025 - Záujmový web</p>
    </footer>
</body>
</html>
