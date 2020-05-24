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

  print '<form method="post" action="staff_edit.php">';
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
  print '<input type="submit" value="修正">';
  print '</form>';

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

</body>
</html>