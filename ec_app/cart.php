<?php
session_start();
//----------------------------------------------------
//1．SESSIONからカートを取得
//※カートSESSION: array([0]=player,[1]=salary,[2]=playernum,[3]=fname);
//----------------------------------------------------
$view ='';
//$_SESSION["cart"]のデータを取得
foreach($_SESSION["cart"] as $key => $value){
      $view .='<li class="cart-list">';
      $view .='<p class="cart-thumb"><img src="'.$value[3].'"></p>';
      $view .='<h2 class="cart-title">'.$value[0].'</h2>';
      $view .='<p class="cart-price">'.$value[1].'</p>';
      $view .='<p class="cart-playernum">'.$value[2].'</p>';
      $view .='<a href="cartremove.php?id='.$key.'" class="btn-delete">削除</a>'; //$key
      $view .='</li>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/reset.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header>
    <div class="header-wrapper">
      <a href="index.php"><img src="assets/img/semart_logo.png" alt="logo"></a>
      <a href="cart.php" class="cart-icon"><p>カート</p><img src="assets/img/cart.png" alt=""></a>
    </div>
  </header>
  <div class="top-margin"></div>
  <div class="cart-wrapper">
    <h1>カート</h1>
    <ul class="label-list">
      <li class="lavel-item">商品写真</li>
      <li class="lavel-item">商品名</li>
      <li class="lavel-item">金額</li>
      <li class="lavel-item">数量</li>
      <li class="lavel-item">削除</li>
    </ul>
    <ul>
      <?php echo $view; ?>
    </ul>
  </div>
  <footer>
  </footer>
</body>
</html>
