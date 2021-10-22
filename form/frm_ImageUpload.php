<!DOCTYPE html>
<html lang="ja">

<?php

  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation();  

  $JS_Info = $common->Read_JSconnection();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/Header.css">
  <title>画像アップロード画面</title>
   
  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>画像アップロード画面</p></div>
  </div>
</head>

<?php

//後ほど削除予定↓
$Key_Code = 99999999001;
//後ほど削除予定↑
if (!empty($_POST["Key_Code"])) {
  $Key_Code = $_POST["Key_Code"];
}

?>

<body>
   
  <form action="frm_ImageUploadCheck.php" method="post" enctype="multipart/form-data">
    <p>Key_Code:<input type='text' name='Key_Code' value='<?php echo $Key_Code; ?>' readonly></p>
    <input type="file" name="file[]" multiple>
    <input type="submit" name="Upload" value="アップロード">
  </form>

  <?php echo $JS_Info?>
</body>

</html>