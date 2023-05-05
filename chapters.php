<!DOCTYPE html>
<?php
    session_start();
?>
<html>

<head>
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

    <link rel="icon" href="./IMG/icon.jpg">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body class="body">
    <div>
        <form action="ricerca.php?offset=0&manga=null&lang=en" method="post">
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" name="manga" autocomplete="off">
                                        <button onclick="loading()" class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="chapters.php?search=ok&random=ok&offset=000&lang=en">Random</a>
                                </li>
                            </ul>

                            <ul class="navbar-nav ms-auto">
                                <?php
                                $lines = file('./languages.txt');
                                echo '<select id="selectLangChapter" class="form-select" onchange="languageChangeChapter()">';
                                foreach ($lines as $line) {
                                    $line = rtrim($line, "\n");
                                    echo '<option value="' . $line . '">' . $line . '</option>';
                                }
                                echo '</select>';

                                echo '
                                <script>
                                    var langIndex = localStorage.getItem("langIndex");
                                    if (lang == null) {
                                        lang = "en";
                                    }
                                    document.getElementById("selectLangChapter").value = lang;
                                </script>
                            ';
                                ?>
                                <!-- needed later
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </li>
                                -->
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        </form>
    </div>
    <?php

    require __DIR__ . '/functions.php';

    $lang = "en"; //default
    if (isset($_GET['search'])) {
        if(isset($_GET['offset'])){
            $offset = $_GET['offset'];
            $_SESSION['offset'] = $offset;
        }
        if (isset($_GET['random']) && $_GET['random'] == 'ok') {
            $url = 'https://api.mangadex.org/manga/random';
            
            $manga = apiCall($url);

            $_SESSION['Id'] = $manga["data"]["id"];
            $_SESSION['title'] = $manga["data"]["attributes"]["title"]["en"];
            for ($i = 0; $i < count($manga["data"]["relationships"]); $i = $i + 1) {
                if ($manga["data"]["relationships"][$i]["type"] == "cover_art") {
                    $_SESSION['cover'] = $manga["data"]["relationships"][$i]["id"];
                    break;
                }
            }
            $_SESSION['lang'] = $_GET['lang'];

            $url = 'https://api.mangadex.org/cover/' . $_SESSION['cover'];
            
            $cover = apiCall($url);

            $_SESSION['cover'] = $cover["data"]["attributes"]["fileName"];
        }
        else {
            $_SESSION['lang'] = $_GET['lang'];
        }

        if (isset($_GET['Id'])) {
            $_SESSION['Id'] = $_GET['Id'];
            $_SESSION['title'] = $_GET['title'];
            $_SESSION['lang'] = $_GET['lang'];
            $_SESSION['cover'] = $_GET['cover'];
        }

        echo '<div class="divDatiManga">';

            //cover
            echo '<div class="divCover">';

                echo '<h1>' . $_SESSION['title'] . '</h1>' . '<br>';

                echo '<img class="cover" src="https://uploads.mangadex.org/covers/' . $_SESSION['Id'] . '/' . $_SESSION['cover'] . '.512.jpg" alt="cover art" />';

                $url = 'https://api.mangadex.org/manga/' . $_SESSION['Id'] . '/feed?translatedLanguage[]=' . $_SESSION['lang'] . '&order[volume]=asc&order[chapter]=asc&offset=' . $_SESSION['offset'];
            
            $chapters = apiCall($url);

            $total = $chapters['total'];
            $_SESSION['total'] = $total;
            echo '<br>';

            //bottoni cambio pagina
            echo '<div class="divCenter" style="padding-top: 10%">';

            echo '<div>';
            echo '<button onclick="changePage(1)" id="first" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_left</span></button>';
            echo '</div>';

            echo '<div>';
            echo '<button onclick="changePage(2)" id="previous" style="display: block;"><span class="material-symbols-outlined">chevron_left</span></button>';
            echo '</div>';

            echo '<div>';
            echo '<button onclick="changePage(3)" id="next" style="display: block;"><span class="material-symbols-outlined">chevron_right</span></button>';
            echo '</div>';

            echo '<div>';
            echo '<button onclick="changePage(4)" id="last" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_right</span></button>';
            echo '</div>';

            echo '<br>';
            echo '</div>';
            echo '</div>';

            //capitoli
            echo '<div class="divCapitoli" id="capitoli">';

                if (count($chapters["data"]) == 0) {
                    echo 'Nessun capitolo disponibile nella lingua selezionata';
                } 
                else {
                    for ($i = 0; $i < count($chapters["data"]); $i = $i + 1) {
                        $reader = 'reader.php?chapterId=' . $chapters["data"][$i]["id"];
                        echo '<a onclick="loading()" href="' . $reader . '">' . 'volume ' . $chapters["data"][$i]["attributes"]["volume"] . ' chapter ' . $chapters["data"][$i]["attributes"]["chapter"] . ' ' . $chapters["data"][$i]["attributes"]["title"] . '</a>' . '<br>';
                    }
                }

            echo '</div>';

        echo '</div>';
    }
    else {
        header('Location:index.php');
    }
    ?>

<script src="./JavaScript/script.js"></script>
</body>

</html>