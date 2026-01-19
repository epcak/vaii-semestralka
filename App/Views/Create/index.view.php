<div class="creatorclanky">
    <h2>Knižnica článkov</h2>
    <a href="<?= $link->url("create.editor")?>" id="novyclanok">Vytvoriť nový článok</a>
    <div id="creatorclanokview">
        <?php 
        $deakt = " disabled";
        if ($zverej) $deakt = "";
        foreach ($clanky as $clanok) {
            $zverejneny = "";
            if ($clanok->getPublished() == 1) $zverejneny = "checked";
            echo '<a href="' . $link->url("create.editor", ["id" => $clanok->getId()]) . '"><h3>' . $clanok->getTitle() . '</h3></a>
        <div class="creatorclanoktlacitka">
            <input type="checkbox" name="zverejneny' . $clanok->getId() . '" id="zverejneny' . $clanok->getId() . '" ' . $zverejneny . $deakt . ' onchange=zverejnitclakon("' . $clanok->getId() . '")>
            <label for="zverejneny' . $clanok->getId() . '">Zverejnený</label>
            <button onclick=odstranitclanok("' . $clanok->getId() . '")>Vymazať</button>
        </div>';
        }
        ?>
        
    </div>
</div>