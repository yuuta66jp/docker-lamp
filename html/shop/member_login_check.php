<?php

try {

  require_once('../common/common.php');

  $post = sanitize($_POST);

  $member_email = $post['email'];
  $member_pass = $post['pass'];

  $member_pass = md5 ($member_pass);

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT code,name FROM dat_member WHERE email=? AND password=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $member_email;
  $data[] = $member_pass;
  $stmt->execute($data);

  $dbh = null;

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($rec == false) {
    print 'メールアドレスかパスワードが間違っています。<br />';
    print '<a href="member_login.html">戻る</a>';
  } else {
    // session_startでセッションを作成する
    // セッションの作成に成功した場合は trueを、その他の場合は falseを返す。
    session_start ();
    $_SESSION['member_login'] = 1;
    $_SESSION['member_code'] = $rec['code'];
    $_SESSION['member_name'] = $rec['name'];
    header ('Location: shop_list.php');
    exit();
  }

// エラー表示
} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>
