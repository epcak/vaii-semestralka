async function hladatuzivatelov() {
    const hladane = String(document.getElementById("uzivatelmeno").value);
    try {
        let listprenajdene = document.getElementById("zoznamnajdenychauzivatelovadmin");
        listprenajdene.innerHTML = '';
        let formular = {"user": hladane};
        const response = await fetch("http://localhost/?c=admin&a=finduser", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        for (const uzivatel of rawresponse) {
            listprenajdene.innerHTML += `<li>
            <span>${uzivatel}</span>
            <a href="?c=admin&a=user&username=${uzivatel}"><button>Zobraziť možnosti</button></a>
            <button class="adminbutdang" onclick="zabanovatuzivatela('${uzivatel}', 1)">Zabanovať užívateľa</button>
        </li>`;
        }
    } catch (ex ) {

    }
}

async function zabanovatuzivatela(meno, level) {
    if (!window.confirm(`Naozaj chcete shadow zabanovať ${meno} užívateľa?`)) {
        return;
    }

    let formular = {"user": meno, "level": level};
    const response = await fetch("http://localhost/?c=admin&a=banuser", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });

    if (!response.ok) {
        window.alert("Nastala chyba pri zabanovaní užívateľa!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Užívateľ je zabanovaný!");
        return;
    } else {
        window.alert("Užívateľ nie je zabanovaný!");
    }
}

async function zmenitbanuzivatela(meno) {
    const zvolene = String(document.getElementById("uzivatelban").value);
    let level = 0;
    if (zvolene == "shadow") {
        level = 1;
    }
    if (zvolene == "tvrdy") {
        level = 2;
    }
    let formular = {"user": meno, "level": level};
    const response = await fetch("http://localhost/?c=admin&a=banuser", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });

    if (!response.ok) {
        window.alert("Nastala chyba pri zabanovaní užívateľa!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Ban užívateľa je zmenený!");
        return;
    } else {
        window.alert("Ban užívateľa nie je zmenený!");
    }
}

async function zmenitrolu(meno) {
    const zvolene = String(document.getElementById("uzivatelrola").value);
    let rola = 0;
    if (zvolene == "externy") {
        rola = 1;
    } else if (zvolene == "redaktor") {
        rola = 2;
    } else if (zvolene == "admin") {
        rola = 9;
    }
    let formular = {"user": meno, "role": rola};
    const response = await fetch("http://localhost/?c=admin&a=changerole", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });

    if (!response.ok) {
        window.alert("Nastala chyba pri zmene role užívateľa!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Rola užívateľa je zmenená!");
        if (rola == 1) {
            location.reload();
        }
        return;
    } else {
        window.alert("Rola užívateľa nie je zmenená!");
    }
}

async function zmenitpriradenehoredaktora(meno) {
    const zvolene = String(document.getElementById("uzivatelredaktor").value);
    let formular = {"user": meno, "redactor": zvolene};
    const response = await fetch("http://localhost/?c=admin&a=updateuserredactor", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });

    if (!response.ok) {
        window.alert("Nastala chyba pri priradení redaktora!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Priradený redaktor je zmenený!");
        return;
    } else {
        window.alert("Priradený redaktor nie je zmenený!");
    }
}

async function zverejnitclakon(idclanku) {
    const zvolene = String(document.getElementById(`clanokstav${idclanku}`).checked);
    let formular = {"articleid": idclanku, "published": zvolene};
    const response = await fetch("http://localhost/?c=admin&a=changepublished", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });

    if (!response.ok) {
        window.alert("Nastala chyba pri zmene zverejnenia!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Zverejnenie článku je zmenené!");
        return;
    } else {
        window.alert("Zverejnenie článku nie je zmenené!");
    }
}

async function hladatclanky() {
    const hladane = String(document.getElementById("menoclanku").value);
    try {
        let listprenajdene = document.getElementById("adminlistnajdeneclanky");
        listprenajdene.innerHTML = '';
        let formular = {"searched": hladane};
        const response = await fetch("http://localhost/?c=admin&a=searcharticles", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        for (var i = 0; i < rawresponse.mena.length; i++) {
            let zverej = "";
            if (rawresponse.zverejnene[i] == 1) zverej = "checked";
            listprenajdene.innerHTML += `<li>
            <span>${rawresponse.mena[i]}</span>
            <input type="checkbox" name="clanokstav${rawresponse.id[i]}" id="clanokstav${rawresponse.id[i]}" onchange=zverejnitclakon(${rawresponse.id[i]}) ${zverej}>
            <label for="clanokstav${rawresponse.id[i]}">Zverejnený</label>
            <a href="?c=admin&a=comments&id=${rawresponse.id[i]}"><button>Komentáre</button></a>
            <button class="adminbutdang" onclick="odstranitclanok(${rawresponse.id[i]})">Odstrániť</button>
        </li>`;
        }
    } catch (ex ) {

    }
}

async function odstranitclanok(idclanku) {
    if (!window.confirm(`Naozaj chcete vymazať článok?`)) {
        return;
    }
    let formular = {"articleid": idclanku};
    const response = await fetch("http://localhost/?c=admin&a=deletearticle", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri odstránení článku!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Článok je vymazaný!");
        location.reload();
        return;
    } else {
        window.alert("Článok nie je vymazaný!");
    }
}

async function odstranitkomentar(idkomentar) {
    if (!window.confirm(`Naozaj chcete vymazať komentár?`)) {
        return;
    }
    let formular = {"commentid": idkomentar};
    const response = await fetch("http://localhost/?c=admin&a=deletecomment", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri odstránení komentáru!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Komentár je vymazaný!");
        location.reload();
        return;
    } else {
        window.alert("Komentár nie je vymazaný!");
    }
}