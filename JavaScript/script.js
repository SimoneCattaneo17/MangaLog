var selectIndex;

function languageChange() {
    try {
        var lang = document.getElementById("selectLang").value;
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
    localStorage.setItem('langIndex', document.getElementById("selectLangChapter").tabIndex);
    var lang = document.getElementById("selectLangChapter").value;
    var url = window.location.href;
    url.trim();
    if(url.slice(-17) == 'random=ok&lang=en'){
        var newUrl = url.substring(0, url.length - 17);
        newUrl = newUrl + 'random=no&lang=' + lang;
    }
    else {
        var newUrl = url.substring(0, url.length - 2);
        newUrl = newUrl + lang;
    }
    window.location.href = newUrl;
}

function loading(){
    document.getElementById("overlay").style.opacity = 0.5;
    document.getElementById("loader").className = "spinner-border";
}