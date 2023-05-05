<?php
    session_start();

    ini_set('display_errors', 1);

    require __DIR__ . '/functions.php';

    switch($_POST["buttonId"]){
        case '1':
            $_SESSION['offset'] = 000;
            break;
        case '2':
            if($_SESSION['offset'] > 100) {
                $_SESSION['offset'] = $_SESSION['offset'] - 100;
            }
            else {
                $_SESSION['offset'] = 0;
            }
            break;
        case '3':
            if($_SESSION['offset'] < $_SESSION['total'] - 100){
                $_SESSION['offset'] = $_SESSION['offset'] + 100;
            }
            else {
                $_SESSION['offset'] = $_SESSION['total'] - 100;
            }
            break;
        case '4':
            $_SESSION['offset'] = $_SESSION['total'] - 100;
            break;
    }

    $manga = apiCall('https://api.mangadex.org/manga/' . $_SESSION['Id'] . '/feed?translatedLanguage[]=' . $_SESSION['lang'] . '&order[volume]=asc&order[chapter]=asc&offset=' . $_SESSION['offset']);

    echo json_encode($manga);
?>