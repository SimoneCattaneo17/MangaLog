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
    </head>
    <body class="body">
        <?php
        if(isset($_GET['chapterId'])) {
            $chapterId = $_GET['chapterId'];

            $url = 'https://api.mangadex.org/at-home/server/' . $chapterId;
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response_json = curl_exec($ch);
            $chapter=json_decode($response_json, true);

            curl_close($ch);

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
                    echo $i + 1 . '/' . count($pages) + 1;
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