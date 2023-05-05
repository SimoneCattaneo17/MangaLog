var spinnerOn = false;
var offset = 0;
var mangas;
var cover;
var coverId;
var mangaId;
var j;
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

function dataLoad(response) {
    console.log(response);
    mangas = response;
    for(var h = 0; h < mangas.data.length; h++){
        console.log(mangas.data[h].attributes.title.en);
    }
    for(j = 0; j < mangas.data.length; j++){
        for(var i = 0; i < mangas.data[i].relationships.length; i++){
            if(mangas.data[j].relationships[i].type == "cover_art"){
                coverId = mangas.data[j].relationships[i].id;
            }
        }
        mangaId = mangas.data[j].id;
        $.ajax({
            type: "POST",
            url: "./ajaxCovers.php",
            data: {
                "coverId": coverId,
            },
            dataType: "json",
            success: function (response) {
                console.log(j);
                console.log(response);
                cover = response;
                var imgFilename = response.data.attributes.fileName;
                var sendUrl = 'chapters.php?search=ok&Id=' + mangaId + '&title=' + mangas.data[j].attributes.title.en + '&cover=' + imgFilename + '&lang=en&offset=000';
                var container = document.getElementById("container");
                container.innerHTML += '<div class="divDati" id="divDati">';
                container.innerHTML += '<div class="divCover" id="divCover">';
                container.innerHTML += '<a onclick="loading()" ' + 'id="' + j + '" href="' + sendUrl + '"><img class="cover" src="https://uploads.mangadex.org/covers/' + mangaId + '/' + imgFilename + '.256.jpg" alt="cover art" /></a>';
                container.innerHTML += '</div>';
                container.innerHTML += '<div class="divScritte" id="divScritte">';
                container.innerHTML += '<h3>' + mangas.data[j].attributes.title.en + '</h3>' + '<br>';
                if(mangas.data[j].attributes.description.en !== null){
                    container.innerHTML += mangas.data[j].attributes.description.en.slice(0, 150) + '...' + '<br>';
                }
                else {
                    container.innerHTML += 'No description available';
                }
                container.innerHTML += '</div>';
                container.innerHTML += '</div>';
                container.innerHTML += '<br>'
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
}

function pclick(id){
    $.ajax({
        type: "POST",
        url: "./ajaxPages.php",
        data: {
            "buttonId": id,
        },
        dataType: "json",
        success: function (response) {
            var container = document.getElementById("container");
            container.innerHTML = "";
            dataLoad(response);
        },
        error: function (response) {
            console.log('error');
        }
    });
}

function changePage(id){
    $.ajax({
        type: "POST",
        url: "./ajaxChapters.php",
        data: {
            "buttonId": id,
        },
        dataType: "json",
        success: function (response) {
            div = document.getElementById("capitoli");
            div.innerHTML = "";
            for(var i = 0; i < response.data.length; i++){
                div.innerHTML += "<a href='./reader.php?chapterId=" + response.data[i].id + "'> volume " + response.data[i].attributes.volume + " chapter " + response.data[i].attributes.chapter + " " + response.data[i].attributes.title + "</a><br>";
            }
        },
        error: function (response) {
            console.log('error');
        }
    });
}