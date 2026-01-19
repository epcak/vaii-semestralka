<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="articleheader">
    <div class="articleheaderimage" style="background-image: url('<?= $link->asset($uvodnyobrazok) ?>');"></div>
    <h1><?= $clanok->getTitle() ?></h1>
    <span>Článok napísal: </span><a href="<?= $link->url("profile.profile", ["name" => $clanok->getAuthor()]) ?>"><?= $clanok->getAuthor() ?></a>
    <span>Vytvorený: <?= $clanok->getCreated() ?></span>
    <span>Upravený: <?= $clanok->getEdited() ?></span>
</div>
<div class="secondarycolorcontainer">
    <div class="articlebody">
        <p><?= $clanok->getText() ?></p>
    </div>
</div>
<div class="articlefooter">
    <h2 class="gallerysectionname">Galéria</h3>
    <div class="gallerycontainer">
        <?php foreach($obrazky as $obrazok) {
            echo '<img src="<?= $link->asset(' . $obrazok->getLocation() . ') ?>" alt="' . $obrazok->getDescription() . '">';
        }
        ?>
    </div>
    <a class="buttons" href="<?= $link->url("article.comments", ["id" => $clanok->getId()]) ?>">Komentáre</a>
</div>