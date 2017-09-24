<?php
session_start();

//GETでidを取得
if(!isset($_GET["id"]) || $_GET["id"]==""){
  exit("ParamError!");
}else{
  $id = intval($_GET["id"]); //intval数値変換
}


//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=semart_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}


//２．データ抽出SQL作成
$stmt = $pdo->prepare("SELECT * FROM player_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();


//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //Selectデータの数だけ自動でループしてくれる
  $row = $stmt->fetch(); //１レコードだけ取得：$row["フィールド名"]で取得可能
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
  <div class="cms-wrapper">
    <header>
      <div class="header-wrapper">
        <a href="index.php"><img src="assets/img/semart_logo.png" alt="logo"></a>
        <a href="cart.php" class="cart-icon"><p>カート</p><img src="assets/img/cart.png" alt=""></a>
      </div>
    </header>
    <div class="top-margin"></div>
    <div class="item-slider"></div>
    <!--  商品情報大枠 -->
    <form action="cartadd.php" method="POST">
      <div class="player-item-wrapper">
        <h1 class="buynow">買う？</h1>
        <div class="player-item-info">
          <ul class="player-info-wrapper">
            <li class="player">
              <img src="<?=$row['fname']?>"alt="" width="200" class="player-image">
                <div class="team-info">
                  <p class="player-team"><?=$row["team"]?></p>
                  <p class="player-num"><?=$row["num"]?></p>
                  <p class="player-def"><?=$row["def"]?></p>
                </div>
                <ul class="player-info">
                  <li><h2 class="player-name"><?=$row["player"]?></h2></li>
                  <li class="player-detail">年齢：<?=$row["age"]?></li>
                  <li class="player-detail">年数：<?=$row["his"]?></li>
                  <li class="player-detail">身長：<?=$row["hei"]?>cm</li>
                  <li class="player-detail">体重：<?=$row["wei"]?>kg</li>
                  <li class="player-detail">血液型：<?=$row["blood"]?></li>
                  <li class="player-detail">投打：<?=$row["hand"]?></li>
                  <li class="player-detail">出身：<?=$row["grad"]?></li>
                  <li class="player-salary"><?php  $salaryF = number_format($row["salary"]);
                    echo $salaryF; ?><span class="tax">円</span></li>
                </ul>
            </li>
            <li class="player-description"><?= $row["description"]?></li>
          </ul>
          <p class="cartin-playernum"><input type="number" value="1" name="playernum" class="cartin-num"></p>

          <!--カートボタン-->
          <div class="btn-wrapper">
            <input type="submit" class="btn-cartin" value="カートに入れる">
          </div>
            <!--商品詳細情報-->
              <input type="hidden" name="player" value="<?=$row["player"]?>">
              <input type="hidden" name="fname" value="<?=$row["fname"]?>">
              <input type="hidden" name="salary" value="<?=$row["salary"]?>">
              <input type="hidden" name="id" value="<?=$row["id"]?>">

        </div>
      </div>
    </form>

  </div>
  <footer>
  </footer>
</body>
</html>
