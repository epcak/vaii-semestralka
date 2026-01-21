async function trychangedisplayname() {
    const newdisplayname = String(document.getElementById("displayname").value);
    try {
        let formular = {"displayname": newdisplayname};
        const response = await fetch("http://localhost/?c=profile&a=changedisplayname", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        if (rawresponse['status'] == 'OK') {
            window.location.reload();
        } else {
            document.getElementById("errornastaveniaprofil").innerText = rawresponse['status'];
        }

    } catch (ex ) {
        document.getElementById("errornastaveniaprofil").innerText = "Nastala chyba pri spracovaní požiadavky. Skuste to prosím neskôr.";
    }
}

async function trychangedescription() {
    const newdescription = String(document.getElementById("description").value);
    try {
        let formular = {"description": newdescription};
        const response = await fetch("http://localhost/?c=profile&a=changedescription", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        if (rawresponse['status'] == 'OK') {
            window.location.reload();
        } else {
            document.getElementById("errornastaveniaprofil").innerText = rawresponse['status'];
        }

    } catch (ex ) {
        document.getElementById("errornastaveniaprofil").innerText = "Nastala chyba pri spracovaní požiadavky. Skuste to prosím neskôr.";
    }
}

async function trychangeemail() {
    const newemail = String(document.getElementById("email").value);
    const password = String(document.getElementById("emailpass").value);
    var lastdot = newemail.lastIndexOf('.');
    if (newemail.indexOf('@') < 1 || newemail.length < lastdot + 2 || lastdot == -1) {
        document.getElementById("errornastaveniauctu").innerText = "Email je v nesprávnom tvare!";
        return;
    }
    try {
        let formular = {"email": newemail, "password": password};
        const response = await fetch("http://localhost/?c=profile&a=changeemail", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        if (rawresponse['status'] == 'OK') {
            window.location.reload();
            document.getElementById("errornastaveniauctu").innerText = "Email zmenený.";
        } else {
            document.getElementById("errornastaveniauctu").innerText = rawresponse['status'];
        }

    } catch (ex ) {
        document.getElementById("errornastaveniauctu").innerText = "Nastala chyba pri spracovaní požiadavky. Skuste to prosím neskôr.";
    }
}

async function trypasswordchange() {
    const oldpass = String(document.getElementById("originalpass").value);
    const newpass1 = String(document.getElementById("newpass1").value);
    const newpass2 = String(document.getElementById("newpass2").value);
    if (newpass1.length < 8) {
        document.getElementById("errornastaveniauctu").innerText = "Heslo musí mať aspoň 8 znakov!";
        return;
    }
    if (newpass1.length > 30) {
        document.getElementById("errornastaveniauctu").innerText = "Heslo môže mať najviac 30 znakov!";
        return;
    }
    if (newpass1 !== newpass2) {
        document.getElementById("errornastaveniauctu").innerText = "Heslá sa nezhodujú!";
        return;
    }
    try {
        let formular = {"password": oldpass, "newpassword": newpass1};
        const response = await fetch("http://localhost/?c=profile&a=changepassword", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        if (rawresponse['status'] == 'OK') {
            window.location.reload();
        } else {
            document.getElementById("errornastaveniauctu").innerText = rawresponse['status'];
        }

    } catch (ex ) {
        document.getElementById("errornastaveniauctu").innerText = "Nastala chyba pri spracovaní požiadavky. Skuste to prosím neskôr.";
    }
}

async function trydeleteaccount() {
    const password = String(document.getElementById("dangerpass").value);
    if (!window.confirm("Naozaj chcete vymazať účet?")) {
        return;
    }
    try {
        let formular = {"password": password};
        const response = await fetch("http://localhost/?c=profile&a=deleteaccount", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        if (rawresponse['status'] == 'OK') {
            window.location.replace("http://localhost/");
        } else {
            document.getElementById("errornastavenianevratitelne").innerText = rawresponse['status'];
        }

    } catch (ex ) {
        document.getElementById("errornastavenianevratitelne").innerText = "Nastala chyba pri spracovaní požiadavky. Skuste to prosím neskôr.";
    }
}

async function trydeletesessions() {
    const password = String(document.getElementById("dangerpass").value);
    if (!window.confirm("Naozaj chcete vymazať všetky relácie? Táto akcia vás odhlási.")) {
        return;
    }
    try {
        let formular = {"password": password};
        const response = await fetch("http://localhost/?c=profile&a=deletesessions", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        if (rawresponse['status'] == 'OK') {
            window.location.replace("http://localhost/");
        } else {
            document.getElementById("errornastavenianevratitelne").innerText = rawresponse['status'];
        }

    } catch (ex ) {
        document.getElementById("errornastavenianevratitelne").innerText = "Nastala chyba pri spracovaní požiadavky. Skuste to prosím neskôr.";
    }
}

async function getsearch() {
    let typvyhladavania = "vsetky";
    let typyvyhladavania = document.getElementsByName("typvyhladavania");
    for (i = 0; i < typyvyhladavania.length; i++) {
        if (typyvyhladavania[i].checked) {
            typvyhladavania = typyvyhladavania[i].value;
        }
    }
    const vyhladavanie = document.getElementById("searchtext").value;
    try {
        let formular = {"typ": typvyhladavania, "hladane": vyhladavanie, "offsetprofily": 0, "offsetclanky": 0};
        const response = await fetch("http://localhost/?c=search&a=getsearch", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        let zoznamnajdene = document.getElementsByClassName("vyhladavanievysledky")[0];
        zoznamnajdene.innerHTML = "";
        let pocetclanky = 0;
        let pocetprofily = 0;
        for (i = 0; i < rawresponse.typy.length; i++) {
            if (rawresponse.typy[i] == "clanok") {
                pocetclanky++;
                zoznamnajdene.innerHTML += `<div class="vyhladavanievysledok">
            <p class="vyhladavanietyp">Článok</p>
            <div class="vyhladavanieclanok">
                <a href="?c=article&id=${rawresponse.id[i]}"><img src="${rawresponse.obrazky[i]}" alt="náhľad článku"></a>
                <div class="vyhladavanieclanoktext">
                    <a href="?c=article&id=${rawresponse.id[i]}"><h2>${rawresponse.nazvy[i]}</h2></a>
                    <p>${rawresponse.texty[i]}</p>
                </div>
            </div>
        </div>`;
            }
            if (rawresponse.typy[i] == "profil") {
                pocetprofily++
                zoznamnajdene.innerHTML += `<div class="vyhladavanievysledok">
            <p class="vyhladavanietyp">Profil</p>
            <div class="vyhladavanieprofil">
                <a href="?c=profile&a=profile&user=${rawresponse.texty[i]}"><h2>${rawresponse.nazvy[i]}</h2></a>
            </div>
        </div>`
            }
        }
        document.getElementById("pocetvyhladanehoprofil").value = pocetprofily;
        document.getElementById("pocetvyhladanehoclanky").value = pocetclanky;
        document.getElementById("searchmore").hidden = false;
        if (rawresponse.typy.length == 0) {
            document.getElementById("searchmore").hidden = true;
        }
    } catch (ex ) {

    }
}

async function loadmoresearch() {
    let typvyhladavania = "vsetky";
    let typyvyhladavania = document.getElementsByName("typvyhladavania");
    let offsetprofily = document.getElementById("pocetvyhladanehoprofil").value 
    let offsetclanky = document.getElementById("pocetvyhladanehoclanky").value 
    for (i = 0; i < typyvyhladavania.length; i++) {
        if (typyvyhladavania[i].checked) {
            typvyhladavania = typyvyhladavania[i].value;
        }
    }
    const vyhladavanie = document.getElementById("searchtext").value;
    try {
        let formular = {"typ": typvyhladavania, "hladane": vyhladavanie, "offsetprofily": offsetprofily, "offsetclanky": offsetclanky};
        const response = await fetch("http://localhost/?c=search&a=getsearch", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        let zoznamnajdene = document.getElementsByClassName("vyhladavanievysledky")[0];
        let pocetclanky = 0;
        let pocetprofily = 0;
        for (i = 0; i < rawresponse.typy.length; i++) {
            if (rawresponse.typy[i] == "clanok") {
                pocetclanky++;
                zoznamnajdene.innerHTML += `<div class="vyhladavanievysledok">
            <p class="vyhladavanietyp">Článok</p>
            <div class="vyhladavanieclanok">
                <a href="?c=article&id=${rawresponse.id[i]}"><img src="${rawresponse.obrazky[i]}" alt="náhľad článku"></a>
                <div class="vyhladavanieclanoktext">
                    <a href="?c=article&id=${rawresponse.id[i]}"><h2>${rawresponse.nazvy[i]}</h2></a>
                    <p>${rawresponse.texty[i]}</p>
                </div>
            </div>
        </div>`;
            }
            if (rawresponse.typy[i] == "profil") {
                pocetprofily++;
                zoznamnajdene.innerHTML += `<div class="vyhladavanievysledok">
            <p class="vyhladavanietyp">Profil</p>
            <div class="vyhladavanieprofil">
                <a href="?c=profile&a=profile&user=${rawresponse.texty[i]}"><h2>${rawresponse.nazvy[i]}</h2></a>
            </div>
        </div>`
            }
        }
        document.getElementById("pocetvyhladanehoprofil").value += pocetprofily;
        document.getElementById("pocetvyhladanehoclanky").value += pocetclanky;
        if (rawresponse.typy.length == 0) {
            document.getElementById("searchmore").hidden = true;
        }
    } catch (ex ) {

    }
}

async function prinacitajnove() {
    const pocetnacitanych = String(document.getElementById("pocetnacitanych").value);
    let zoznamclankov = document.getElementsByClassName("tertiarypreviews")[0];
    try {
        let formular = {"nacitane": pocetnacitanych};
        const response = await fetch("http://localhost/?c=home&a=loadmorenew", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        for (let i = 0; i < rawresponse.nazvy.length; i++) {
            zoznamclankov.innerHTML += `<a href="?c=article&id=${rawresponse.id[i]}"><h2>${rawresponse.nazvy[i]}</h2></a>`
        }
        let pocet = parseInt(document.getElementById("pocetnacitanych").value) + rawresponse.nazvy.length;
        document.getElementById("pocetnacitanych").value = pocet;
        if (rawresponse.nazvy.length == 0) {
            document.getElementById("butnacdal").hidden = true;
        }
    } catch (ex ) {

    }
}

async function prinacitajpopularne() {
    const pocetnacitanych = String(document.getElementById("pocetnacitanych").value);
    let zoznamclankov = document.getElementsByClassName("tertiarypreviews")[0];
    try {
        let formular = {"nacitane": pocetnacitanych};
        const response = await fetch("http://localhost/?c=home&a=loadmorepopular", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        for (let i = 0; i < rawresponse.nazvy.length; i++) {
            zoznamclankov.innerHTML += `<a href="?c=article&id=${rawresponse.id[i]}"><h2>${rawresponse.nazvy[i]}</h2></a>`
        }
        let pocet = parseInt(document.getElementById("pocetnacitanych").value) + rawresponse.nazvy.length;
        document.getElementById("pocetnacitanych").value = pocet;
        if (rawresponse.nazvy.length == 0) {
            document.getElementById("butnacdal").hidden = true;
        }
    } catch (ex ) {

    }
}

async function viewmanaged() {
    const uzivatel = String(document.getElementById("zverenyuzivatel").value);
    let zoznamclankov = document.getElementById("creatorclanokview");
    zoznamclankov.innerHTML = "";
    if (uzivatel == "ziaden") return;
    try {
        let formular = {"username": uzivatel};
        const response = await fetch("http://localhost/?c=create&a=subeditorarticles", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(formular)
            });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }
        const rawresponse = await response.json();
        for (let i = 0; i < rawresponse.nazvy.length; i++) {
            let zverejnene = "";
            if (rawresponse.zverejnene[i] == 1) zverejnene = "checked";
            zoznamclankov.innerHTML += `<a href="?c=article&id=${rawresponse.id[i]}"><h3>${rawresponse.nazvy[i]}</h3></a>
        <div class="creatorclanoktlacitka">
            <input type="checkbox" name="zverejneny${rawresponse.id[i]}" id="zverejneny${rawresponse.id[i]}" onchange=zverejnitclakon("${rawresponse.id[i]}") ${zverejnene}>
            <label for="zverejneny${rawresponse.id[i]}">Zverejnený</label>
        </div>`
        }
    } catch (ex ) {

    }
}

async function zverejnitclakon(idclanku) {
    const zvolene = String(document.getElementById(`zverejneny${idclanku}`).checked);
    let formular = {"articleid": idclanku, "published": zvolene};
    const response = await fetch("http://localhost/?c=create&a=changepublished", {
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

async function odstranitclanok(idclanku) {
    if (!window.confirm(`Naozaj chcete vymazať článok?`)) {
        return;
    }
    let formular = {"articleid": idclanku};
    const response = await fetch("http://localhost/?c=create&a=deletearticle", {
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

async function changeimagedescription(imageid) {
    const zvolene = String(document.getElementById(`imagedesc${imageid}`).value);
    let formular = {"imageid": imageid, "desc": zvolene};
    const response = await fetch("http://localhost/?c=profile&a=changeimagedescription", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri zmene popisu!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Popis je zmenený!");
        location.reload();
        return;
    } else {
        window.alert("Popis nie je zmenený!");
    }
}

async function deleteimage(imageid) {
    if (!window.confirm(`Naozaj chcete vymazať obrázok?`)) {
        return;
    }
    let formular = {"imageid": imageid};
    const response = await fetch("http://localhost/?c=profile&a=deleteimage", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri odstránení obrázku!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        window.alert("Obrázok je vymazaný!");
        location.reload();
        return;
    } else {
        window.alert("Obrázok nie je vymazaný!");
    }
}

async function odoslatkomentar() {
    const idclanku = String(document.getElementById("komentarclanokid").value);
    const text = String(document.getElementById("novykomentar").value);
    let formular = {"id": -1, "novy": true, "text": text, "clanok": idclanku};
    const response = await fetch("http://localhost/?c=article&a=commentsave", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri nahratí komentára!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        location.reload();
        return;
    } else {
        window.alert("Nastala chyba pri nahratí komentára!");
    }
}

async function ulozitkomentar(idkomentara) {
    const idclanku = String(document.getElementById("komentarclanokid").value);
    const text = String(document.getElementById(`komentarvlastny${idkomentara}`).value);
    let formular = {"id": idkomentara, "novy": false, "text": text, "clanok": idclanku};
    const response = await fetch("http://localhost/?c=article&a=commentsave", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri uložení komentára!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        location.reload();
        return;
    } else {
        window.alert("Nastala chyba pri uložení komentára!");
    }
}

async function vymazatkomentar(idkomentara) {
    const idclanku = String(document.getElementById("komentarclanokid").value);
    let formular = {"id": idkomentara, "clanok": idclanku};
    const response = await fetch("http://localhost/?c=article&a=commentdelete", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
    if (!response.ok) {
        window.alert("Nastala chyba pri odstranení komentára!");
        throw new Error(`Kod odpovede: ${response.status}`);
    }
    const rawresponse = await response.json();
    if (rawresponse.status == "OK") {
        location.reload();
        return;
    } else {
        window.alert("Nastala chyba pri odstranení komentára!");
    }
}