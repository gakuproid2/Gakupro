<!DOCTYPE html>
<html lang="ja">

<?php

  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation();

  $MainMenuButtonInfo = $common->MainMenu_ButtonCreation();

?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/Header.css">
  <title>メインメニュー</title>
   
  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>メインメニュー</p></div>
  </div>
 
</head>

<body>

  <?php echo $MainMenuButtonInfo; ?>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/common.js"></script>
</body>

<script>
 


</script>

</html>