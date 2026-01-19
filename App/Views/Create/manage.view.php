<div class="creatorclanky zvereneclanky">
    <h2>Zverené články</h2>
    <label for="zverenyuzivatel">Zvolený užívateľ</label>
    <select name="zverenyuzivatel" id="zverenyuzivatel" onchange=viewmanaged()>
        <option value="ziaden">žiaden</option>
        <?php
        foreach ($prispievatenia as $prisp) {
            echo '<option value="' . $prisp->getUsername() . '">' . $prisp->getUsername() . '</option>';
        }
        ?>
    </select>
    <div id="creatorclanokview">
    </div>
</div>