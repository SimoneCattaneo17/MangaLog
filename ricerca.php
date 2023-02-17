<!DOCTYPE html>
<html>
    <head>
        <meta name="referrer" content="no-referrer" />
        <link rel="stylesheet" href="./CSS/style.css">
    </head>
    <body class="body">
    <?php
    $url = 'https://api.mangadex.org/manga?title=' . str_replace(' ', '%20', $_POST["manga"]);
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response_json = curl_exec($ch);
    $mangas=json_decode($response_json, true);

    curl_close($ch);

    $coverId = "";

    if(count($mangas["data"]) == 0) {
        echo '<h1>La ricerca non ha dato risultati</h1>';
    }
    else {
        for($j = 0; $j < count($mangas["data"]); $j = $j + 1) {
            for($i = 0; $i < count($mangas["data"][$j]["relationships"]); $i = $i+1) {
                if($mangas["data"][$j]["relationships"][$i]["type"] == "cover_art") {
                    $coverId = $mangas["data"][$j]["relationships"][$i]["id"];
                    break;
                }
            }
            $mangaId = $mangas["data"][$j]["id"];
        
            $url = 'https://api.mangadex.org/cover/' . $coverId;
            $ch = curl_init($url);
        
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $response_json = curl_exec($ch);
            $cover=json_decode($response_json, true);
        
            curl_close($ch);
        
            $imgFilename = $cover["data"]["attributes"]["fileName"];
    
            $sendUrl = 'chapters.php?Id=' . $mangaId . '&title=' . $mangas["data"][$j]["attributes"]["title"]["en"] . '&cover=' . $coverId;
    
            echo '<div class="divDati">';
            echo '<div class="divCover">';
            echo '<a href="' . $sendUrl . '"><img class="cover" id="' . $mangaId . '" src="https://uploads.mangadex.org/covers/' . $mangaId . '/' . $imgFilename . '.256.jpg" alt="cover art" /></a>';
            echo '</div>';
            echo '<div class="divScritte">';
            echo $mangas["data"][$j]["attributes"]["title"]["en"] . '<br>';
            //echo $mangas["data"][$j]["attributes"]["description"]["en"] . '<br>';
            echo '</div>';
            echo '</div>';
            echo '<br>';
        }
    }
    echo '<div class="divCenter">';
    echo '<br>';
    echo '<a href="index.php">';
    echo '<button>Torna alla homepage</button>';
    echo '</a>';
    echo '</div>';
    
?>
    </body>
</html>