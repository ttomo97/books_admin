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
                <h3>貸出 入力画面</h3>
            </div>

            <form action="add.php" method="post" class="form-horizontal" role="form">

                <div class="form-group">
                    <label class="col-md-2 control-label">利用者ID</label>
                    <div class="col-md-4">
                        <input type="text" name="user_id" class="form-control" />
                    </div>
                </div>

<?php
$count = 0;
for($i = 0; $i < $_rental_limit_count; $i++)
{
    $count++;
?>
                <div class="form-group">
                    <label class="col-md-2 control-label">図書ID <?php echo $count; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="book_id[]" class="form-control" />
                    </div>
                </div>
<?php
}
?>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" value="登録" class="btn btn-primary" />

                        <a href="index.php" class="btn btn-default">貸出可能図書一覧</a>
                    </div>
                </div>
            </form>

        </div>

<?php
// フッタ出力
output_html_footer();
?>
    </body>
</html>
