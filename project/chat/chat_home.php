<section>
    <?php
    require_once("../env.php");
    // DBからデータ(投稿内容)を取得 
    // 投稿内容を表示
    $stmt = select2();
    foreach ($stmt as $message) {
        if ($message['blog.id'] ==$message['blog_id']){
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
</section>