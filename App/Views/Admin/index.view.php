<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>
<div class="adminmoznosti">
    <ul>
        <li><a href="<?= $link->url("admin.users")?>">Správa užívateľov</a></li>
        <li><a href="<?= $link->url("admin.articles")?>">Správa článkov</a></li>
    </ul>
</div>