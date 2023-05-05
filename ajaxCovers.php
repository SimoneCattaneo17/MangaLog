<?php
    session_start();

    ini_set('display_errors', 1);

    require __DIR__ . '/functions.php';

    $manga = apiCall('https://api.mangadex.org/cover/' . $_POST['coverId']);

    echo json_encode($manga);
?>