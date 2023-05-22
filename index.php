<!DOCTYPE html>
<?php

require __DIR__ . '/functions.php';

session_start();
session_destroy();

if(isset($_POST['username'])){
    
}
?>
<html>

<head>
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="./CSS/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

    <link rel="icon" href="./IMG/icon.jpg">
</head>

<body class="body" id="body">

    <div>
        <form id="form" action="ricerca.php?offset=0&lang=en" method="post">
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" name="manga" autocomplete="off">
                                        <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="loading()"><i class="fas fa-search"></i></button>
                                    </div>
                                </li>
                                <?php
                                    if(isset($_COOKIE['jwt'])){
                                        echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="chapters.php?search=ok&random=ok&offset=000&lang=en">Random</a>
                                        </li>
                                        ';
                                    }
                                ?>
                            </ul>

                            <ul class="navbar-nav ms-auto">
                                <?php
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

        <?php
            if(isset($_COOKIE['jwt'])){
                $jwt = $_COOKIE['jwt'];
                $userId = get_jwt_id($jwt);
                
                $ip = '127.0.0.1';
                $username = 'root';
                $pwd = '';
                $database = 'mangalog';
                $connection = new mysqli($ip, $username, $pwd, $database);

                if($connection->connect_error) {
                    die('C/errore: ' . $connection->connect_error);
                }

                $sql = "LOCK TABLES usercollection WRITE";
                $connection->query($sql);
                $sql = "LOCK TABLES usercollection READ"; 
                $connection->query($sql);

                $sql = "SELECT * FROM usercollection WHERE idUtente = '$userId'";
                $result = $connection->query($sql);

                $sql = "UNLOCK TABLES";
                $connection->query($sql);

                if($result->num_rows > 0){
                    echo '
                        <div class="d-flex justify-content-center">
                            <div class="d-flex justify-content-center">
                                <h1>
                                    Your Collection
                                </h1>
                            </div>
                            <br>
                        </div>
                    ';
                    $ids = array();
                    echo '
                    <div id="container">
                    ';
                    while($row = $result->fetch_assoc()){
                        array_push($ids, $row['idManga']);
                    }
                    $ids = array_reverse($ids);
                    for($j = 0; $j < count($ids); $j++){
                        $url = 'https://api.mangadex.org/manga/' . $ids[$j];
                        $response = apiCall($url);
                        for ($k = 0; $k < count($response["data"]["relationships"]); $k++) {
                            if ($response["data"]["relationships"][$k]["type"] == "cover_art") {
                                $coverId = $response["data"]["relationships"][$k]["id"];
                                break;
                            }
                        }

                        $url = 'https://api.mangadex.org/cover/' . $coverId;

                        $cover = apiCall($url);

                        $imgFilename = $cover["data"]["attributes"]["fileName"];

                        $lang = "en";

                        $sendUrl = 'chapters.php?search=ok&Id=' . $ids[$j] . '&title=' . $response["data"]["attributes"]["title"]["en"] . '&cover=' . $imgFilename . '&lang=' . $lang . '&offset=000';

                        echo '<div class="divDati" id="divDati' . $j . '">';
                        echo '<div class="divCover" id="divCover">';
                        echo '<a onclick="loading()" ' . 'id="' . $j . '" href="' . $sendUrl . '"><img class="cover" src="https://uploads.mangadex.org/covers/' . $ids[$j] . '/' . $imgFilename . '.256.jpg" alt="cover art" /></a>';
                        echo '</div>';

                        echo '<div class="divScritte" id="divScritte">';
                        echo '<h3>' . $response["data"]["attributes"]["title"]["en"] . '</h3>' . '<br>';
                        if(isset($response["data"]["attributes"]["description"]["en"]) && $response["data"]["attributes"]["description"]["en"] != "") {
                            echo substr($response["data"]["attributes"]["description"]["en"], 0, 150) . '...' . '<br>';
                        }
                        else {
                            echo 'No description available';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<br>';
                    }
                    echo '</div>';
                }
                else {
                    echo '
                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-center">
                            <h1>
                                Your collection is empty :(
                            </h1>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-center">
                            <h4>
                                You can add mangas to your collection by searching them and clicking on the Bookmark button
                            </h4>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-center">
                            <h4>
                                You can also add mangas to your collection by searching for a random one clicking <a href="chapters.php?search=ok&random=ok&offset=000&lang=en">here</a> or on the Random button in the navbar
                            </h4>
                        </div>
                    </div>
                    ';
                }
            }
            else {
                echo '
                <div class="d-flex justify-content-center">
                    <img src="./IMG/icon.jpg" style="width: 20%; height: 20%">
                </div>
                <div class="d-flex justify-content-center">
                    <h4>
                        Search and read your favorite mangas<br>
                    </h4>
                </div>
                ';
            }
        ?>
    </div>
    
    <footer style="top: 90%;">
        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <h6>
                    Made by <a href="https://github.com/SimoneCattaneo17">Simone Cattaneo</a>
                </h6>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <h6>
                    Credits <a href="https://api.mangadex.org">Mangadex Api</a>
                </h6>
            </div>
        </div>
    </footer>

    <script src="./JavaScript/script.js"></script>
</body>

</html>