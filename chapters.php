<!DOCTYPE html>
<html>
    <head>
        <meta name="referrer" content="no-referrer" />
        <link rel="stylesheet" href="./CSS/style.css">
    </head>
    <body class="body">
    <?php
    $lang = "en"; //default
    if(isset($_GET['Id'])) {
        $Id = $_GET['Id'];
        $title = $_GET['title'];
        $lang = $_GET['lang'];
        echo '<h1>' . $title . '</h1>' . '<br>';
        $coverId = $_GET['cover'];

        //utilizzare il coverId in qualche modo per mettere l'immagine

        $url = 'https://api.mangadex.org/manga/' . $Id . '/feed?translatedLanguage[]=' . $lang . '&order[volume]=asc&order[chapter]=asc';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response_json = curl_exec($ch);
        $chapters=json_decode($response_json, true);

        curl_close($ch);


        if(count($chapters["data"]) == 0) {
            echo '<h3>Nessun capitolo disponibile nella lingua selezionata</h3>';
        }
        else {
            for($i = 0; $i < count($chapters["data"]); $i = $i+1) {
                $reader = 'reader.php?chapterId=' . $chapters["data"][$i]["id"];
                echo '<a href="' . $reader . '">' . 'chapter ' . $chapters["data"][$i]["attributes"]["chapter"] . ' ' . $chapters["data"][$i]["attributes"]["title"] . '</a>' . '<br>';
            }
        }
    }
    else {
        header('Location:index.php');
    }
?>
    </body>
</html>