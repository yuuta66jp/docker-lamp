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

  if (isset($_SESSION['cart']) == true) {
    // 現在のカート内容をcartに代入
    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
  }

  // cart配列に商品code,数量を代入
  $cart[] = $pro_code;
  $kazu[] = 1;
  // セッションに保存
  $_SESSION['cart'] = $cart;
  $_SESSION['kazu'] = $kazu;

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

カートに追加しました。<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>
