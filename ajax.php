<?php
    session_start();

    require __DIR__ . '/functions.php';

    $manga = apiCall('https://api.mangadex.org/manga/' . $_SESSION['Id'] . '/feed?translatedLanguage[]=' . $_SESSION['lang'] . '&order[volume]=asc&order[chapter]=asc&offset=' . $_SESSION['offset']);

    echo json_encode($manga);
?>