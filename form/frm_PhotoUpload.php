<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート
  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  


  define("title" ,"画像アップロード");
  require_once($_SERVER['DOCUMENT_ROOT'] . '/Gakupro/form/head.php');

  $JS_Info = $common->Read_JSconnection();
?>



<?php

//後ほど削除予定↓
$Key_Code = 99999999001;
//後ほど削除予定↑
if (!empty($_POST["Key_Code"])) {
  $Key_Code = $_POST["Key_Code"];
}

?>

<body>
   
  <form action="frm_PhotoUploadResult.php" method="post" enctype="multipart/form-data">
    <p>Key_Code:<input type='text' name='Key_Code' value='<?php echo $Key_Code; ?>' readonly></p>
    <input type="file" name="file[]" multiple>
    <input type="submit" name="Upload" value="アップロード">
  </form>

  <?php echo $JS_Info?>
</body>

</html>