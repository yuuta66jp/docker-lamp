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

  $pro_name = $_POST['name'];
  $pro_price = $_POST['price'];
  $pro_gazou_name = $_POST['gazou_name'];

  $pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
  $pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');
  // dsn情報
  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  // データベースに接続
  $dbh = new PDO($dsn, $user, $password);
  // ドライバオプション(SQL実行時のエラー発生時の処理,PDO::ERRMODE_EXCEPTIONで例外をスロー)
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // SQL文を変数に代入
  $sql = 'INSERT INTO mst_product(name, price,gazou) VALUES (?, ?,?)';
  // prepareメソッドでSQL文を準備する
  $stmt = $dbh->prepare($sql);
  // VALUES値を設定
  $data[] = $pro_name;
  $data[] = $pro_price;
  $data[] = $pro_gazou_name;
  // executeメソッドでクエリを実行する
  $stmt->execute($data);
  // データベースから切断する
  $dbh = null;

  print $pro_name;
  print 'を追加しました。<br />';
  // エラー表示
} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

<a href="pro_list.php">戻る</a>

</body>
</html>
