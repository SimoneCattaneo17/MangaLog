<!DOCTYPE html>
<html>

<head>
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

    <link rel="icon" href="./IMG/icon.jpg">
</head>

<body class="body">
    <div>
        <form action="ricerca.php" method="post">
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
                                <?php
                                    if(isset($_COOKIE['jwt'])){
                                        echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="chapters.php?random=ok">Random</a>
                                        </li>
                                        ';
                                    }
                                ?>
                            </ul>

                            <ul class="navbar-nav ms-auto">
                                <?php
                                if (isset($_COOKIE['jwt'])) {
                                    echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="logout.php">Logout</a>
                                        </li>
                                        ';
                                } else {
                                    echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="login.php">Login</a>
                                        </li>
                                        ';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        </form>
    </div>
    <?php

    session_start();

    require __DIR__ . '/functions.php';

    $lang = "en";

    if (isset($_POST['manga'])) {
        $manga = $_POST["manga"];
    } else {
        if (isset($_SESSION['manga'])) {
            $manga = $_SESSION['manga'];
        } else {
            $manga = "";
        }
    }
    $_SESSION['manga'] = $manga;
    $_SESSION['lang'] = $lang;
    $url = 'https://api.mangadex.org/manga?title=' . str_replace(' ', '%20', $manga);

    $mangas = apiCall($url);

    $total = $mangas["total"];
    $_SESSION['total'] = $total;

    $coverId = "";

    if (count($mangas["data"]) == 0) {
        echo '<h1>La ricerca non ha dato risultati</h1>';
    } else {
        echo '<div class="divCenter">';
        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(1)" id="firstPage" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_left</span></button>';
        echo '</div>';

        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(2)" id="previousPage" style="display: block;"><span class="material-symbols-outlined">chevron_left</span></button>';
        echo '</div>';

        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(3)" id="nextPage" style="display: block;"><span class="material-symbols-outlined">chevron_right</span></button>';
        echo '</div>';

        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(4)" id="lastPage" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_right</span></button>';
        echo '</div>';
        echo '</div>';
        echo '<div id="container">';
        for ($j = 0; $j < count($mangas["data"]); $j = $j + 1) {
            for ($i = 0; $i < count($mangas["data"][$j]["relationships"]); $i = $i + 1) {
                if ($mangas["data"][$j]["relationships"][$i]["type"] == "cover_art") {
                    $coverId = $mangas["data"][$j]["relationships"][$i]["id"];
                    break;
                }
            }
            $mangaId = $mangas["data"][$j]["id"];

            $url = 'https://api.mangadex.org/cover/' . $coverId;

            $cover = apiCall($url);

            $imgFilename = $cover["data"]["attributes"]["fileName"];

            $sendUrl = 'chapters.php?Id=' . $mangaId . '&title=' . $mangas["data"][$j]["attributes"]["title"]["en"] . '&cover=' . $imgFilename . '&lang=' . $lang;

            echo '<div class="divDati" id="divDati">';
            echo '<div class="divCover" id="divCover">';
            echo '<a onclick="loading()" ' . 'id="' . $j . '" href="' . $sendUrl . '"><img class="cover" src="https://uploads.mangadex.org/covers/' . $mangaId . '/' . $imgFilename . '.256.jpg" alt="cover art" /></a>';
            echo '</div>';

            echo '<div class="divScritte" id="divScritte">';
            echo '<h3>' . $mangas["data"][$j]["attributes"]["title"]["en"] . '</h3>' . '<br>';
            if (isset($mangas["data"][$j]["attributes"]["description"]["en"]) && $mangas["data"][$j]["attributes"]["description"]["en"] != "") {
                echo substr($mangas["data"][$j]["attributes"]["description"]["en"], 0, 150) . '...' . '<br>';
            } else {
                echo 'No description available';
            }
            echo '</div>';
            echo '</div>';
            echo '<br>';
        }

        echo '</div>';
        echo '<div class="divCenter">';
        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(1)" id="firstPage" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_left</span></button>';
        echo '</div>';

        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(2)" id="previousPage" style="display: block;"><span class="material-symbols-outlined">chevron_left</span></button>';
        echo '</div>';

        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(3)" id="nextPage" style="display: block;"><span class="material-symbols-outlined">chevron_right</span></button>';
        echo '</div>';

        echo '<div style="padding: 2px">';
        echo '<button class="btn btn-dark rounded" onclick="pclick(4)" id="lastPage" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_right</span></button>';
        echo '</div>';
        echo '</div>';
    }

    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/cesiumjs/1.78/Build/Cesium/Cesium.js"></script>
    <script src="./JavaScript/script.js"></script>
</body>

</html>