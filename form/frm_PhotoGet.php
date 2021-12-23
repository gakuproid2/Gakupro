<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>画像取得</title>
</head>

<?php

//後ほど削除予定↓
$Key_Code = 99999999001;
//後ほど削除予定↑

if (!empty($_POST["Key_Code"])) {
  $Key_Code = $_POST["Key_Code"];
}

//エラーリザルトがある場合はエラー表示
$alert = '';
if (!empty($_POST["ErrorResult"])) {
  //$alert = "<script type='text/javascript'>alert('もう一度パスワードを入力してください。');</script>";
  $alert = "<h3>パスワード不一致</h3>";
}

?>

<body>
  <h1>画像取得</h1>

  <a href="frm_MainMenu.php" class="btn_Top">メインメニュー</a>
  <?php echo $alert; ?>

  <form action="frm_PhotoGetResult.php" method="post">
    <input type="hidden" name="Key_Code" value='<?php echo $Key_Code; ?>'>
    <p>パスワード：<input type="text" id="Password" name="Password" autocomplete="off"></p>
    <button class="btn_PictureGet" id="btn_PictureGet" name="PictureGet">写真を確認</button>
  </form>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/common.js"></script>
</body>

<script>
  //確認ボタンクリック時
  $('#btn_PictureGet').on('click', function() {

    if ($("#Password").val() == "") {
      window.alert("パスワードを入力してください。"); // 
      return false;
    } else {
      $('#form_id').submit();
    }
  });
</script>

</html>