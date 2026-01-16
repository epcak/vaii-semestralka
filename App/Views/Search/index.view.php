<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="vyhladavaniekontajner">
    <div class="vyhladavaniezadavanie">
        <div id="vyhladavanietext">
            <label id="vyhladavanytextlabel" for="vyhladavanytext">Vyhľadávanie</label>
            <br>
            <input type="text" name="vyhladavanytext" id="searchtext">
            <button onclick=getsearch()>--></button>
        </div>
        <div id="vyhladavanietyphladaneho">
            <input type="radio" name="typvyhladavania" id="vsetko" value="vsetko">
            <label for="vsetko">Všetko</label>
            <input type="radio" name="typvyhladavania" id="clanky" value="clanky">
            <label for="clanky">Články</label>
            <input type="radio" name="typvyhladavania" id="profily" value="profily">
            <label for="profily">Profily</label>
        </div>
    </div>
    <div class="vyhladavanievysledky">
        <div class="vyhladavanievysledok">
            <p class="vyhladavanietyp">Článok</p>
            <div class="vyhladavanieclanok">
                <a href="<?= $link->url("article.article") ?>"><img src="<?= $link->asset('images/defaultimage.png') ?>" alt="náhľad článku"></a>
                <div class="vyhladavanieclanoktext">
                    <a href="<?= $link->url("article.article") ?>"><h2>Nazov clanku c.</h2></a>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A labore tempore accusantium, totam magni, sit ab quos dolorem sed assumenda at dignissimos vitae ullam saepe modi! Voluptatem neque fugit distinctio...</p>
                </div>
            </div>
        </div>
        <div class="vyhladavanievysledok">
            <p class="vyhladavanietyp">Profil</p>
            <div class="vyhladavanieprofil">
                <a href="<?= $link->url("article.article") ?>"><h2>Profil c.</h2></a>
            </div>
        </div>
    </div>
    <div class="vyhladavaniedlasie">
        <div id="nacitatdalsietlacitko">
            <a onclick=loadmoresearch(0) class="buttons" href="">Načítať ďalšie</a>
        </div>
    </div>
</div>