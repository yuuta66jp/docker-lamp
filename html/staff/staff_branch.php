<?php
session_start ();
// session_regenerate_id (true)でセッションIDをアクセス毎に変更する
session_regenerate_id (true);
// trueもしくはfalseを判定
if (isset ($_SESSION['login']) == false) {
  print 'ログインされていません。<br />';
  print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
}

if (isset ($_POST['add']) == true) {
  header ('Location: staff_add.php');
  exit();
}
if (isset ($_POST['disp']) == true) {
  if (isset ($_POST['staffcode']) == false) {
    header ('Location: staff_ng.php');
    exit();
  }
  $staff_code = $_POST['staffcode'];
  header ('Location: staff_disp.php?staffcode='.$staff_code);
  exit();
}
// isset関数で値がセットされているか確認。
// 変数に値がセットされているかつnullでない場合にtrueを返す
if (isset ($_POST['edit']) == true) {
  // スタッフの選択がなければNG画面へ遷移する
  if (isset ($_POST['staffcode']) == false) {
    header ('Location: staff_ng.php');
    exit();
  }
  $staff_code = $_POST['staffcode'];
  // header関数で遷移先を指定(header('Location:飛ばしたい画面のURL))
  // URLパラメータでstaff_codeを送る
  header ('Location: staff_edit.php?staffcode='.$staff_code);
  exit();
}
if (isset ($_POST['delete']) == true) {
  if (isset ($_POST['staffcode']) == false) {
    header ('Location: staff_ng.php');
    exit();
  }
  $staff_code = $_POST['staffcode'];
  header ('Location: staff_delete.php?staffcode='.$staff_code);
  exit();
}

?>
