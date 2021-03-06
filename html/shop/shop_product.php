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
  print '<a href=" member_logout.html">r=ログアウト</a><br />';
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
  // 商品codeをGETで受け取る(URLパラメータで受け取る)
  $pro_code = $_GET['procode'];

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // nameカラム,priceカラム,gazouカラムのデータを全て取得
  $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $pro_code;
  $stmt->execute($data);

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  // 取り出した商品名,価格,画像を変数にコピー
  $pro_name = $rec['name'];
  $pro_price = $rec['price'];
  $pro_gazou_name = $rec['gazou'];

  $dbh = null;

  if ($pro_gazou_name == '') {
    $disp_gazou = '';
  } else {
    $disp_gazou = '<img src="../product/gazou/'.$pro_gazou_name.'">';
  }

  print '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />';

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

商品情報参照<br />
<br />
商品コード<br />
<?php print $pro_code; ?>
<br />
商品名<br />
<?php print $pro_name; ?>
<br />
価格<br />
<?php print $pro_price; ?>円
<br />
<?php print $disp_gazou; ?>
<br />
<br />
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>
