<?php
session_start();
// 全てのセッション変数を削除する(空の配列を格納する)
$_SESSION = array();
if (isset($_COOKIE[session_name()]) == true) {
  // パソコン側のセッションIDをクッキーから削除する
  setcookie(session_name(), '', time()-42000, '/');
}
// セッションを破棄する
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ろくまる農園</title>
</head>
<body>

ログアウトしました。<br />
<br />
<a href="shop_list.php">商品一覧へ</a>

</body>
</html>
