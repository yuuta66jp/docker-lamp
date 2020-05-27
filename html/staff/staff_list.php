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
  print $_SESSION[staff_name];
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

try {

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // codeカラム,nameカラムのデータを全て取得
  $sql = 'SELECT code,name FROM mst_staff WHERE 1';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh = null;

  print 'スタッフ一覧<br /><br />';

  print '<form method="post" action="staff_branch.php">';
  // 繰り返し処理
  while(true) {
    // $stmtから１レコードを取り出す
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
    }
    // スタッフのcodeをvalueに渡す
    print '<input type="radio" name="staffcode" value="'.$rec['code'].'">';
    print $rec['name'];
    print '<br />';
  }
  print '<input type="submit" name="disp" value="参照">';
  print '<input type="submit" name="add" value="追加">';
  print '<input type="submit" name="edit" value="修正">';
  print '<input type="submit" name="delete" value="削除">';
  print '</form>';

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

<br />
<a href="../staff_login/staff_top.php">トップメニューへ</a><br />

</body>
</html>