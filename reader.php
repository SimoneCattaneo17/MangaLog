<!DOCTYPE html>
<html>
    <head>
        <meta name="referrer" content="no-referrer" />
        <link rel="stylesheet" href="./CSS/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="./JavaScript/script.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

        <link rel="icon" href="./IMG/icon.jpg">
    </head>
    <body class="body">
    <div id="overlay">
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
                                    <a class="nav-link" href="chapters.php?search=ok&random=ok&lang=en">Random</a>
                                </li>
                            </ul>

                            <ul class="navbar-nav ms-auto">
                                <?php

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
                                <!--
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

        if(isset($_GET['chapterId'])) {
            $chapterId = $_GET['chapterId'];

            $url = 'https://api.mangadex.org/at-home/server/' . $chapterId;
            
            $chapter = apiCall($url);

            $hash = $chapter["chapter"]["hash"];
            $pages = $chapter["chapter"]["dataSaver"];

            $baseUrl = 'https://uploads.mangadex.org/data-saver/' . $hash . '/';
            for($i = 0; $i < count($pages); $i++) {
                $url = $baseUrl . $pages[$i];
                echo '<div class="divCenter">';
                    echo '<img class="pages" src="' . $url . '" alt="' . 'Page No. ' . $i . '">';
                echo '</div>';
                echo '<br>';
                echo '<div class="divCenter">';
                    echo $i + 1 . '/' . count($pages);
                echo '</div>';
                echo '<br>';
            }
        }
        else {
            header('Location:index.php');
        }
        ?>
    </body>
</html>