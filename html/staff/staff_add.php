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

スタッフ追加<br />
<br />
<!-- method="post"で送信先のファイルで$_POSTで受け取る事ができる -->
<form method="post" action="staff_add_check.php">
  スタッフ名を入力してください。<br />
  <input type="text" name="name" style="width:200px"><br />
  パスワードを入力してください。<br />
  <input type="password" name="pass" style="width:100px"><br />
  パスワードをもう１度入力してください。<br />
  <input type="password" name="pass2" style="width:100px"><br />
  <br />
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>

</body>
</html>