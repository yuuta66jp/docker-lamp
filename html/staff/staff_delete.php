<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ろくまる農園</title>
</head>
<body>

<?php

try {
  // スタッフcodeをGETで受け取る(URLパラメータで受け取る)
  $staff_code = $_GET['staffcode'];

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // codeカラム,nameカラムのデータを全て取得
  $sql = 'SELECT name FROM mst_staff WHERE code=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $staff_code;
  $stmt->execute($data);

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  // 取り出したスタッフ名を変数にコピー
  $staff_name = $rec['name'];

  $dbh = null;

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

スタッフ削除<br />
<br />
スタッフコード<br />
<?php print $staff_code; ?>
<br />
スタッフ名<br />
<?php print $staff_name; ?>
<br />
このスタッフを削除してよろしいですか？<br />
<be />
<form method="post" action="staff_delete_done.php">
<!-- hiddenでcodeを渡す -->
<input type="hidden" name="code" value="<?php print $staff_code; ?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>