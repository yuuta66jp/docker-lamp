<?php
  session_start();
  session_regenerate_id(true);
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

  require_once('../common/common.php');
  
  $post = sanitize($_POST);
  
  $onamae = $post['onamae'];
  $email = $post['email'];
  $postal1 = $post['postal1'];
  $postal2 = $post['postal2'];
  $address = $post['address'];
  $tel = $post['tel'];
  
  print $onamae.'様<br />';
  print 'ご注文ありがとうございました。<br />';
  print $email.'にメールを送りましたのでご確認ください。<br />';
  print '商品は以下の住所に発送させて頂きます。<br />';
  print $postal1.'-'.$postal2.'<br />';
  print $address.'<br />';
  print $tel.'<br />';

  $honbun = '';
  $honbun .= $onamae."様\n\nこのたびはご注文ありがとうございました。\n";
  $honbun .= "\n";
  $honbun .= "ご注文商品\n";
  $honbun .= "---------------\n";

  $cart = $_SESSION['cart'];
  $kazu = $_SESSION['kazu'];
  $max = count($cart);

  $dsn = 'mysql:dbname=shop;host=mysql;charset=utf8';
  $user = 'root';
  $password = 'pass';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  for ($i = 0; $i < $max; $i++) {
    $sql = 'SELECT name, price FROM mst_product WHERE code =?';
    $stmt = $dbh->prepare($sql);
    $data[0] = $cart[$i];
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $rec['name'];
    $price = $rec['price'];
    $kakaku[] = $price;
    $suryo = $kazu[$i];
    $shokei = $price * $suryo;

    $honbun .= $name.' ';
    $honbun .= $price.'円×';
    $honbun .= $suryo.'個＝';
    $honbun .= $shokei."円\n";
  }

  // テーブルにロックをかけ安全に処理する
  $sql = 'LOCK TABLES dat_sales WRITE, dat_sales_product WRITE';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $sql = 'INSERT INTO dat_sales (code_member, name, email, postal1, postal2, address, tel) VALUES (?, ?, ?, ?, ?, ?, ?)';
  $stmt = $dbh->prepare($sql);
  // array()で配列の初期化を行う
  $data = array();
  $data[] = 0;
  $data[] = $onamae;
  $data[] = $email;
  $data[] = $postal1;
  $data[] = $postal2;
  $data[] = $address;
  $data[] = $tel;
  $stmt->execute($data);

  // SELECT LAST_INSERT_ID()で最後にINSERTされたIDを取得する
  $sql = 'SELECT LAST_INSERT_ID()';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $lastcode = $rec['LAST_INSERT_ID()'];

  for ($i = 0; $i < $max; $i++) {
    $sql = 'INSERT INTO dat_sales_product (code_sales, code_product, price, quantity) VALUES (?, ?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = $lastcode;
    $data[] = $cart[$i];
    $data[] = $kakaku[$i];
    $data[] = $kazu[$i];
    $stmt->execute($data);
  }

  $sql = 'UNLOCK TABLES';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh = null;

  $honbun .= "送料は無料です。\n";
  $honbun .= "---------------\n";
  $honbun .= "\n";
  $honbun .= "代金は以下の口座にお振込ください。\n";
  $honbun .= "ろくまる銀行　やさい支店　普通口座　1234567\n";
  $honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
  $honbun .= "\n";
  $honbun .= "□□□□□□□□□□□□□□□□□□□\n";
  $honbun .= "　〜安心野菜のろくまる農園〜\n";
  $honbun .= "\n";
  $honbun .= "○○県六丸郡六丸村　123-4\n";
  $honbun .= "電話 090-1234-xxxx\n";
  $honbun .= "メール　info@rokuroku.co.jp\n";
  $honbun .= "□□□□□□□□□□□□□□□□□□□\n";
  // print '<br />';
  // nl2br()で改行文字の前にHTMLの改行タグを挿入する
  // print nl2br($honbun);
  
  // メール送信機能(自動お礼メール)
  $title = 'ご注文ありがとうございます。';
  $header = 'From: info@rokuroku.co.jp';
  $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
  mb_language('Japanese');
  mb_internal_encoding('UTF-8');
  mb_send_mail($email, $title, $honbun, $header);

  // メール送信機能(注文確認メール)
  $title = 'お客様からご注文がありました。';
  $header = 'From:'.$email;
  $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
  mb_language('Japanese');
  mb_internal_encoding('UTF-8');
  mb_send_mail('info@rokuroku.co.jp', $title, $honbun, $header);

} catch (Exception $e) {

  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();

}

?>

<br />
<a href="shop_list.php">商品画面へ</a>
 
</body>
</html>
