<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>test</title>
</head>

<body>
    <div>Search user name</div>
    <form action="../blog/search_title.php" method="GET">
        <label>ブログタイトル：</label>
        <input type="text" name="word" required />　<input type="submit" value="検索" />
    </form>
    <form action="../blog/search_age.php" method="GET">
        <div class="form-item">
            <label class="label" for="pull-down">年代</label>
            <select class="pull-down" name="age" id="age" placeholder="年代">
                <option value="1">10代</option>
                <option value="2">20代</option>
                <option value="3">30代</option>
                <option value="4">40代</option>
                <option value="5">50代</option>
                <option value="6">60代以上</option>
            </select><!-- /# -->
        </div>
        <input type="submit" value="検索" />
    </form>
</body>

</html>