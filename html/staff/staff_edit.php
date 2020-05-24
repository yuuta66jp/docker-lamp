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

スタッフ修正<br />
<br />
スタッフコード<br />
<?php print $staff_code; ?>
<br />
<br />
<form method="post" action="staff_edit_check.php">
<!-- hiddenでcodeを渡す -->
<input type="hidden" name="code" value="<?php print $staff_code; ?>">
スタッフ名<br />
<input type="text" name="name" style="width:200px" value="<?php print $staff_name; ?>"><br />
パスワードを入力してください。<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう１度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>