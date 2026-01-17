<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>

<div class="adminuzivateliahladanie">
    <label for="uzivatelmeno">Hľadaný užívateľ</label>
    <input type="text" name="uzivatelmeno" id="uzivatelmeno">
    <button onclick=hladatuzivatelov()>Hľadať</button>
</div>
<div class="adminnajdenyuzivatelia">
    <h2>Nájdený užívatelia</h2>
    <ul id="zoznamnajdenychauzivatelovadmin">
    </ul>
</div>