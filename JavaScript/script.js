var spinnerOn = false;
var offset = 0;
function languageChange() {
    try {
        var lang = document.getElementById("selectLang").value;
        lang = lang.trim();
        for (var i = 0; i < 10; i++) {
            for (var i = 0; i < 10; i++) {
                var a = document.getElementById(i.toString());
                var href = a.getAttribute('href');
                href = href.trim();
                var newHref = href.substring(0, href.length - 13);
                newHref = newHref.trim();
                var addon = href.substring(href.length - 11);
                addon = addon.trim();
                newHref = newHref + lang + addon;
                newHref = newHref.trim();
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
    if(url.slice(-28, -19) == 'random=ok'){
        var newUrl = url.substring(0, url.length - 28);
        newUrl = newUrl + 'random=no&offset=000&lang=' + lang;
    }
    else {
        if(url.slice(-10, -4) == "offset"){
            var newUrl = url.substring(0, url.length - 13);
            var addon = url.substring(url.length - 11);
            newUrl = newUrl + lang + addon;
        }
        else {
            var newUrl = url.substring(0, url.length - 2);
            newUrl = newUrl + lang;
        }
    }
    window.location.href = newUrl;
}

/*
function loading(){
    document.getElementById("overlay").style.opacity = 0.5;
    document.getElementById("loader").className = "spinner-border";
    spinnerOn = true;
}

function pageLoad(){
    if(spinnerOn){
        document.getElementById("overlay").style.opacity = 0;
        document.getElementById("loader").className = "";
        spinnerOn = false;
    }
}
*/

document.getElementById("first").addEventListener("click", ()=>{
    $.ajax({
        type: "GET",
        url: "./ajax.php",
        data: "data",
        dataType: "json",
        success: function (response) {
            div = document.getElementById("capitoli");
            div.innerHTML = "";
            div.innerHTML = response.data[0].id;
        },
        error: function (response) {
            console.log('error');
        }
    });
});