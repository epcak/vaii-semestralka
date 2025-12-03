<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="authinputcontainer">
    <p class="authwarning" id="loginwarning"></p>
    <div class="authemail">
        <label for="emailinput">Prihlasovacie meno</label>
        <br>
        <input type="text" name="emailinput" id="email">
    </div>
    <div class="authname">
        <label for="usernameinput">Prihlasovacie meno</label>
        <br>
        <input type="text" name="usernameinput" id="username">
    </div>
    <div class="authpassword">
        <label for="passwordinput">Heslo</label>
        <br>
        <input type="password" name="passwordinput" id="password">
    </div>
    <div class="authpassword">
        <label for="passwordrepeatinput">Opakované heslo</label>
        <br>
        <input type="password" name="passwordrepeatinput" id="passwordrepeat">
    </div>
    <button>Registrovať</button>
    <div class="authotheraction">
        <a href="?c=auth&a=login" class="authlink">Prihlásiť sa</a>
    </div>
</div>