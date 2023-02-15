<html>
    <head>
        <meta name="referrer" content="no-referrer" />
    </head>
    <body>
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
            //echo $url;
            echo '<img src="' . $url . '" alt="' . 'Page No. ' . $i . '">';
        }
    }
    else {
        header('Location:index.php');
    }
?>
    </body>
</html>