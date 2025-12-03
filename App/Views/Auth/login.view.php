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
    <div class="authpassword">
        <label for="passwordinput">Heslo</label>
        <br>
        <input type="password" name="passwordinput" id="password">
    </div>
    <div>
        <a href="?c=auth&a=forgot" class="authlink">Zabudnuté heslo?</a>
    </div>
    <button onclick="trylogin()">Prihlásiť sa</button>
    <div class="authotheraction">
        <a href="?c=auth&a=register" class="authlink">Nová registrácia</a>
    </div>
</div>
