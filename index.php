<?php
    session_start();
?>
<html>
    <head>
        <meta name="referrer" content="no-referrer" />
        <link rel="stylesheet" href="./CSS/style.css">
        <script src="./JavaScript/script.js"></script>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
    </head>
    <body class="body">
        <form action="ricerca.php" method="post">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="searchbar">
                    <input class="search_input" type="text" name="manga" placeholder="Search..." autocomplete="off">
                    <button type="submit" class="search_icon"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        </form>

        <!-- aggiungere il bottone per un manga casuale -->
        <!-- https://api.mangadex.org/manga/random -->
    </body>
</html>