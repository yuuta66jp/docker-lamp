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
  header ('Location: pro_add.php');
  exit();
}
if (isset ($_POST['disp']) == true) {
  if (isset ($_POST['procode']) == false) {
    header ('Location: pro_ng.php');
    exit();
  }
  $pro_code = $_POST['procode'];
  header ('Location: pro_disp.php?procode='.$pro_code);
  exit();
}
// isset関数で値がセットされているか確認。
// 変数に値がセットされているかつnullでない場合にtrueを返す
if (isset ($_POST['edit']) == true) {
  // スタッフの選択がなければNG画面へ遷移する
  if (isset ($_POST['procode']) == false) {
    header ('Location: pro_ng.php');
    exit();
  }
  $pro_code = $_POST['procode'];
  // header関数で遷移先を指定(header('Location:飛ばしたい画面のURL))
  // URLパラメータでpro_codeを送る
  header ('Location: pro_edit.php?procode='.$pro_code);
  exit();
}
if (isset ($_POST['delete']) == true) {
  if (isset ($_POST['procode']) == false) {
    header ('Location: pro_ng.php');
    exit();
  }
  $pro_code = $_POST['procode'];
  header ('Location: pro_delete.php?procode='.$pro_code);
  exit();
}

?>
