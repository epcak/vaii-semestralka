function runeditor()
{
  $('#summernote').summernote({
    placeholder: 'Text článku...',
    tabsize: 2,
    height: 600,
    toolbar: [
      ['font', ['bold', 'underline', 'clear']],
      ['para', ['ul', 'ol']],
      ['insert', ['link']],
      ['view', ['codeview', 'help']]
    ]
  });
}

async function ulozitclanok(idclanku) {
  const nazovclanku = String(document.getElementById("editorclanoknazov").value);
  if (nazovclanku == "") {
    window.alert("Názov článku nesmie byť prázdny");
    return;
  }
  const textclanku = $('#summernote').summernote("code");
  const zoznamobrazkov = document.getElementsByClassName("editorobrcheck");
  let zvoleneobrazky = [];
  for (let i = 0; i < zoznamobrazkov.length; i++) {
    if (zoznamobrazkov[i].checked) {
      zvoleneobrazky.push(zoznamobrazkov[i].value);
    }
  }
  let novy = false;
  if (idclanku == "-1") { 
    novy = true;
  }
  const formular = {"id": idclanku, "nazov": nazovclanku, "text": textclanku, "obrazky": zvoleneobrazky, "novy": novy};
  const response = await fetch("http://localhost/?c=create&a=save", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(formular)
        });
  if (!response.ok) {
      window.alert("Nastala chyba pri ukladaní článku!");
      throw new Error(`Kod odpovede: ${response.status}`);
  }
  const rawresponse = await response.json();
  if (rawresponse.status == "OK" && novy) {
      location.replace(`?c=create&a=editor&id=${rawresponse.articleid}`);
      return;
  } else if (rawresponse.status == "OK" && !novy) {
      window.alert("Članok bol uložený!");
  } else {
      window.alert("Nastala chyba pri ukladaní článku!");
  }
}