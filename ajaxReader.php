<?php
    session_start();

    ini_set('display_errors', 1);

    require __DIR__ . '/functions.php';

    if($_POST['buttonId'] == 1 && $_SESSION['currentPage'] < $_SESSION['countPages']) {
        $_SESSION['currentPage'] += 1;
    }
    else {
        if($_POST['buttonId'] == 0 && $_SESSION['currentPage'] > 0) {
            $_SESSION['currentPage'] -= 1;
        }
    }

    $page = new stdClass();
    $page->url = $_SESSION['baseUrl'] . $_SESSION['pages'][$_SESSION['currentPage']];
    $page->currentPage = $_SESSION['currentPage'];
    $page->totalPages = $_SESSION['countPages'];

    echo json_encode($page);
?>