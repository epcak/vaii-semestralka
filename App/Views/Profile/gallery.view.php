<div class="galeriakontajner">
    <h2>Moja galéria</h2>
    <div class="galerianahratsekcia">
        <h3>Nahrať nové obrázky</h3>
        <form action=<?= $link->url("profile.uploadimage") ?> id="formimageupload" method="post" enctype="multipart/form-data">
            <label for="nahratobrazok">Vyberte obrázok na nahratie</label>
            <input type="file" name="nahratobrazok" id="nahratobrazok">
            <br>
            <button>Nahrať obrázok</button>
        </form>
    </div>
    <h3>Moje obrázky</h3>
    <div class="galeriasprava">
        <?php
            foreach ($obrazky as $obrazok) {
                echo '<div class="galeriajednotlivy">
            <img src="' . $obrazok->getLocation() . '" alt="">
            <input type="text" class="galjedtext" id="imagedesc' . $obrazok->getId() . '" value="' . $obrazok->getDescription() . '">
            <button onclick=changeimagedescription("'. $obrazok->getId() .'")>Zmeniť popis</button>
            <br>
            <button class="galdelbut" onclick=deleteimage("'. $obrazok->getId() .'")>Odstrániť obrázok</button>
        </div>';
            }
        ?>
    </div>
</div>