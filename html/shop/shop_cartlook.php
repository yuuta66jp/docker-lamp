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
  $cart = $_SESSION['cart'];
  // count()で配列内のデータ数(商品数)を数える
  $max = count($cart);

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  foreach ($cart as $key => $val) {
    $sql = 'SELECT code, name, price, gazou FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[0] = $val;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $pro_name[] = $rec['name'];
    $pro_price[] = $rec['price'];
    if ($rec['gazou'] == '') {
      $pro_gazou[] = '';
    } else {
      $pro_gazou[] = '<img src="../product/gazou/'.$rec['gazou'].'">';
    }
  }

  $dbh = null;

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

カートの中身<br />
<br />
<?php for($i = 0; $i < $max; $i++) {
  ?>
    <?php print $pro_name[$i]; ?>
    <?php print $pro_gazou[$i]; ?>
    <?php print $pro_price[$i] ?>円
    <br />
  <?php
  }
  ?>

<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>
