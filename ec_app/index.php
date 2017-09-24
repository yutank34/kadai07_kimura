<?php
session_start();

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=semart_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//２．データ抽出SQL作成
$stmt = $pdo->prepare("SELECT * FROM player_table");
$status = $stmt->execute();


//３．データ表示
$view="";
if($status==false) {
 //execute（SQL実行時にエラーがある場合）
 $error = $stmt->errorInfo();
 exit("ErrorQuery:".$error[2]);
} else {
 //Selectデータの数だけ自動でループしてくれる
 while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
   //上のwhile文は戻ってきたデータがある分だけループで回ってくれる
  $view .= '<li class="player">';
  $view .= '<a href="item.php?id='.$res["id"].'">';
  $view .= ' <img src="'.$res["fname"].'"alt="" width="200" class="player-image">';
  $view .= '<div class="team-info">';
  $view .= '<p class="player-team">'.$res["team"].'</p>';
  $view .= '<p class="player-num">'.$res["num"].'</p>';
  $view .= '<p class="player-def">'.$res["def"].'</p>';
  $view .= '</div>';
  $view .= '<ul class="player-info">';
  $view .= '<li><h2 class="player-name">'.$res["player"].'</h2></li>';
  $view .= '<li class="player-detail">年齢：'.$res["age"].'</li>';
  $view .= '<li class="player-detail">年数：'.$res["his"].'年</li>';
  $view .= '<li class="player-detail">身長：'.$res["hei"].'cm</li>';
  $view .= '<li class="player-detail">体重：'.$res["wei"].'kg</li>';
  $view .= '<li class="player-detail">血液型：'.$res["blood"].'</li>';
  $view .= '<li class="player-detail">投打：'.$res["hand"].'</li>';
  $view .= '<li class="player-detail">出身：'.$res["grad"].'</li>';
  $view .= '<li class="player-salary">'.number_format($res["salary"]).'<span class="tax">円</span></li>';
  $view .= '</ul>';
  $view .= '</a>';
  $view .= '</li>';
 }
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
   <div class="slider">
     <div class="center">
       <h1 class="catch">Player's Mart</h1>
       <p class="catch">セリーグの選手を買おう！</p>
     </div>
   </div>
   <div class="main">
     <div class="category">
       <ul class="cateul">
         <li class="cateli"><a href="">セリーグ</a></li>
         <li class="cateli"><a href="">広島東洋カープ</a></li>
         <li class="cateli"><a href="">読売ジャイアンツ</a></li>
         <li class="cateli"><a href="">横浜DeNAベイスターズ</a></li>
         <li class="cateli"><a href="">阪神タイガース</a></li>
         <li class="cateli"><a href="">中日ドラゴンズ</a></li>
         <li class="cateli"><a href="">東京ヤクルトスワローズ</a></li>
       </ul>
     </div>
     <div class="item-list">
       <ul class="player-list">
         <?php echo $view; ?>
       </ul>
    </div>
   </div>
 </body>
 <footer>
 </footer>
 </html>
