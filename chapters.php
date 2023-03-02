<!DOCTYPE html>
<html>

<head>
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="./JavaScript/script.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
</head>

<body class="body">
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
                                    <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="random.php">Random</a>
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
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </form>
    <?php
    $lang = "en"; //default
    if (isset($_GET['Id'])) {
        $Id = $_GET['Id'];
        $title = $_GET['title'];
        $lang = $_GET['lang'];
        echo '<h1>' . $title . '</h1>' . '<br>';
        $coverId = $_GET['cover'];

        //utilizzare il coverId in qualche modo per mettere l'immagine

        $url = 'https://api.mangadex.org/manga/' . $Id . '/feed?translatedLanguage[]=' . $lang . '&order[volume]=asc&order[chapter]=asc';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response_json = curl_exec($ch);
        $chapters = json_decode($response_json, true);

        curl_close($ch);


        if (count($chapters["data"]) == 0) {
            echo '<h3>Nessun capitolo disponibile nella lingua selezionata</h3>';
        } else {
            for ($i = 0; $i < count($chapters["data"]); $i = $i + 1) {
                $reader = 'reader.php?chapterId=' . $chapters["data"][$i]["id"];
                echo '<a href="' . $reader . '">' . 'chapter ' . $chapters["data"][$i]["attributes"]["chapter"] . ' ' . $chapters["data"][$i]["attributes"]["title"] . '</a>' . '<br>';
            }
        }
    } else {
        header('Location:index.php');
    }
    ?>
</body>

</html>