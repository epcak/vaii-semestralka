<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>

<div class="adminclanokhladanie">
    <label for="menoclanku">Hľadaný článko</label>
    <input type="text" name="menoclanku" id="menoclanku">
    <button>Hľadať</button>
</div>
<div class="adminnajdeneclanky">
    <h2>Nájdené články</h2>
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