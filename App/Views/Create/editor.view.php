<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('editor');
?>
<div class="nadeditorom">
    <label for="editorclanoknazov">Názov článku</label>
    <input type="text" name="editorclanoknazov" id="editorclanoknazov">
    <button>Uložiť článok</button>
</div>
<div id="summernote">Editor</div>
<div class="podeditorom">
    <h2>Obrázky</h2>
    <a href="">Spravovať obrázky</a>
    <div class="editorobrazky">
        <div class="editorobrazok">
            <input type="checkbox" name="orb1" id="obr1">
            <img src="/images/defaultimage.png" alt="">
        </div>
    </div>
</div>