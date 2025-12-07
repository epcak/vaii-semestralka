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