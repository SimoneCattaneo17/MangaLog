<?php
    session_start();

    ini_set('display_errors', 1);

    require __DIR__ . '/functions.php';

    if(!isset($_SESSION['offset'])) {
        $_SESSION['offset'] = 0;
    }

    switch($_POST["buttonId"]){
        case 1:
            $_SESSION['offset'] = 0;
            break;
        case 2:
            if($_SESSION['offset'] > 10) {
                $_SESSION['offset'] = $_SESSION['offset'] - 10;
            }
            else {
                $_SESSION['offset'] = 0;
            }
            break;
        case 3:
            if($_SESSION['offset'] < $_SESSION['total'] - 10){
                $_SESSION['offset'] = $_SESSION['offset'] + 10;
            }
            else {
                $_SESSION['offset'] = $_SESSION['total'] - 10;
            }
            break;
        case 4:
            $_SESSION['offset'] = $_SESSION['total'] - 10;
            break;
    }

    $manga = apiCall('https://api.mangadex.org/manga?title=' . $_SESSION['manga'] . '&offset=' . $_SESSION['offset']);

    echo json_encode($manga);
?>