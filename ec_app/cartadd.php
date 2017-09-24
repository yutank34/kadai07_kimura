<?php
session_start();
//----------------------------------------------------
//１．入力チェック(受信確認処理追加)
//----------------------------------------------------
//商品名受信チェック
if(!isset($_POST["player"]) || $_POST["player"]==""){
  exit("ParamError:item");
}
//金額受信チェック
if(!isset($_POST["fname"]) || $_POST["fname"]==""){
  exit("ParamError:value");
}
//ID受信チェック
if(!isset($_POST["id"]) || $_POST["id"]==""){
  exit("ParamError:id");
}
//個数受信チェック
if(!isset($_POST["salary"]) || $_POST["salary"]==""){
  exit("ParamError:salary");
}
//ファイル名受信チェック
if(!isset($_POST["playernum"]) || $_POST["playernum"]==""){
  exit("ParamError:playernum");
}


//----------------------------------------------------
//２．POST値を変数に代入
//----------------------------------------------------
$id = intval($_POST["id"]);
$player = $_POST["player"];
$salary = intval($_POST["salary"]);
$playernum = intval($_POST["playernum"]);
$fname = $_POST["fname"];


//----------------------------------------------------
//３．カートへ登録: array([0]=player,[1]=salary,[2]=playernum,[3]=fname);
//----------------------------------------------------
$_SESSION["cart"][$id] = array($player, $salary, $playernum, $fname);


//----------------------------------------------------
//４．次のページへ移動 cart.php
//----------------------------------------------------
header("Location: cart.php");
exit;
 ?>
