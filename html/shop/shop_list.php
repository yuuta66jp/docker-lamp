<?php
session_start ();
// session_regenerate_id (true)でセッションIDをアクセス毎に変更する
session_regenerate_id (true);
// trueもしくはfalseを判定
if (isset ($_SESSION['member_login']) == false) {
  print 'ようこそゲスト様　';
  print '<a href=" member_login.html">会員ログイン</a><br />';
  print '<br />';
} else {
  print 'ようこそ';
  print $_SESSION['member_name'];
  print '様　';
  print '<a href=" member_logout.php">ログアウト</a><br />';
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
  $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh = null;

  print '商品一覧<br /><br />';

  // 繰り返し処理
  while(true) {
    // $stmtから１レコードを取り出す
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
    }
    // 商品リンク作成
    print '<a href="shop_product.php?procode='.$rec['code'].'">';
    print $rec['name'].'---';
    print $rec['price'].'円';
    print '</a>';
    print '<br />';
  }

  print '<br />';
  print '<a href="shop_cartlook.php">カートを見る</a><br />';

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

</body>
</html>