 <?php
    session_start();

    ini_set('display_errors', 1);

    require __DIR__ . '/functions.php';

    $ip = '127.0.0.1';
    $username = 'mangalog';
    $pwd = 'mangalogUser';
    $database = 'mangalog';
    $connection = new mysqli($ip, $username, $pwd, $database);

    if($connection->connect_error) {
        $result = "error";
        die('C/errore: ' . $connection->connect_error);
    }

    if($_POST['operation'] == "add") {
        $sql = $connection -> prepare("INSERT INTO usercollection (idManga, idUtente) VALUES (?, ?)");
        $idManga = $_POST['mangaId'];
        $idUtente = $_POST['userId'];
        $sql->bind_param("si", $idManga, $idUtente); 
        $sql->execute();
        $sql->close();
        $result = "added";
    }
    else {
        $sql = $connection -> prepare("DELETE FROM usercollection WHERE idManga = ? AND idUtente = ?");
        $idManga = $_POST['mangaId'];
        $idUtente = $_POST['userId'];
        $sql->bind_param("si", $idManga, $idUtente); 
        $sql->execute();
        $sql->close();
        $result = "removed";
    }

    echo $result;
 ?>