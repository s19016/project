<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>test</title>
</head>

<body>
    <div>Search user name</div>
    <form action="../blog/search_result.php" method="GET">
        <label>ブログタイトル：</label>
        <input type="text" name="word" required />　<input type="submit" value="検索" />
    </form>
    <form action="../blog/search_result.php" method="GET">
        <div class="form-item">
            <label class="label" for="pull-down">年代</label>
            <select class="pull-down" name="pull-down" id="pull-down" placeholder="年代">
                <option value="10years">10代</option>
                <option value="20years">20代</option>
                <option value="30years">30代</option>
                <option value="40years">40代</option>
                <option value="50years">50代</option>
                <option value="60years">60代以上</option>
            </select><!-- /# -->
        </div>
        <input type="submit" value="検索" />
    </form>
</body>

</html>