<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
    
  $HeaderInfo = $common->HeaderCreation('画像アップロード確認画面');  

  $JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<?php
//画像格納用
$ImageALL = "";
//[アップロード]ボタンの押下確認
if (isset($_POST['Upload'])) {  

  if (!empty($_POST["Key_Code"])) {
    $Key_Code = $_POST["Key_Code"];
  }

  //画像格納フォルダの階層
  $BaseDir = '../photo/';
    
  //キーナンバーの日付部分のみ格納(例：2020123101 → 20201231)
  $Date = substr($Key_Code, 0, 8);
  
  $KeyNum = str_replace($Date, '', $Key_Code);

  $common->CreateDirectory($BaseDir . $Date);


  //日付ディレクトリの次にImageディレクトリ作成の為
  $ImageDir = $BaseDir . $Date;
  $common->CreateDirectory($ImageDir);
 
  $CreateDir = $ImageDir .'/'. $KeyNum.'/';
  $common->CreateDirectory($CreateDir);  

  $Num = 0;
  foreach ($_FILES['file']['tmp_name'] as $no => $tmp_name) {

    $FileName = $Num + 1 .'.jpeg';        
    $FileFullDir = $CreateDir . $FileName;
    
    if (move_uploaded_file($tmp_name, $FileFullDir)) {      
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

  <a href="frm_PhotoUpload.php">画像アップロード画面に戻る</a>

  <?php echo $JS_Info?>
</body>




</html>