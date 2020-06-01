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

<?php

try {

  $year = $_POST['year'];
  $month = $_POST['month'];
  $day = $_POST['day'];

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // codeカラム,nameカラムのデータを全て取得
  $sql = '
  SELECT
    dat_sales.code,
    dat_sales.date,
    dat_sales.code_member,
    dat_sales.name AS dat_sales_name,
    dat_sales.email,
    dat_sales.postal1,
    dat_sales.postal2,
    dat_sales.address,
    dat_sales.tel,
    dat_sales_product.code_product,
    mst_product.name AS mst_product_name,
    dat_sales_product.price,
    dat_sales_product.quantity
  FROM
    dat_sales, dat_sales_product, mst_product
  WHERE
    dat_sales.code = dat_sales_product.code_sales
    AND dat_sales_product.code_product = mst_product.code
    AND substr(dat_sales.date,1,4) = ?
    AND substr(dat_sales.date,6,2) = ?
    AND substr(dat_sales.date,9,2) = ?
  ';
  $stmt = $dbh->prepare($sql);
  $data[] = $year;
  $data[] = $month;
  $data[] = $day;
  $stmt->execute($data);

  $dbh = null;

  $csv = '注文コード,注文日時,会員番号,お名前,メール,郵便番号,住所,TEL,商品コード,商品名,価格,数量';
  $csv .= "\n";
  while(true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
    }
    $csv .= $rec['code'];
    $csv .= ',';
    $csv .= $rec['date'];
    $csv .= ',';
    $csv .= $rec['code_member'];
    $csv .= ',';
    $csv .= $rec['dat_sales_name'];
    $csv .= ',';
    $csv .= $rec['email'];
    $csv .= ',';
    $csv .= $rec['postal1'].'-'.$rec['postal2'];
    $csv .= ',';
    $csv .= $rec['address'];
    $csv .= ',';
    $csv .= $rec['tel'];
    $csv .= ',';
    $csv .= $rec['code_product'];
    $csv .= ',';
    $csv .= $rec['mst_product_name'];
    $csv .= ',';
    $csv .= $rec['price'];
    $csv .= ',';
    $csv .= $rec['quantity'];
    $csv .= "\n";
  }

  // print nl2br($csv);

  // ファイルを書き込みモードで開く
  $file = fopen('./chumon.csv', 'w');
  // 文字コードの変換
  $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
  // ファイルを書き込む
  fputs($file, $csv);
  // ファイルを閉じる
  fclose($file);

} catch (Exception $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>

<a href="chumon.csv">注文データのダウンロード</a><br />
<br />
<a href="order_download.php">日付選択へ</a><br />
<br />
<a href="../staff_login/staff_top.php">トップメニューへ</a><br />

</body>
</html>