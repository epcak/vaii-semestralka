<div class="creatorclanky zvereneclanky">
    <h2>Zverené články</h2>
    <label for="zverenyuzivatel">Zvolený užívateľ</label>
    <select name="zverenyuzivatel" id="zverenyuzivatel">
        <option value="tester">tester</option>
        <option value="mrkva">mrkva</option>
    </select>
    <div class="creatorclanokview">
        <a href="<?= $link->url("article.article")?>"><h3>Nazov clanku</h3></a>
        <div class="creatorclanoktlacitka">
            <input type="checkbox" name="zverejneny1" id="zverejneny1" checked>
            <label for="zverejneny1">Zverejnený</label>
        </div>
    </div>
</div>