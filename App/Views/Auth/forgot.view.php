<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="authinputcontainer">
    <p class="authwarning" id="loginwarning"></p>
    <div class="authname">
        <label for="usernameinput">Prihlasovacie meno / email</label>
        <br>
        <input type="text" name="usernameinput" id="username">
    </div>
    <button>Obnoviť heslo</button>
    <div class="authotheraction">
        <a href="?c=auth&a=login" class="authlink">Prihlásiť sa</a>
    </div>
</div>