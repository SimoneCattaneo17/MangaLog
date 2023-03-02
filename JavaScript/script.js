function languageChange() {
    try {
        var lang = document.getElementById("selectLang").value;
        //console.log(lang);
        for (var i = 0; i < 10; i++) {
            for (var i = 0; i < 10; i++) {
                var a = document.getElementById(i.toString());
                var href = a.getAttribute('href');
                href = href.trim();
                var newHref = href.substring(0, href.length - 2);
                newHref = newHref + lang;
                a.setAttribute('href', newHref);
            }
        }
    }
    catch (err) {
        console.log(err);
    }
}

function languageChangeChapter(){
    console.log("languageChangeChapter");
    var lang = document.getElementById("selectLangChapter").value;
    console.log(lang);
    var url = window.location.href;
    url.trim();
    console.log(url);
    var newUrl = url.substring(0, url.length - 2);
    console.log(newUrl);
    newUrl = newUrl + lang;
    console.log(newUrl);
    window.location.href = newUrl;
}
