<!DOCTYPE html>
<html lang="ja">

<style>


</style>

<?php

  //クラスファイルの読み込み
  require_once '../dao/dao_Member_M.php';
  //クラスの生成
  $dao_Member_M = new dao_Member_M();  
?>

<?php  
  $ScreenInfo = '';
  if (!empty($_GET['Member_ID'])) {
  
    $ScreenInfo = 'メンバーID('.$_GET['Member_ID'].')の登録成功';
  }else{

    $ScreenInfo = '登録失敗';
  }
?>

<body>
<p><?php echo $ScreenInfo; ?></p>
  

</body>


<script>  

 
</script>


</html>