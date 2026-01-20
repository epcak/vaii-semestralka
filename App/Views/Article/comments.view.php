<div class="komentarekontajner">
    <div class="komentareoclanku">
        <input type="hidden" name="komentarclanokid" id="komentarclanokid" value=<?= $clanok->getId() ?>>
        <a href="<?= $link->url("article.index", ["id" => $clanok->getId()]) ?>"><h3><-- Vrátiť sa k článku</h3></a>
        <h3><?= $clanok->getTitle() ?></h3>
    </div>
    <?php if ($prihlaseny) {
        echo '<div class="komentarenapisat">
        <h4>Napísať nový komentár</h4>
        <textarea name="novykomentar" id="novykomentar"></textarea>
        <div class="komentartlacidla">
            <button onclick=odoslatkomentar()>Odoslať komentár</button>
        </div>
    </div>';
    }
    ?>
    <?php foreach ($komentare as $komentar) {
        if ($komentar->getDeleted() == 1) {
            continue;
        }
        if ($komentar->getUser() == $uzivatel) {
            echo '<div class="komentarvlastny">
        <h4>' . $komentar->getUser() . '</h4>
        <textarea name="komentarvlastny' . $komentar->getId() . '" id="komentarvlastny' . $komentar->getId() . '">' . $komentar->getComment() .'</textarea>
        <div class="komentartlacidla">
            <button onclick=ulozitkomentar("' . $komentar->getId() . '")>Uložiť komentár</button>
            <button class="delbut" onclick=vymazatkomentar("' . $komentar->getId() . '")>Odstrániť komentár</button>
        </div>
    </div>';
        } else {
            echo '<div class="komentarekomentar">
        <a href="' . $link->url("profile.profile", ["name" => $komentar->getUser()]) . '"><h4>' . $komentar->getUser() . '</h4></a>
        <p>' . $komentar->getComment() . '</p>
    </div>';
        }
    }
    ?>
</div>