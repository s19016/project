<?php
    require_once("../env.php");

    $host = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    $dsn = "mysql:host=$host;dbname=$db;charaset=utf8mb4";

    if ($_POST) {
        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            $search_word = $_POST['word'];
            if($search_word==""){
              echo "input search word";
            }
            else{
                $sql ="select * from blog where title like '".$search_word."%'";
                $sth = $pdo->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();
                if($result){
                    foreach ($result as $row) {
                        echo $row['title']." ";
                        echo $row['category'];
                        echo $row['post_at'];
                        echo "<br />";
                    }
                }
                else{
                    echo "not found";
                }
            }
        }catch (PDOException $e) {
            echo  "<p>Failed : " . $e->getMessage()."</p>";
            exit();
        }
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>test</title>
</head>
<body>
    <div>ブログ検索</div>
    <form action="" method="POST">
        <label>検索：</label>
        <input type="text" name="word" />　<input type="submit" value="Search" />
    </form>
</body>
</html>