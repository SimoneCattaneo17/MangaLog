<?php
    session_start();
?>
<html>
    <head>

    </head>
    <body>
        <form action="ricerca.php" method="post">
        Ricerca manga: <input type="text" name="manga"><br>
        <input type="submit">
        </form>
        <!-- aggiungere il bottone per un manga casuale -->
        <!-- https://api.mangadex.org/manga/random -->
    </body>
</html>