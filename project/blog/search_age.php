<?php
require_once('./blog.php');
// 取得したデータを表示

//$login_user = $_SESSION['login_user'];
$blog = new Blog();
$blogData = $blog->getAll();

function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

$dsn = 'mysql:host=localhost;dbname=blog_app';
$username = 'tnjya';
$password = 'Tnjya0517';

if ($_GET) {
    try {
        $dbh = new PDO($dsn, $username, $password);
        $search_word = $_GET['age'];
        if ($search_word == "") {
            echo "年代を入力してください";
        } else {
            $sql = "select * from blog where age = " . $search_word . "";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll();
            if ($result) {
                foreach ($result as $row) {
                }
            } else {
                foreach ($result as $row){
                echo "ブログはありません";
                }
            }
        }
    } catch (PDOException $e) {
        echo  "<p>Failed : " . $e->getMessage() . "</p>";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/style.css">
    <title>ブログ一覧</title>
</head>

<body>

    <!-- /.header -->
    <section class="post">
        <h2 class="post-title">
        <h2 class="post-inner-contents-text-title"><?php echo h($blogData['title']) ?></h2>
            <div class="post-btn"><a href="./blog_form.php">新規作成</a></div><!-- /.post-btn -->
            <div class="post-inner">
                <?php foreach ($result as $column) : ?>
                    <a class="post-inner-contents" href="detail.php?id=<?php echo $column['id'] ?>">
                        <div class="post-inner-contents-visual">
                            <img src="../src/image/create-gc4989cf33_1920.jpg" alt="イメージ画像">
                        </div><!-- /.post-inner-contents-visual -->
                        <div class="post-inner-contents-text">
                            <h2 class="post-inner-contents-text-title"><?php echo h($column['title']) ?></h2>
                            <p class="post-inner-contents-text-category"><?php echo h($blog->setCategoryName($column['category'])) ?></p>
                            <p class="post-inner-contents-text-time"><?php echo h($column['post_at']) ?></p>
                        </div><!-- /.post-inner-contents-text -->
                    </a><!-- /.post-inner-contents -->
                <?php endforeach; ?>
            </div>
    </section><!-- /.post -->
</body>

</html>