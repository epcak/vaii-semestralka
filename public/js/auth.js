function trylogin() {
    document.getElementById("loginwarning").innerText = "";
    var username = String(document.getElementById("username").value);
    if (username.length < 5) {
        document.getElementById("loginwarning").innerText = "Prihlasovacie meno nie je dostatočne dlhé!";
        return;
    }
    if (username.includes('@')) {
        var lastdot = username.lastIndexOf('.');
        if (username.length < lastdot + 2 || lastdot == -1) {
            document.getElementById("loginwarning").innerText = "Email nie je kompletný!";
            return;
        }
    }
    var password = String(document.getElementById("password").value);
    if (password.length < 8) {
        document.getElementById("loginwarning").innerText = "Heslo je príliš krátke!";
        return;
    }
}

function tryreset() {
    document.getElementById("forgotwarning").innerText = "";
    var email = String(document.getElementById("email").value);
    var lastdot = email.lastIndexOf('.');
    if (email.indexOf('@') < 1 || email.length < lastdot + 2 || lastdot == -1) {
        document.getElementById("forgotwarning").innerText = "Email je v nesprávnom tvare!";
        return;
    }
}

async function tryregister() {
    document.getElementById("registerwarning").innerText = "";
    var email = String(document.getElementById("email").value);
    var lastdot = email.lastIndexOf('.');
    if (email.indexOf('@') < 1 || email.length < lastdot + 2 || lastdot == -1) {
        document.getElementById("registerwarning").innerText = "Email je v nesprávnom tvare!";
        return;
    }
    var username = String(document.getElementById("username").value);
    if (username.length < 5) {
        document.getElementById("registerwarning").innerText = "Prihlasovacie meno musí byť aspoň 5 znakov!";
        return;
    } else if (username.length > 30) {
        document.getElementById("registerwarning").innerText = "Prihlasovacie meno može mať maximálne 30 znakov!";
        return;
    }
    if (username.includes(".") || username.includes("@")) {
        document.getElementById("registerwarning").innerText = "Prihlasovacie meno nemôže obsahovať znaky . a @";
        return;
    }
    var password1 = String(document.getElementById("password").value);
    var password2 = String(document.getElementById("passwordrepeat").value);
    if (password1.length < 8) {
        document.getElementById("registerwarning").innerText = "Heslo musí mať aspoň 8 znakov!";
        return;
    }
    if (password1.length > 30) {
        document.getElementById("registerwarning").innerText = "Heslo môže mať najviac 30 znakov!";
        return;
    }
    if (password1 !== password2) {
        document.getElementById("registerwarning").innerText = "Heslá sa nezhodujú!";
        return;
    }

    try {
        let formular = {};
        formular["username"] = username;
        formular["email"] = email;
        formular["password"] = password1;

        const response = await fetch("http://localhost/?c=auth&a=registeror", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });

        if (!response.ok) {
            throw new Error(`Kod odpovede: ${response.status}`);
        }

        const rawresponse = await response.json();
        document.getElementById("registerwarning").innerText = rawresponse['status'];
        if (rawresponse['status'] == '') {
            document.cookie = `session=${rawresponse['session']}`;
            document.cookie = `username=${username};`
            window.location.href = "http://localhost";
        }
    } catch (ex ) {
        document.getElementById("registerwarning").innerText = "Nastala chyba pri spracovaní registrácie. Skuste to prosím neskôr.";
    }
}