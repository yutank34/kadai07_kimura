<?php
//----------------------------------------------------
//１．入力チェック(受信確認処理追加)
//----------------------------------------------------
//受信チェック:player
if(!isset($_POST["player"]) || $_POST["player"] == ""){
  exit("ParameError!player!");
}

//受信チェック:team
if(!isset($_POST["team"]) || $_POST["team"] == ""){
  exit("ParameError!team!");
}

//受信チェック:num
if(!isset($_POST["num"]) || $_POST["num"] == ""){
  exit("ParameError!num!");
}

//受信チェック:def
if(!isset($_POST["def"]) || $_POST["def"] == ""){
  exit("ParameError!def!");
}

//受信チェック:age
if(!isset($_POST["age"]) || $_POST["age"] == ""){
  exit("ParameError!age!");
}

//受信チェック:his
if(!isset($_POST["his"]) || $_POST["his"] == ""){
  exit("ParameError!his!");
}

//受信チェック:hei
if(!isset($_POST["hei"]) || $_POST["hei"] == ""){
  exit("ParameError!hei!");
}

//受信チェック:wei
if(!isset($_POST["wei"]) || $_POST["wei"] == ""){
  exit("ParameError!wei!");
}

//受信チェック:blood
if(!isset($_POST["blood"]) || $_POST["blood"] == ""){
  exit("ParameError!blood!");
}

//受信チェック:hand
if(!isset($_POST["hand"]) || $_POST["hand"] == ""){
  exit("ParameError!hand!");
}

//受信チェック:grad
if(!isset($_POST["grad"]) || $_POST["grad"] == ""){
  exit("ParameError!grad!");
}

//受信チェック:salary
if(!isset($_POST["salary"]) || $_POST["salary"] == ""){
  exit("ParameError!salary!");
}

//ファイル受信チェック※$_FILES["******"]["name"]の場合
if(!isset($_FILES["fname"]["name"]) || $_FILES["fname"]["name"] == ""){
  exit("ParameError!Files!");
}



//----------------------------------------------------
//２. POSTデータ取得
//----------------------------------------------------
$fname  = $_FILES["fname"]["name"];   //File名
$player  = $_POST["player"];   //選手名
$team  = $_POST["team"];   //所属チーム
$num  = $_POST["num"];   //背番号
$def  = $_POST["def"];   //守備
$age  = $_POST["age"];   //年齢
$his  = $_POST["his"];   //プロ野球歴
$hei  = $_POST["hei"];   //身長
$wei  = $_POST["wei"];   //体重
$blood  = $_POST["blood"];   //血液型
$hand  = $_POST["hand"];   //利き手
$grad  = $_POST["grad"];   //出身地
$salary  = $_POST["salary"];   //価格(数字：intvalを使う)
$description = $_POST["description"];   //商品紹介文


//1-2. FileUpload処理
$upload = "../assets/image/"; //画像アップロードフォルダへのパス
//アップロードした画像を../img/へ移動させる記述↓
if(move_uploaded_file($_FILES['fname']['tmp_name'],  $upload.$fname)){
  //FileUpload:OK
} else {
  //FileUpload:NG
  echo "Upload failed";
  echo $_FILES['fname']['error'];
}




//----------------------------------------------------
//３. DB接続します(エラー処理追加)
//----------------------------------------------------
try {
  $pdo = new PDO('mysql:dbname=semart_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}



//----------------------------------------------------
//４．データ登録SQL作成
//----------------------------------------------------
$stmt = $pdo->prepare("INSERT INTO player_table(id, player, team, num, def, age, his, hei, wei, blood, hand, grad, salary, description, fname, indate )VALUES(NULL,  :player, :team, :num, :def, :age, :his, :hei, :wei, :blood, :hand, :grad, :salary, :description, :fname,  sysdate())");
$stmt->bindValue(':player', $player, PDO::PARAM_STR);
$stmt->bindValue(':team', $team, PDO::PARAM_STR);
$stmt->bindValue(':num', $num, PDO::PARAM_INT);
$stmt->bindValue(':def', $def, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);
$stmt->bindValue(':his', $his, PDO::PARAM_INT);
$stmt->bindValue(':hei', $hei, PDO::PARAM_INT);
$stmt->bindValue(':wei', $wei, PDO::PARAM_INT);
$stmt->bindValue(':blood', $blood, PDO::PARAM_STR);
$stmt->bindValue(':hand', $hand, PDO::PARAM_STR);
$stmt->bindValue(':grad', $grad, PDO::PARAM_STR);
$stmt->bindValue(':salary', $salary, PDO::PARAM_INT);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
$status = $stmt->execute();



//----------------------------------------------------
//５．データ登録処理後
//----------------------------------------------------
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．item.phpへリダイレクト
  header("Location: item.php");
  exit;
}


 ?>
