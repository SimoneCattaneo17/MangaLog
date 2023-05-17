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

<body>
<?php

    require __DIR__ . '/functions.php';

    $ip = '127.0.0.1';
    $username = 'root';
    $pwd = '';
    $database = 'mangalog';
    $connection = new mysqli($ip, $username, $pwd, $database);

    if($connection->connect_error) {
        die('C/errore: ' . $connection->connect_error);
    }

    //sign up
    if(isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["pswd"])) {
        $_POST["pswd"] = md5($_POST["pswd"]);
        if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $sql = "lock tables users write";
            $sql = "lock tables users read";
            $sql = $connection -> prepare("INSERT INTO users (email, username, pswd) VALUES (?, ?, ?)");
            $em = $_POST["email"];
            $un = $_POST["username"];
            $ps = $_POST["pswd"];
            $sql->bind_param("sss", $em, $un, $ps);

            $sql->execute();
            $sql->close();
            $sql = "unlock tables";
        }
        else {
            header("Location: signUp.php?error=1");
        }
    }

    //login
    if(isset($_POST["username"]) && isset($_POST["pswd"]) && !isset($_POST["email"])) {
        $pswd = md5($_POST["pswd"]);
        $sql = "lock tables users write";
        $sql = "lock tables users read"; 
        $sql = "SELECT * FROM users WHERE username = '".$_POST["username"]."' AND pswd = '".$pswd."'";
        $result = $connection->query($sql);
        $sql = "unlock tables";
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            session_start();
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            
            $payload = array(
                'username' => $row['username'],
                'id' => $row['id'],
                'exp' => (time() + (86400 * 30)),
            );
            
            $jwt = generate_jwt($header, $payload);
            
            setcookie('jwt', $jwt, time() + (86400 * 30), "/");
            
            /*
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["pswd"] = $row["pswd"];
            $_SESSION["id"] = $row["id"];
            */
            header("Location: index.php");
        }
    }
?>
<section class="vh-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5">

                        <div class="text-center">
                            <h3 class="mb-5">Login</h3>
                        </div>

                        <form method="POST" action="login.php">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="typeEmailX-2">Username:</label>
                                <input type="text" name="username" id="typeUser-2" class="form-control form-control-lg" />
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="typePasswordX-2">Password:</label>
                                <input type="password" name="pswd" id="typePasswordX-2" class="form-control form-control-lg" />
                            </div>

                            <div class="text-center">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                            </div>
                        </form>

                        <br>

                        <div class="text-center">
                            <a href="signUp.php">
                                <button class="btn btn-primary btn-lg btn-block">Registrati</button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>