<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>
<div class="adminkomentare">
    <h2>Nazov clanku</h2>
    <ul>
        <li>
            <a href="<?= $link->url("admin.user")?>"><p>Uzivatel</p></a>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iste earum tempore omnis aperiam rerum qui, possimus deleniti velit accusamus architecto, aliquid veritatis libero. Earum, sequi dignissimos eos incidunt qui quidem.</p>
            <button class="adminbutdang">Odstrániť</button>
        </li>
    </ul>
</div>