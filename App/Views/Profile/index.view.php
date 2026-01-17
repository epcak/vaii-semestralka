<?php

/** @var \Framework\Support\LinkGenerator $link */
?>
<div class="nastaveniacontainer">
    <div class="kontoltacidla">
        <a class="buttons" href="<?= $link->url("profile.logout") ?>">Odhlásiť sa</a>
    </div>
    <div class="kontoltacidla">
        <a class="buttons" href="<?= $link->url("profile.profile") ?>&name=<?= $logeduser->getUsername() ?>">Zobraziť profil</a>
    </div>
    <?php
        $rola = $logeduser->getRole();
        if ($rola == 1 || $rola == 2) { echo
    '<div class="kontoltacidla">
        <a class="buttons" href="' . $link->url("profile.gallery") . '">Moja galéria</a>
    </div>';
    echo
    '<div class="kontoltacidla">
        <a class="buttons" href="' . $link->url("create.index") . '">Moje články</a>
    </div>';
        }
        if ($rola == 2) { echo
    '<div class="kontoltacidla">
        <a class="buttons" href="' . $link->url("create.manage") . '">Priradený prispievatelia</a>
    </div>';
        }
        if ($rola == 9) { echo
    '<div class="kontoltacidla">
        <a class="buttons" href="' . $link->url("admin.index") . '">Administrácia</a>
    </div>';
        }
    ?>
    <div class="nastaveniaprofil">
        <h2>Nastavenia profilu</h2>
        <p id="errornastaveniaprofil"></p>
        <div class="displaynamesection">
            <label for="displaynameinput">Zobrazované meno</label>
            <br>
            <input type="text" name="displaynameinput" id="displayname" value="<?= $logeduser->getDisplayname() ?>">
            <br>
            <button onclick="trychangedisplayname()">Zmeniť meno</button>
        </div>
        
        <div class="descriptionsection">
            <label for="descriptionarea">Popis profilu</label>
            <br>
            <textarea name="descriptionarea" id="description"><?= $logeduser->getDescription() ?></textarea>
            <br>
            <button onclick="trychangedescription()">Zmeniť popis</button>
        </div>
    </div>
    <div class="nastaveniauctu">
        <h2>Nastavenia účtu</h2>
        <p id="errornastaveniauctu"></p>
        <div class="emailsection">
            <label for="emailinput">Email</label>
            <br>
            <input type="text" name="emailinput" id="email">
            <br>
            <label for="emailpassinput">Heslo</label>
            <br>
            <input type="password" name="emailpassinput" id="emailpass">
            <br>
            <button onclick="trychangeemail()">Zmeniť email</button>
        </div>
        <div class="emailsection">
            <label for="originalpassinput">Pôvodné heslo</label>
            <br>
            <input type="password" name="originalpassinput" id="originalpass">
            <br>
            <label for="newpassinput1">Nové heslo</label>
            <br>
            <input type="password" name="newpassinput1" id="newpass1">
            <br>
            <label for="newpassinput2">Znova nové heslo</label>
            <br>
            <input type="password" name="newpassinput2" id="newpass2">
            <br>
            <button onclick="trypasswordchange()">Zmeniť heslo</button>
        </div>
    </div>
    <div class="nastavenianevratitelne">
        <p id="errornastavenianevratitelne"></p>
        <h2>Nevrátitelné akcie</h2>
        <div class="dangerpasswordsection">
            <label for="dangerpassinput">Heslo</label>
            <br>
            <input type="password" name="dangerpassinput" id="dangerpass">
        </div>
        <div class="deleteaccount">
            <h3>Odstrániť účet</h3>
            <button onclick="trydeleteaccount()">Odstrániť účet</button>
        </div>
        <div class="deletesessions">
            <h3>Odstrániť všetky relácie</h3>
            <button onclick="trydeletesessions()">Vymazať všetky relácie</button>
        </div>
    </div>
</div>