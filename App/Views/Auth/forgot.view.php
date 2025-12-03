<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="authinputcontainer">
    <p class="authwarning" id="forgotwarning"></p>
    <div class="authname">
        <label for="usernameinput">Email</label>
        <br>
        <input type="text" name="usernameinput" id="email">
    </div>
    <button onclick="tryreset()">Obnoviť heslo</button>
    <div class="authotheraction">
        <a href="?c=auth&a=login" class="authlink">Prihlásiť sa</a>
    </div>
</div>