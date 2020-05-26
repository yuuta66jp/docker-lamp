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

  $pro_code = $_POST['code'];
  $pro_gazou_name = $_POST['gazou_name'];

  // dsn情報
  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  // データベースに接続
  $dbh = new PDO($dsn, $user, $password);
  // ドライバオプション(SQL実行時のエラー発生時の処理,PDO::ERRMODE_EXCEPTIONで例外をスロー)
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // DELETE文でレコードを削除する
  $sql = 'DELETE FROM mst_product WHERE code=?';
  // prepareメソッドでSQL文を準備する
  $stmt = $dbh->prepare($sql);
  // VALUES値を設定
  $data[] = $pro_code;
  // executeメソッドでクエリを実行する
  $stmt->execute($data);
  // データベースから切断する
  $dbh = null;

  // 画像ファイルを削除する
  if ($pro_gazou_name != '') {
    unlink('./gazou/'.$pro_gazou_name);
  }

  // エラー表示
} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

削除しました。<br />
<br />
<a href="pro_list.php">戻る</a>

</body>
</html>
