<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="articleheader">
    <div class="articleheaderimage" style="background-image: url('<?= $link->asset('images/defaultimage.png') ?>');"></div>
    <h1>Názov článku. Lorem ipsum dolor sit, amet consectetur adipisicing elit.</h1>
</div>
<div class="secondarycolorcontainer">
    <div class="articlebody">
        <p></p>
    </div>
</div>
<div class="articlefooter">
    <h2 class="gallerysectionname">Galéria</h3>
    <div class="gallerycontainer">
        <img src="<?= $link->asset('images/defaultimage.png') ?>" alt="náhľad článku">
        <img src="<?= $link->asset('images/defaultimage.png') ?>" alt="náhľad článku">
    </div>
    <a class="buttons" href="<?= $link->url("article.comments") ?>">Komentáre</a>
</div>