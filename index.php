<!DOCTYPE html>
<?php
session_start();
session_destroy();
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
</head>

<body class="body" id="body">

    <div id="overlay">
        <form id="form" action="ricerca.php?offset=0&manga=null&lang=en" method="post">
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
                                <li class="nav-item">
                                    <a class="nav-link" href="chapters.php?search=ok&random=ok&lang=en">Random</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        </form>
    </div>

    <div class="h-100 d-flex align-items-center justify-content-center">
        <div id="loader">

        </div>
    </div>

    <!-- aggiungere il bottone per un manga casuale -->
    <!-- https://api.mangadex.org/manga/random -->

    <script src="./JavaScript/script.js"></script>
</body>

</html>