<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="primarypreview">
    <a href="<?= $link->url("article.article") ?>"><img src="<?= $link->asset('images/defaultimage.png') ?>" alt="náhľad článku"></a>
    <div class="primarypreviewtext">
        <a href="<?= $link->url("article.article") ?>"><h2>Nazov clanku</h2></a>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A labore tempore accusantium, totam magni, sit ab quos dolorem sed assumenda at dignissimos vitae ullam saepe modi! Voluptatem neque fugit distinctio...</p>
    </div>
</div>
<div class="secondarycategorycontainer">
    <div class="secondarypreviews">
        <?php foreach([1, 2, 3, 4, 5, 6, 7, 8] as $article): ?>
            <div class="secondarypreview">
                <a href="<?= $link->url("article.article", ["id" => $article]) ?>"><img src="<?= $link->asset('images/defaultimage.png') ?>" alt="náhľad článku"></a>
                <div class="secondarypreviewtext">
                    <a href="<?= $link->url("article.article", ["id" => $article]) ?>"><h2>Nazov clanku c.<?= $article ?></h2></a>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A labore tempore accusantium, totam magni, sit ab quos dolorem sed assumenda at dignissimos vitae ullam saepe modi! Voluptatem neque fugit distinctio...</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="tertiarypreviews">
    <p class="previewsectionname">Ďalšie články</p>
    <?php foreach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $article): ?>
        <a href="<?= $link->url("article.article", ["id" => $article]) ?>"><h2>Nazov clanku c. <?= $article ?></h2></a>
    <?php endforeach; ?>
</div>