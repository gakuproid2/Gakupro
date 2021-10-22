<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation();  
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/Header.css">
  <title>画像アップロード確認画面</title>
   
  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>画像アップロード確認画面</p></div>
  </div>
</head>

<?php
//画像格納用
$ImageALL = "";
//[アップロード]ボタンの押下確認
if (isset($_POST['Upload'])) {

  //クラスファイルの読み込み
  require_once '../dao/dao_ImageUploadCheck.php';
  //クラスの生成
  $dao = new dao_ImageUploadCheck();

  if (!empty($_POST["Key_Code"])) {
    $Key_Code = $_POST["Key_Code"];
  }

  //画像格納フォルダの階層
  $BaseDir = '../File/';
    
  //キーナンバーの日付部分のみ格納(例：2020123101 → 20201231)
  $Date = substr($Key_Code, 0, 8);

  ////キーナンバーの日付部分以外格納(例：2020123101 → 01)
  $KeyNum = str_replace($Date, '', $Key_Code);
 

  //FILEディレクトリに日付ディレクトリの存在確認
  if (file_exists($BaseDir . $Date)) {
    //存在したときの処理
  } else {
    //存在しないときの処理
    //フォルダ作成
    mkdir($BaseDir . $Date, 0777);
  }

  //日付ディレクトリの次にImageディレクトリ作成の為
  $ImageDir = $BaseDir . $Date .'/Image/';

  //Imageディレクトリ存在確認
  if (file_exists($ImageDir)) {
    //存在したときの処理
  } else {
    //存在しないときの処理
    //フォルダ作成
    mkdir($ImageDir, 0777);
  }

 $CreateDir = $ImageDir . $KeyNum;

  //FILEディレクトリ→日付ディレクトリ→Imageディレクトリの存在確認
  if (file_exists($CreateDir)) {
    //存在したときの処理
  } else {
    //存在しないときの処理
    //フォルダ作成
    mkdir($CreateDir, 0777);
  }
 
  $CreateDir =$CreateDir .'/';

  $Num = 0;
  foreach ($_FILES['file']['tmp_name'] as $no => $tmp_name) {
    
    $filename = $CreateDir . "gakupro" .$Date . $KeyNum . $Num + 1 . ".jpeg";
    
    if (move_uploaded_file($tmp_name, $filename)) {      
      $Num += 1;
    } else {
      //エラー処理
    }
  }

  echo '合計【' . $Num . '枚】の画像データをアップロードしました。<br>';

  //アップロードした写真を表示し確認する
  $ImageNameALL = glob($CreateDir . '/*');
 
  foreach ($ImageNameALL as $ImageName) {
    $ImageALL .= "<div class='CustomerPhoto'><img src=" . $ImageName . "></div>";
  }
  

}
?>

<body>

  <?php echo $ImageALL; ?> <br>

  <a href="frm_ImageUpload.php">画像アップロード画面に戻る</a>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/common.js"></script>
</body>




</html>