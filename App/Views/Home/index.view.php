<?php

/** @var \Framework\Support\LinkGenerator $link */

$pocetclankov = sizeof($clanky);
$maxdruha = 5;
$maxprva = 1;
if ($maxprva > $pocetclankov) $maxprva = 0;
$maxtretia = $pocetclankov;
if ($pocetclankov < $maxdruha) $maxdruha = $pocetclankov;
?>

<div class="primarypreview">
    <?php for($i = 0; $i < $maxprva; $i++): ?>
    <a href="<?= $link->url("article.index", ["id" => $clanky[$i]->getId()]) ?>"><img src="<?= $link->asset($obrazky[$i]) ?>" alt="náhľad článku"></a>
    <div class="primarypreviewtext">
        <a href="<?= $link->url("article.index", ["id" => $clanky[$i]->getId()]) ?>"><h2><?= $clanky[$i]->getTitle() ?></h2></a>
        <p><?= mb_substr($clanky[$i]->getText(), 0, 400) ?>...</p>
    </div>
    <?php endfor; ?>
</div>
<div class="secondarycategorycontainer">
    <div class="secondarypreviews">
        <?php for($i = 1; $i < $maxdruha; $i++): ?>
            <div class="secondarypreview">
                <a href="<?= $link->url("article.index", ["id" => $clanky[$i]->getId()]) ?>"><img src="<?= $link->asset($obrazky[$i]) ?>" alt="náhľad článku"></a>
                <div class="secondarypreviewtext">
                    <a href="<?= $link->url("article.index", ["id" => $clanky[$i]->getId()]) ?>"><h2><?= $clanky[$i]->getTitle() ?></h2></a>
                    <p><?= mb_substr($clanky[$i]->getText(), 0, 300) ?>...</p>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
<div class="tertiarypreviews">
    <p class="previewsectionname">Ďalšie články</p>
    <?php for($i = $maxdruha; $i < $maxtretia; $i++): ?>
        <a href="<?= $link->url("article.index", ["id" => $clanky[$i]->getId()]) ?>"><h2><?= $clanky[$i]->getTitle() ?></h2></a>
    <?php endfor; ?>
</div>