<?php
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
  $view .= '<li>';
  $view .= '  <p><img src="'.$res["fname"].'"alt="" width="200"></p>';
  $view .= '  <h2 class="cart-player">'.$res["player"].'</h2>';
  $view .= '  <p class="cart-team">'.$res["team"].'</p>';
  $view .= '  <p class="cart-salary">'.$res["salary"].'</p>';
  $view .= '  <ul>';
  $view .= '    <li>'.$res["num"].'</li>';
  $view .= '    <li>'.$res["def"].'</li>';
  $view .= '    <li>'.$res["age"].'</li>';
  $view .= '    <li>'.$res["his"].'年</li>';
  $view .= '    <li>'.$res["hei"].'cm</li>';
  $view .= '    <li>'.$res["wei"].'kg</li>';
  $view .= '    <li>'.$res["blood"].'型</li>';
  $view .= '    <li>'.$res["hand"].'</li>';
  $view .= '    <li>'.$res["grad"].'出身</li>';
  $view .= '<a href="delete.php" class="btn-delete">削除</a>';
  $view .= '  </ul>';
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
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/cms_style.css">
</head>
<body>
  <header>
    <div class="header-wrapper">
      <p>cms</p>
    </div>
  </header>
  <div class="top-margin"></div>
  <div class="outer">
    <p class="heading">商品一覧</p>
    <ul class="playerlist">
      <?php echo $view; ?>
    </ul>
  </div>

</body>
</html>
