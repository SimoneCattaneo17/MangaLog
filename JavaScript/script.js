function languageChange(){
    try{
        for(var i = 0; i < 10; i++){
            var lang = document.getElementById("selectLang").value;
            console.log(lang);
            for (var i = 0; i < 10; i ++) {
                var a = document.getElementById(i.toString());
                var href = a.getAttribute('href');
                href = href.trim();
                var newHref = href.substring(0, href.length - 2);
                newHref = newHref + lang;
                a.setAttribute('href', newHref);
            }
        }
    }
    catch(err){
        console.log(err);
    }
}