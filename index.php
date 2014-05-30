<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
    	<div class="container">

<?php

// データベース接続情報設定
$dsn = 'mysql:dbname=books_admin;host=localhost;charset=utf8';

$db_username = 'root';
$db_password = '';

// データベース接続
$conn = new PDO($dsn, $db_username, $db_password);

if(!$conn)
{
    echo '接続失敗';
}
else
{
    echo '接続成功';
}

// 検索SQL作成
$sql =<<<EOS
SELECT `id`, `book_name`, `author_name` FROM `books`
EOS;

// SQL実行準備
$stmt = $conn->prepare($sql);

// SQL実行
$result = $stmt->execute();

?>
    <a href="add_form.php" class="btn btn-primary">図書データ新規登録フォーム</a>

    <table class="table table-striped table-hover">
        <tr>
            <th>ID</th>
            <th>図書名</th>
            <th>著者名</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
<?php

// 検索結果取得
while($row = $stmt->fetch()) 
{
    $book_id = $row['id'];
?>
    <tr>
        <td><?php echo $book_id; ?></td>
        <td><?php echo $row['book_name']; ?></td>
        <td><?php echo $row['author_name']; ?></td>
        <td>
            <a href="edit_form.php?book_id=<?php echo $book_id; ?>">編集</a>
        </td>
        <td>
            <a href="delete.php?book_id=<?php echo $book_id; ?>">削除</a>
        </td>
    </tr>
    <?php
}
?>
		    </table>
        </div>
    </body>
</html>
