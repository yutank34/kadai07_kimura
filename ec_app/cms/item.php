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
  <div class="cms-wrapper">

    <!-- cmsのヘッダー -->
    <header>
      <div class="header-wrapper">
        <p>cms</p>
      </div>
    </header>
    <div class="top-margin"></div>

    <div class="outer">

      <!-- cmsの商品登録フォーム -->
      <form action="insert.php" method="post" enctype="multipart/form-data">
        <p class="cms-thumb"><img src="https://placehold.jp/c9c9c9/ffffff/600×600.png?text=%E3%83%80%E3%83%9F%E3%83%BC%E7%94%BB%E5%83%8F" width="200"></p>
        <dl class="cms-list">
          <dt>画像</dt>
          <dd><input type="file" name="fname" accept="image/*"></dd>
          <dt>選手名</dt>
          <dd><input type="text" name="player" placeholder="選手名を入力"></dd>
          <dt>所属チーム</dt>
          <dd><input type="text" name="team" placeholder="チーム名を入力"></dd>
          <dt>背番号</dt>
          <dd><input type="number" name="num"></dd>
          <dt>ポジション</dt>
          <dd><input type="text" name="def"></dd>
          <dt>年齢</dt>
          <dd><input type="number" name="age"></dd>
          <dt>プロ野球歴</dt>
          <dd><input type="number" name="his"></dd>
          <dt>身長</dt>
          <dd><input type="number" name="hei"></dd>
          <dt><体重/dt>
          <dd><input type="number" name="wei"></dd>
          <dt>血液型</dt>
          <dd><select name="blood" id="">
            <option value="A">A型</option>
            <option value="B">B型</option>
            <option value="O">O型</option>
            <option value="AB">AB型</option>
          </select></dd>
          <dt>利き手</dt>
          <dd><input type="text" name="hand" placeholder="利き手を入力"></dd>
          <dt>出身地</dt>
          <dd><input type="text" name="grad" placeholder="血液型を入力"></dd>
          <dt>年俸</dt>
          <dd><input type="number" name="salary"></dd>
          <dt>選手説明</dt>
          <dd><textarea name="description" id="" cols="30" rows="10">選手説明を入力</textarea></dd>
        </dl>
        <ul>
          <li>
            <a href="./">戻る</a>
          </li>
          <li>
            <input type="submit" value="登録">
          </li>
        </ul>
      </form>
      <form action="csv_uploader.php" method="post" enctype="multipart/form-data">
        CSVファイル：<br>
        <input type="file" name="upfile"><br>
        <input type="submit" value="アップロード">
      </form>
    </div>
    <footer>
    </footer>
  </div>
<script src="http://code.jquery.com/jquery-3.0.0.js"></script>
<script>
//---------------------------------------------------
//画像サムネイル表示
//---------------------------------------------------
// // アップロードするファイルを選択
// $('input[type=file]').change(function() {
//   //選択したファイルを取得し、file変数に格納
//   var file = $(this).prop('files')[0];
//   // 画像以外は処理を停止
//   if (!file.type.match('image.*')) {
//     // クリア
//     $(this).val(''); //選択されてるファイルを空にする
//     $('.cms-thumb > img').html(''); //画像表示箇所を空にする
//     return;
//   }
//   // 画像表示
//   var reader = new FileReader(); //1
//   reader.onload = function() {   //2
//     $('.cms-thumb > img').attr('src', reader.result);
//   }
//   reader.readAsDataURL(file);    //3
// });
</script>
</body>
</html>
