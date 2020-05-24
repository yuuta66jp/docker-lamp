<?php
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
