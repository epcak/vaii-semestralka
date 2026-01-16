<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>
<div class="adminzobrazeniepodrobnostiuzivatel">
    <h3>Uzivatel</h3>
    <p class="adminuzivatelcelemeno">Jozko Mrkva</p>
    <div class="adminuzivatelrola">
        <h4>Rola</h4>
        <label for="uzivatelrola">Priradená rola</label>
        <select name="uzivatelrola" id="uzivatelrola">
            <option value="obycajny">Bežný používateľ</option>
            <option value="externy">Externý prispievateľ</option>
            <option value="redaktor">Redaktor</option>
            <option value="admin">Administrátor</option>
        </select>
    </div>
    <div class="adminuzivatelban">
        <h4>Ban</h4>
        <label for="uzivatelban">Typ zabanovania</label>
        <select name="uzivatelban" id="uzivatelban">
            <option value="ziaden">Žiaden</option>
            <option value="shadow">Shadow</option>
            <option value="tvrdy">Tvrdý</option>
        </select>
    </div>
    <div class="adminuzivatelredaktor">
        <h4>Redaktor</h4>
        <label for="uzivatelredaktor">Priradený redoktor</label>
        <select name="uzivatelredaktor" id="uzivatelredaktor" disabled>
            <option value="ziaden">Žiaden</option>
            <option value="admin">admin</option>
            <option value="jozomrkva">jozomrkva</option>
        </select>
    </div>
    <div class="adminuzivatelclanky">
        <h4>Články</h4>
        <ul>
            <li>
                <span>Clanok</span>
                <input type="checkbox" name="clanokstav" id="clanokstav">
                <label for="clanokstav">Zverejnený</label>
                <a href="<?= $link->url("admin.comments")?>"><button >Komentáre</button></a>
                <button class="adminbutdang">Odstrániť</button>
            </li>
        </ul>
    </div>
</div>
