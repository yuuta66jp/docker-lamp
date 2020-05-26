<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ろくまる農園</title>
</head>
<body>

<?php
// $_POST[inputのname属性]でhtmlフォームから値を受け取る
$pro_name = $_POST['name'];
$pro_price = $_POST['price'];
// $_FILES['gazou'];で画像データを取得
$pro_gazou = $_FILES['gazou'];

// エスケープ処理(XSS対策)
$pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
$pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');

if ($pro_name == '') {
  print '商品名が入力されていません。<br />';
} else {
  print '商品名：';
  print $pro_name;
  print '<br />';
}
// preg_matchで正規表現でチェックを行う(間違っていれば0,正しければ1を返す)
if (preg_match ('/\A[0-9]+\z/',$pro_price) == 0) {
  print '価格をきちんと入力してください。<br />';
} else {
  print '価格';
  print $pro_price;
  print '円<br /> ';
}

if ($pro_gazou['size'] > 0) {
  if ($pro_gazou['size'] > 1000000) {
    print '画像が大き過ぎます';
  } else {
    // move_uploaded_file(移動元,移動先);で画像をgazouフォルダにアップロードする
    move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
    print '<img src="./gazou/'.$pro_gazou['name'].'">';
    print '<br />';
  }
}

if ($pro_name == '' || preg_match ('/\A[0-9]+\z/',$pro_price) == 0 || $pro_gazou['size'] > 1000000) {
  print '<form>';
  print '<input type="button" onclick="history.back()" value="戻る">';
  print '</form>';
} else {
  print '上記の商品を追加します。<br />';
  print '<form method="post" action="pro_add_done.php">';
  print '<input type="hidden" name="name" value="'.$pro_name.'">';
  print '<input type="hidden" name="price" value="'.$pro_price.'">';
  print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
  print '<br />';
  print '<input type="button" onclick="history.back()" value="戻る">';
  print '<input type="submit" value="OK">';
  print '</form>';
}

?>

</body>
</html>
                                       