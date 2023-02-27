<!DOCTYPE html>
<html>

<head>
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="./JavaScript/script.js"></script>
</head>

<body class="body">
    <?php
    $lines = file('./languages.txt');
    echo '<select id="selectLang" onchange="languageChange()">';
    foreach($lines as $line) {
        $line = rtrim($line, "\n");
        echo '<option value="' . $line . '">' . $line . '</option>';
    }
    echo '</select>';

    $lang = "en";
    if (isset($_GET['offset'])) {
        $offset = $_GET['offset'];
        $manga = $_GET['manga'];
        if($manga == "null") {
            $manga = $_POST["manga"];
        }
        else {
            $manga = $_GET['manga'];
        }
        $url = 'https://api.mangadex.org/manga?title=' . str_replace(' ', '%20', $manga) . '&offset=' . $offset;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response_json = curl_exec($ch);
        $mangas = json_decode($response_json, true);

        curl_close($ch);

        $total = $mangas["total"];

        $coverId = "";

        if (count($mangas["data"]) == 0) {
            echo '<h1>La ricerca non ha dato risultati</h1>';
        } 
        else {
            for ($j = 0; $j < count($mangas["data"]); $j = $j + 1) {
                for ($i = 0; $i < count($mangas["data"][$j]["relationships"]); $i = $i + 1) {
                    if ($mangas["data"][$j]["relationships"][$i]["type"] == "cover_art") {
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
                $cover = json_decode($response_json, true);

                curl_close($ch);

                $imgFilename = $cover["data"]["attributes"]["fileName"];

                //echo $lang;
                $sendUrl = 'chapters.php?Id=' . $mangaId . '&title=' . $mangas["data"][$j]["attributes"]["title"]["en"] . '&cover=' . $coverId . '&lang=' . $lang;
                //echo $sendUrl;

                echo '<div class="divDati">';
                echo '<div class="divCover">';
                echo '<a ' . 'id="' . $j . '" href="' . $sendUrl . '"><img class="cover" src="https://uploads.mangadex.org/covers/' . $mangaId . '/' . $imgFilename . '.256.jpg" alt="cover art" /></a>';
                echo '</div>';
                echo '<div class="divScritte">';
                echo $mangas["data"][$j]["attributes"]["title"]["en"] . '<br>';
                //echo $mangas["data"][$j]["attributes"]["description"]["en"] . '<br>';
                echo '</div>';
                echo '</div>';
                echo '<br>';
            }
            echo '<div class="divCenter">';
            if($offset > 0) {
                echo '<div>';
                echo '<a href="ricerca.php?offset=' . 0 . '&manga=' . $manga . '">';
                echo '<button><span class="material-symbols-outlined">keyboard_double_arrow_left</span></button>';
                echo '</a>';
                echo '</div>';
            }
            if($offset - 10 >= 0){
                echo '<div>';
                echo '<a href="ricerca.php?offset=' . $offset - 10 . '&manga=' . $manga . '">';
                echo '<button><span class="material-symbols-outlined">chevron_left</span></button>';
                echo '</a>';
                echo '</div>';
            }
            if($offset + 10 < $total){
                echo '<div>';
                echo '<a href="ricerca.php?offset=' . $offset + 10 . '&manga=' . $manga . '">';
                echo '<button><span class="material-symbols-outlined">chevron_right</span></button>';
                echo '</a>';
                echo '</div>';
            }
            if($offset < $total - 10){
                echo '<div>';
                echo '<a href="ricerca.php?offset=' . $total - 10 . '&manga=' . $manga . '">';
                echo '<button><span class="material-symbols-outlined">keyboard_double_arrow_right</span></button>';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
        }
        echo '<br>';
        echo '<div class="divCenter">';
        echo '<a href="index.php">';
        echo '<button><span class="material-symbols-outlined">Home</span></button>';
        echo '</a>';
        echo '</div>';
    }
    else {
        header('Location:index.php');
    }
    ?>
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
</body>

</html>