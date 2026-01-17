<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('admin');
?>
<div class="adminkomentare">
    <h2><?= $clanok->getTitle() ?></h2>
    <ul>
        <?php
        foreach ($komentare as $komentar) {
            echo '<li>
            <a href="' . $link->url("admin.user", ["username" => $komentar->getUser()]) . '"><p>' . $komentar->getUser() . '</p></a>
            <p>' . $komentar->getComment() . '</p>
            <button class="adminbutdang" onclick=odstranitkomentar("' . $komentar->getId() . '")>Odstrániť</button>
        </li>';
        }
        ?>
    </ul>
</div>