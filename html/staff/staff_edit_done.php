<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ろくまる農園</title>
</head>
<body>

<?php
// try~catchでエラー処理を行う
try {

  $staff_code = $_POST['code'];
  $staff_name = $_POST['name'];
  $staff_pass = $_POST['pass'];

  $staff_name = htmlspecialchars($staff_name, ENT_QUOTES, 'UTF-8');
  $staff_pass = htmlspecialchars($staff_pass, ENT_QUOTES, 'UTF-8');
  // dsn情報
  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  // データベースに接続
  $dbh = new PDO($dsn, $user, $password);
  // ドライバオプション(SQL実行時のエラー発生時の処理,PDO::ERRMODE_EXCEPTIONで例外をスロー)
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // UPDATE文にてレコード内容を上書きする
  $sql = 'UPDATE mst_staff SET name=?,password=? WHERE code=?';
  // prepareメソッドでSQL文を準備する
  $stmt = $dbh->prepare($sql);
  // VALUES値を設定
  $data[] = $staff_name;
  $data[] = $staff_pass;
  $data[] = $staff_code;
  // executeメソッドでクエリを実行する
  $stmt->execute($data);
  // データベースから切断する
  $dbh = null;

  // エラー表示
} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

修正しました。<br />
<br />
<a href="staff_list.php">戻る</a>

</body>
</html>
