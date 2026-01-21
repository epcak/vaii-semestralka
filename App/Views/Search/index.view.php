<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="vyhladavaniekontajner">
    <div class="vyhladavaniezadavanie">
        <div id="vyhladavanietext">
            <label id="vyhladavanytextlabel" for="vyhladavanytext">Vyhľadávanie</label>
            <br>
            <input type="text" name="vyhladavanytext" id="searchtext">
            <input type="hidden" name="pocetvyhladaneho" id="pocetvyhladanehoprofil">
            <input type="hidden" name="pocetvyhladaneho" id="pocetvyhladanehoclanky">
            <button onclick=getsearch()>--></button>
        </div>
        <div id="vyhladavanietyphladaneho">
            <input type="radio" name="typvyhladavania" id="vsetko" value="vsetko" checked>
            <label for="vsetko">Všetko</label>
            <input type="radio" name="typvyhladavania" id="clanky" value="clanky">
            <label for="clanky">Články</label>
            <input type="radio" name="typvyhladavania" id="profily" value="profily">
            <label for="profily">Profily</label>
        </div>
    </div>
    <div class="vyhladavanievysledky">
    </div>
    <div class="vyhladavaniedlasie">
        <div id="nacitatdalsietlacitko">
            <a onclick=loadmoresearch() class="buttons" href="#searchmore" id="searchmore" hidden>Načítať ďalšie</a>
        </div>
    </div>
</div>