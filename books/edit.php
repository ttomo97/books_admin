<!DOCTYPE html>
<html>
<?php
require_once('../common.php');
// ヘッダ出力
output_html_header();
?>

    <body>

<?php
// ナビゲーションバー出力
output_html_navbar();
?>

        <div class="container">
            <div class="page-header">
                <h3>図書データ更新 更新処理</h3>
            </div>
<?php

// 図書IDチェック
if(empty($_POST['book_id']))
{
    echo '図書が指定されていません';
    exit;
}

// 図書名のチェック
if(empty($_POST['book_name']))
{
    echo '図書名が未入力です。';
    exit;
}

// 著者名のチェック
if(empty($_POST['author_name']))
{
    echo '著者名が未入力です。';
    exit;
}

// 入力データの半角空白削除
$book_id = trim($_POST['book_id']);
$isbn = trim($_POST['isbn']);
$book_name = trim($_POST['book_name']);
$book_kana = trim($_POST['book_kana']);
$author_name = trim($_POST['author_name']);
$author_kana = trim($_POST['author_kana']);

// データベース接続
$conn = connect_database();

// データベース接続確認
if(!is_null($conn))
{
    // 新規登録SQL作成
    $sql =<<<EOS
UPDATE `books`
SET
  `book_name` = :book_name,
  `book_kana` = :book_kana,
  `author_name` = :author_name,
  `author_kana` = :author_kana,
  `isbn` = :isbn,
  `updated` = NOW()
WHERE `id` = :book_id
EOS;

    // SQL実行準備
    $stmt = $conn->prepare($sql);

    // 登録するデータを設定
    $stmt->bindValue(':book_name', $book_name);
    $stmt->bindValue(':book_kana', $book_kana);
    $stmt->bindValue(':author_name', $author_name);
    $stmt->bindValue(':author_kana', $author_kana);
    $stmt->bindValue(':isbn', $isbn);
    $stmt->bindValue(':book_id', $book_id);

    // SQL実行
    if($stmt->execute())
    {
?>
            <div class="alert alert-success">
                <strong>更新成功</strong>
                #<?php echo $book_id; ?>
            </div>
<?php
    }
    else
    {
?>
            <div class="alert alert-danger">
                <strong>更新失敗</strong>
                #<?php echo $book_id; ?>
                <?php print_r($stmt->errorInfo()); ?>
            </div>
<?php
    }
}
?>

            <a href="index.php" class="btn btn-default">図書データ一覧</a>
        </div>

<?php
// フッタ出力
output_html_footer();
?>
    </body>

</html>
