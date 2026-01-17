<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>

<div class="adminclanokhladanie">
    <label for="menoclanku">Hľadaný článok</label>
    <input type="text" name="menoclanku" id="menoclanku">
    <button onclick=hladatclanky()>Hľadať</button>
</div>
<div class="adminnajdeneclanky">
    <h2>Nájdené články</h2>
    <ul id="adminlistnajdeneclanky">
    </ul>
</div>