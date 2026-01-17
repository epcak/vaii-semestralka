<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>
<div class="adminzobrazeniepodrobnostiuzivatel">
    <h3><?= $founduser->getUsername() ?></h3>
    <p class="adminuzivatelcelemeno"><?= $founduser->getDisplayname() ?></p>
    <div class="adminuzivatelrola">
        <h4>Rola</h4>
        <label for="uzivatelrola">Priradená rola</label>
        <select name="uzivatelrola" id="uzivatelrola" onchange=zmenitrolu("<?= $founduser->getUsername() ?>")>
            <option value="obycajny" <?php if ($founduser->getRole() == 0) echo "selected"; ?>>Bežný používateľ</option>
            <option value="externy" <?php if ($founduser->getRole() == 1) echo "selected"; ?>>Externý prispievateľ</option>
            <option value="redaktor" <?php if ($founduser->getRole() == 2) echo "selected"; ?>>Redaktor</option>
            <option value="admin" <?php if ($founduser->getRole() == 9) echo "selected"; ?>>Administrátor</option>
        </select>
    </div>
    <div class="adminuzivatelban">
        <h4>Ban</h4>
        <label for="uzivatelban">Typ zabanovania</label>
        <select name="uzivatelban" id="uzivatelban" onchange=zmenitbanuzivatela("<?= $founduser->getUsername() ?>")>
            <option value="ziaden" <?php if ($founduser->getBan() == 0) echo "selected"; ?>>Žiaden</option>
            <option value="shadow" <?php if ($founduser->getBan() == 1) echo "selected"; ?>>Shadow</option>
            <option value="tvrdy" <?php if ($founduser->getBan() == 2) echo "selected"; ?>>Tvrdý</option>
        </select>
    </div>
    <div class="adminuzivatelredaktor">
        <h4>Redaktor</h4>
        <label for="uzivatelredaktor">Priradený redoktor</label>
        <select name="uzivatelredaktor" id="uzivatelredaktor" <?php if ($founduser->getRole() != 1) echo "disabled"; ?> onchange=zmenitpriradenehoredaktora("<?= $founduser->getUsername() ?>")>
            <option value="ziaden">Žiaden</option>
            <?php
            $priradeny = $founduser->getRedactor();
            if ($founduser->getRole() == 1) {
                foreach ($redaktory as $redaktor) {
                    $zvolene = "";
                    if ($priradeny == $redaktor->getUsername()) $zvolene = "selected";
                    echo '<option value="' . $redaktor->getUsername() . '"' . $zvolene . '>' . $redaktor->getUsername() . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="adminuzivatelclanky">
        <h4>Články</h4>
        <ul>
        <?php
        foreach ($clanky as $clanok) {
            $zverejneny = "";
            if ($clanok->getPublished() == 1) $zverejneny = "checked";
            echo '<li>
                <span>' . $clanok->getTitle() . '</span>
                <input type="checkbox" name="clanokstav" id="clanokstav">
                <label for="clanokstav" ' . $zverejneny . '>Zverejnený</label>
                <a href="' . $link->url("admin.comments", ["id" => $clanok->getId()]) . '"><button >Komentáre</button></a>
                <button class="adminbutdang" onclick=odstranitclanok(' . $clanok->getId() . ')>Odstrániť</button>
            </li>';
        }
        ?>
        </ul>
    </div>
</div>
