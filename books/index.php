<!DOCTYPE html>
<html>
<?php
require_once('../common.php');
// ヘッダ出力
output_html_header();
?>

    <body>
        <div class="container">
            <h3>図書データ一覧</h3>

<?php


// 検索条件有無フラグ
$is_search_option = false;

// 検索条件取得
if(isset($_GET['book_name']))
{
	$book_name = trim($_GET['book_name']);
	$is_search_option = true;
}
else
{
	$book_name = '';
}
if(isset($_GET['book_kana']))
{
	$book_kana = trim($_GET['book_kana']);
	$is_search_option = true;
}
else
{
	$book_kana = '';
}
if(isset($_GET['author_name']))
{
	$author_name = trim($_GET['author_name']);
	$is_search_option = true;
}
else
{
	$author_name = '';
}
if(isset($_GET['author_kana']))
{
	$author_kana = trim($_GET['author_kana']);
	$is_search_option = true;
}
else
{
	$author_kana = '';
}
?>
	<div>
    	<form action="index.php" method="get" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label">図書名</label>
                <div class="col-xs-4">
                    <input type="text" name="book_name" class="form-control" value="<?php echo $book_name; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">図書名カナ</label>
                <div class="col-xs-4">
                    <input type="text" name="book_kana" class="form-control" value="<?php echo $book_kana; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">著者名</label>
                <div class="col-xs-4">
                    <input type="text" name="author_name" class="form-control" value="<?php echo $author_name; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">著者名カナ</label>
                <div class="col-xs-4">
                    <input type="text" name="author_kana" class="form-control" value="<?php echo $author_kana; ?>" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="検索" class="btn btn-primary" />
                </div>
            </div>
        </form>
	</div>

    <a href="add_form.php" class="btn btn-primary">
        <i class="glyphicon glyphicon-file"></i> 図書データ新規登録フォーム
    </a>
<?php
// データベース接続
$conn = connect_database();

if(!$conn)
{
    echo '接続失敗';
    exit;
}

// 検索SQL作成
$sql =<<<EOS
SELECT
`id`, `book_name`, `book_kana`, `author_name`, `author_kana`, `created`, `updated`
FROM `books`
EOS;

// SQL条件句作成
if($is_search_option)
{
	$where = '';

	if(!empty($book_name))
	{
		if(empty($where))
		{
			$where .= ' WHERE ';
		}
		else
		{
			$where .= ' AND ';
		}

		$where .=<<<EOS
book_name LIKE :book_name
EOS;
	}

	if(!empty($book_kana))
	{
		if(empty($where))
		{
			$where .= ' WHERE ';
		}
		else
		{
			$where .= ' AND ';
		}

		$where .=<<<EOS
book_kana LIKE :book_kana
EOS;
	}

	if(!empty($author_name))
	{
		if(empty($where))
		{
			$where .= ' WHERE ';
		}
		else
		{
			$where .= ' AND ';
		}

		$where .=<<<EOS
author_name LIKE :author_name
EOS;
	}

	if(!empty($author_kana))
	{
		if(empty($where))
		{
			$where .= ' WHERE ';
		}
		else
		{
			$where .= ' AND ';
		}

		$where .=<<<EOS
author_kana LIKE :author_kana
EOS;
	}

	if(!empty($where))
	{
		$sql .= $where;
	}
}

// SQL実行準備
$stmt = $conn->prepare($sql);


// SQL条件句作成
if($is_search_option)
{
	if(!empty($book_name))
	{
    	$stmt->bindValue(':book_name', $book_name.'%');
	}

	if(!empty($book_kana))
	{
    	$stmt->bindValue(':book_kana', $book_kana.'%');
	}

	if(!empty($author_name))
	{
    	$stmt->bindValue(':author_name', $author_name.'%');
	}

	if(!empty($author_kana))
	{
    	$stmt->bindValue(':author_kana', $author_kana.'%');
	}
}

// SQL実行
$result = $stmt->execute();
?>
    <table class="table table-striped table-hover">
        <tr>
            <th>ID</th>
            <th>図書名</th>
            <th>図書名カナ</th>
            <th>著者名</th>
            <th>著者名カナ</th>
            <th>登録日時</th>
            <th>更新日時</th>
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
        <td><?php echo $row['book_kana']; ?></td>
        <td><?php echo $row['author_name']; ?></td>
        <td><?php echo $row['author_kana']; ?></td>
        <td><?php echo $row['created']; ?></td>
        <td><?php echo $row['updated']; ?></td>
        <td>
            <a href="edit_form.php?book_id=<?php echo $book_id; ?>" class="btn btn-default">
                <i class="glyphicon glyphicon-edit"></i> 編集
            </a>
        </td>
        <td>
            <a href="delete.php?book_id=<?php echo $book_id; ?>" class="btn btn-default" onclick="if(confirm('削除しますよー？')){return true;} return false;">
                <i class="glyphicon glyphicon-trash"></i> 削除
            </a>
        </td>
    </tr>
    <?php
}
?>
            </table>
        </div>

        <?php
        // フッタ出力
        output_html_footer();
        ?>
    </body>
</html>
