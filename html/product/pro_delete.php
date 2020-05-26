<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ろくまる農園</title>
</head>
<body>

<?php

try {
  // 商品codeをGETで受け取る(URLパラメータで受け取る)
  $pro_code = $_GET['procode'];

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // nameカラム,gazouカラムのデータを全て取得
  $sql = 'SELECT name,gazou FROM mst_product WHERE code=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $pro_code;
  $stmt->execute($data);

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  // 取り出した商品名,画像を変数にコピー
  $pro_name = $rec['name'];
  $pro_gazou_name = $rec['gazou'];

  $dbh = null;

  if ($pro_gazou_name == '') {
    $disp_gazou = '';
  } else {
    $disp_gazou = '<img src="./gazou/'.$pro_gazou_name.'">';
  }

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

商品削除<br />
<br />
商品コード<br />
<?php print $pro_code; ?>
<br />
商品名<br />
<?php print $pro_name; ?>
<br />
<?php print $disp_gazou; ?>
<br />
この商品を削除してよろしいですか？<br />
<be />
<form method="post" action="pro_delete_done.php">
<!-- hiddenでcodeを渡す -->
<input type="hidden" name="code" value="<?php print $pro_code; ?>">
<input type="hidden" name="gazou_name" value="<?php print $pro_gazou_name; ?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>