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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <link rel="icon" href="./IMG/icon.jpg">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                                $lines = file('./languages.txt');
                                if(!isset($_GET['random'])) {
                                    echo '<select id="selectLangChapter" class="form-select" onchange="languageChangeChapter()">';
                                    foreach ($lines as $line) {
                                        $line = rtrim($line, "\n");
                                        echo '<option value="' . $line . '">' . $line . '</option>';
                                    }
                                    echo '</select>';
                                }
                                
                                if(isset($_COOKIE['jwt'])){
                                    echo '
                                    <li class="nav-item">
                                        <a class="nav-link" href="logout.php">Logout</a>
                                    </li>
                                    ';
                                }
                                else{
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

    require __DIR__ . '/functions.php';

    if(!isset($_GET['lang'])) {
        $lang = 'en';
    }  
    else{
        $lang = $_GET['lang'];
    }

    if(isset($_COOKIE['jwt']) && is_jwt_valid($_COOKIE['jwt'])){
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

            $url = 'https://api.mangadex.org/cover/' . $_SESSION['cover'];
            
            $cover = apiCall($url);

            $_SESSION['cover'] = $cover["data"]["attributes"]["fileName"];
        }
        else {
            if (isset($_GET['Id']) && isset($_GET['title']) && isset($_GET['cover'])) {
                $_SESSION['Id'] = $_GET['Id'];
                $_SESSION['title'] = $_GET['title'];
                $_SESSION['cover'] = $_GET['cover'];
            }
            else{
                header('Location: index.php');
            }
        }

        echo '<div class="divDatiManga">';

            //cover
            echo '<div class="divCover">';

                echo '<h1>' . $_SESSION['title'] . '</h1>' . '<br>';

                echo '<img class="cover" src="https://uploads.mangadex.org/covers/' . $_SESSION['Id'] . '/' . $_SESSION['cover'] . '.512.jpg" alt="cover art" />';

                $url = 'https://api.mangadex.org/manga/' . $_SESSION['Id'] . '/feed?translatedLanguage[]=' . $lang . '&order[volume]=asc&order[chapter]=asc';
            
            $chapters = apiCall($url);

            $total = $chapters['total'];
            $_SESSION['total'] = $total;
            echo '<br>';

            echo '<div class="divCenter" style="padding-top: 10%" id="addRemove">';
                $ip = '127.0.0.1';
                $username = 'mangalog';
                $pwd = 'mangalogUser';
                $database = 'mangalog';
                $connection = new mysqli($ip, $username, $pwd, $database);
            
                if($connection->connect_error) {
                    die('C/errore: ' . $connection->connect_error);
                }

                $sql = "LOCK TABLES usercollection WRITE";
                $connection->query($sql);
                $sql = "LOCK TABLES usercollection READ"; 
                $connection->query($sql);
                $sql = "SELECT * FROM usercollection WHERE idManga = '".$_SESSION['Id']."' AND idUtente = '".get_jwt_id($_COOKIE['jwt'])."'";
                $result = connect($sql);
                $sql = "UNLOCK TABLES";
                $connection->query($sql);
                if($result->num_rows > 0){
                    echo '<button type="button" class="btn btn-dark rounded-circle" onclick="addRemoveCollection(\''.$_SESSION['Id'].'\', \'remove\', ' .get_jwt_id($_COOKIE['jwt']).')"><i class="fas fa-bookmark"></i></button>';
                }
                else{
                    echo '<button type="button" class="btn btn-dark rounded-circle" onclick="addRemoveCollection(\''.$_SESSION['Id'].'\', \'add\', ' .get_jwt_id($_COOKIE['jwt']).')"><i class="far fa-bookmark"></i></button>';
                }
            echo '</div>';
        
            //bottoni cambio pagina
            echo '<div class="divCenter" style="padding-top: 10%">';

            echo '<div style="padding: 1%">';
                echo '<button type="button" class="btn btn-dark rounded" onclick="changePage(1)" id="first" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_left</span></button>';
            echo '</div>';

            echo '<div style="padding: 1%">';
                echo '<button type="button" class="btn btn-dark rounded" onclick="changePage(2)" id="previous" style="display: block;"><span class="material-symbols-outlined">chevron_left</span></button>';
            echo '</div>';

            echo '<div style="padding: 1%">';
                echo '<button type="button" class="btn btn-dark rounded" onclick="changePage(3)" id="next" style="display: block;"><span class="material-symbols-outlined">chevron_right</span></button>';
            echo '</div>';

            echo '<div style="padding: 1%">';
                echo '<button type="button" class="btn btn-dark rounded" onclick="changePage(4)" id="last" style="display: block;"><span class="material-symbols-outlined">keyboard_double_arrow_right</span></button>';
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
        echo '
        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <h1>
                    To access this page you must be logged in
                </h1>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <h4>
                    If you want to do so click <a href="login.php">here</a>
                </h4>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <h4>
                    If you don\'t have an account click <a href="signUp.php">here</a>
                </h4>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <h4>
                    If you want to go back to the homepage click <a href="index.php">here</a>
                </h4>
            </div>
        </div>
    ';
    }
    ?>

<script src="./JavaScript/script.js"></script>
</body>

</html>