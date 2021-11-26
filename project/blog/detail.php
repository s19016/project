<?php

//①require_onceを使ってみよう！
require_once('./blog.php');

$blog = new Blog;
$result = $blog->getById($_GET['id']);

//require_once("../chat/chat_home.php");
$stmt = select2();
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
        if ($result['id'] == $message['blog_id']){
        echo $message['time'], "：　", $message['name'], "：", $message['message'];
        echo '<br>';
        }
    }

    // 投稿内容を登録
    if (isset($_POST["send"])) {
        insert();
        // 投稿した内容を表示
        $stmt = select_new();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
            echo $message['time'], "：　", $message['name'], "：", $message['message'];
            echo '<br>';
        }
    }

    // DB接続
    function connectDB()
    {
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;

        $dsn = "mysql:host=$host;dbname=$db;charaset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            return $pdo;
        } catch (PDOException $e) {
            echo '失敗です' . $e->getMessage();
            exit();
        }
    }


    // DBから投稿内容を取得

    // DBから投稿内容を取得(最新の1件)
    function select_new()
    {
        $dbh = connectDB();
        $sql = "SELECT * FROM message ORDER BY time desc limit 1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function select2()
    {
        $dbh = connectDB();
        $sql ="SELECT * FROM message inner join blog on message.blog_id = blog.id order by message.time desc"; 
        //$sql1 = "SELECT * FROM message WHERE blog.id = '" . $sql . "'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // DBから投稿内容を登録
    function insert()
    {
        $dbh = connectDB();
        $sql = "INSERT INTO message (blog_id, name, message, time) VALUES (:blog_id, :name, :message, now())";
        $stmt = $dbh->prepare($sql);
        $params = array(':blog_id' => $_GET['id'], ':name' => $_POST['name'], ':message' => $_POST['message']);
        $stmt->execute($params);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ詳細</title>
</head>

<body>
    <h2>ブログ詳細</h2>
    <h3>タイトル:<?php echo $result['title'] ?></h3>
    <p>投稿日時:<?php echo $result['post_at'] ?></p>
    <p>カテゴリー:<?php echo $blog->setCategoryName($result['category']) ?></p>
    <hr>
    <p>本文:<?php echo $result['content'] ?></p>
    <form method="post">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="message" placeholder="メッセージ">

        <button name="send" type="submit">送信</button>

        <p>チャット履歴</p>
    </form>
    <p?><a href="blog_home.php">戻る</a></p>

</body>

</html>