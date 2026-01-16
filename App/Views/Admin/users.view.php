<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>

<div class="adminuzivateliahladanie">
    <label for="uzivatelmeno">Hľadaný užívateľ</label>
    <input type="text" name="uzivatelmeno" id="uzivatelmeno">
    <button>Hľadať</button>
</div>
<div class="adminnajdenyuzivatelia">
    <h2>Nájdený užívatelia</h2>
    <ul>
        <li>
            <span>Uzivatel</span>
            <a href="<?= $link->url("admin.user") ?>"><button>Zobraziť možnosti</button></a>
            <button class="adminbutdang">Zabanovať užívateľa</button>
        </li>
    </ul>
</div>