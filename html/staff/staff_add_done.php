<?php
session_start ();
// session_regenerate_id (true)でセッションIDをアクセス毎に変更する
session_regenerate_id (true);
// trueもしくはfalseを判定
if (isset ($_SESSION['login']) == false) {
  print 'ログインされていません。<br />';
  print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
} else {
  print $_SESSION['staff_name'];
  print 'さんログイン中<br />';
  print '<br />';
}
?>

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

  require_once('../common/common.php');

  $post = sanitize($_POST);
  $staff_name = $post['name'];
  $staff_pass = $post['pass'];

  // dsn情報
  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  // データベースに接続
  $dbh = new PDO($dsn, $user, $password);
  // ドライバオプション(SQL実行時のエラー発生時の処理,PDO::ERRMODE_EXCEPTIONで例外をスロー)
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // SQL文を変数に代入
  $sql = 'INSERT INTO mst_staff(name, password) VALUES (?, ?)';
  // prepareメソッドでSQL文を準備する
  $stmt = $dbh->prepare($sql);
  // VALUES値を設定
  $data[] = $staff_name;
  $data[] = $staff_pass;
  // executeメソッドでクエリを実行する
  $stmt->execute($data);
  // データベースから切断する
  $dbh = null;

  print $staff_name;
  print 'さんを追加しました。<br />';
  // エラー表示
} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

<a href="staff_list.php">戻る</a>

</body>
</html>
