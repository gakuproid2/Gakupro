<!DOCTYPE html>
<html lang="ja">

<?php

  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation(1);

  $MainMenuButtonInfo = $common->MainMenu_ButtonCreation();

  $JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<body>

  <div class ='flex-container'>
    <?php echo $MainMenuButtonInfo; ?>  
  </div>  

  <?php echo $JS_Info; ?>  
</body>

<script>
 


</script>

</html>