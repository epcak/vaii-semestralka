<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('editor');
?>
<div class="nadeditorom">
    <label for="editorclanoknazov">Názov článku</label>
    <input type="text" name="editorclanoknazov" id="editorclanoknazov" value="<?php if ($clanok != NULL) echo $clanok->getTitle();?>">
    <button onclick=ulozitclanok('<?php if ($clanok != NULL) {echo $clanok->getId();} else {echo "-1";}?>')>Uložiť článok</button>
</div>
<div id="summernote"><?php if ($clanok != NULL) echo $clanok->getText();?></div>
<div class="podeditorom">
    <h2>Obrázky</h2>
    <a href="<?= $link->url("profile.gallery") ?>">Spravovať obrázky</a>
    <div class="editorobrazky">
        <?php foreach ($obrazky as $obrazok) {
            $uzpriradeny = "";
            if (in_array($obrazok->getId(), $priradene)) $uzpriradeny = " checked";
            echo '<div class="editorobrazok">
            <input type="checkbox" class="editorobrcheck" name="orb' . $obrazok->getId() . '" value="' . $obrazok->getId() .'" id="obr' . $obrazok->getId() . '"' . $uzpriradeny . '>
            <img src="' . $obrazok->getLocation() . '" alt="' . $obrazok->getDescription() . '">
        </div>';
        }
        ?>
    </div>
</div>