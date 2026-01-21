<?php

/** @var \Framework\Support\LinkGenerator $link */

$pocetclankov = sizeof($clanky);
$maxdruha = 5;
$maxtretia = $pocetclankov;
if ($pocetclankov < $maxdruha) $maxdruha = $pocetclankov;
?>

<div class="primarypreview">
    <a href="<?= $link->url("article.index", ["id" => $clanky[0]->getId()]) ?>"><img src="<?= $link->asset($obrazky[0]) ?>" alt="náhľad článku"></a>
    <div class="primarypreviewtext">
        <a href="<?= $link->url("article.index", ["id" => $clanky[0]->getId()]) ?>"><h2><?= $clanky[0]->getTitle() ?></h2></a>
        <p><?= mb_substr($clanky[0]->getText(), 0, 400) ?>...</p>
    </div>
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
<div id="nacitatdalsie">
    <input type="hidden" name="pocetnacitanych" id="pocetnacitanych" value="<?= $pocetclankov ?>">
    <a class="buttons" href="#butnacdal" onclick=prinacitajpopularne() id="butnacdal">Načítať ďalšie</a>
</div>