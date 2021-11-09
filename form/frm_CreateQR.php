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
  <title>QRコード作成画面</title>

  <div class='Header'>
    <?php echo $HeaderInfo; ?>
    <div class='Header_ScreenName'>
      <p>QRコード作成画面</p>
    </div>
  </div>
</head>

<?php

$alert = "";

$json_TargetDir ='';
$QRTicket_Name_array = [];
$Judge = false;
$json_Judge = json_encode($Judge);

if (!empty($_POST["Request"])) {

  //クラスファイルの読み込み
  require_once '../dao/dao_CreateQR.php';
  //クラスの生成
  $dao = new dao_CreateQR();

  // QRcode作成用「QrCodeHelper.php」の読み込み
  require("../php/QRCode/Create_QRCode.php");
  // インスタンスの作成
  $qrcode = new QrCodeHelper;

  //前画面で要求された作成数を格納
  $Request = $_POST["Request"];

  //前画面で要求された日付を格納
  $Date = str_replace("-", "", $_POST["TargetDate"]);

  //日付で現状の作成数を取得
  $Quantity = $dao->Get_Quantity($Date);

  //リクエスト数より作成数が上回っているはアラートを表示
  //リクエスト数が上回っている場合は差分を作成
  if ($Request <= $Quantity) {

    $alert = "<h2>選択日(" . $Date . ")では既に[" . $Quantity . "]個のQRコードが作成されています。</h2>";
  } else {

    //基本のディリクトリ
    $Base_Dir = '../File/';

    //基本ディリクトリに日付ディリクトリを作成する為の文字列格納
    $Date_Dir = $Base_Dir . $Date . '/';

    //基本ディリクトリ + 日付ディリクトリの存在チェック
    if (!file_exists($Date_Dir)) {
      //存在しないときはフォルダ作成
      mkDir($Date_Dir, 0777);
    }

    //日付ディリクトリにQRディリクトリを作成する為に文字列格納
    $QR_Dir = $Date_Dir . 'QR/';

    //日付ディリクトリ + QRディリクトリの存在チェック
    if (!file_exists($QR_Dir)) {
      //存在しないときはフォルダ作成    
      mkDir($QR_Dir, 0777);
    }

    //--パスワード作成処理--開始--
    //パスワード格納用配列宣言
    $Password_array = [];

    //日付で既存データのパスワードを取得
    $Password_Table = $dao->Get_PassWord($Date);

    //パスワードを取得した分パスワード格納用配列に追加
    foreach ($Password_Table as $Pass_val) {
      array_push($Password_array, $Pass_val);
    }

    //パスワード格納用配列のデータ数を格納
    $cnt = count($Password_array);

    // 乱数の範囲(4桁に設定する)
    $Password_min = 1000;
    $Password_max = 9999;

    //要求された作成数になるようループ
    for ($i = $cnt; $i <= $Request; $i++) {

      while (true) {

        //設定した最小値と最大値の範囲内で乱数生成
        $Password_tmp = mt_rand($Password_min, $Password_max);

        //パスワード格納用配列と比較し重複していなければ配列に格納
        if (!in_array($Password_tmp, $Password_array)) {
          array_push($Password_array, $Password_tmp);
          break;
        }
      }
    }

    //作成したパスワードを登録(要求された作成数分ループ)
    for ($i = $cnt + 1; $i <= $Request; $i++) {

      //キーコードは、日付(yyyymmdd) + 連番(0埋め3桁)
      $Key_Code = $Date  . str_pad($i, 3, 0, STR_PAD_LEFT);

      //キーコードとパスワードを登録する
      $Result = $dao->Insert_ImageGet_T($Key_Code, $Password_array[$i]);
    }

    //後ほど削除予定↓
    //別端末での検証時はURLがlocalhostでは画面遷移できない。
    //PCのIPアドレスをURLにする必要がある。
    $HostName = '';
    if (empty($_POST["HostName"])) {
      $HostName = 'http://localhost';
    } else {
      $HostName = 'http://' . $_POST["HostName"];
    }
    //後ほど削除予定↑


    //QRcodeチケットのテンプレ保存場所
    $Template_Dir = $Base_Dir . 'Template/QR_Template.png';

    //QRcodeチケットの保存場所
    $QrTicket_Dir = $Date_Dir . 'QR_Ticket/';

    if (!file_exists($QrTicket_Dir)) {
      //存在しないときはフォルダ作成
      mkDir($QrTicket_Dir, 0777);
    }

    //日付でデータ（Key_CodeとPassWord）取得
    $Key_Code_Table = $dao->Get_ImageGet_T($Date);

    //データ数分のQRチケットを作成
    foreach ($Key_Code_Table as $value) {

      //キーコード格納
      $Key_Code = $value['Key_Code'];
      //パスワード格納
      $PassWord = $value['PassWord'];
      //キーコードから日付を除去しコード作成格納　例：20201231001 - 20201231 → 001
      $Code = str_replace($Date, "", $Key_Code);

      //QRコードの作成から保存まで--開始--

      // QRコードに設定するURLの指定
      $url = $HostName . "/gakupro/form/ScreenSelectionBranch.php?Key_Code=" . $Key_Code;

      //QRコード作成処理(ネットで見つけた処理、設定したい$urlを以下の処理に渡すと作成してくれる)
      $TargetUrl =  $qrcode->text($url, ["size" => "150x150", "encode" => "UTF-8", "margin" => "2", "error_correction" => "L"]) . '/chart.png';

      //作成されたQRを取得  
      $img = file_get_contents($TargetUrl);

      //作成したQRの保存名を設定
      $CreateQR_Dir = $QR_Dir . $Key_Code . '.png';

      //画像保存時、$QR_Dir(保存場所) + $Key_Code(日付と連番を連結)で保存
      file_put_contents($CreateQR_Dir, $img);

      //QRコードの作成から保存まで--終了--

      // Template画像を取り込み新しくQRチケットを作成する為
      $Create_img = imagecreatefrompng($Template_Dir);

      // 挿入する文字列のフォント(今回はWindowsに入ってたメイリオを使う)   
      /////Macで作成できるか確認必須///// 
      $font = "../Fonts/meiryo.ttc";

      //日付挿入--開始--
      // 挿入する文字列
      $text = substr($Date, 0, 4) . '/' . substr($Date, 4, 2) . '/' . substr($Date, 6, 2);

      // 挿入する文字列の色(白)
      $color = imagecolorallocate($Create_img, 1, 5, 12);

      // 挿入する文字列のサイズ(ピクセル)
      $size = 13;

      // 挿入する文字列の角度
      $angle = 0;

      // 挿入位置
      $x = 5;         // 左からの座標(ピクセル)
      $y = imagesy($Create_img) - 30; // 上からの座標(ピクセル)

      // 文字列挿入
      imagettftext(
        $Create_img,     // 挿入先の画像
        $size,      // フォントサイズ
        $angle,     // 文字の角度
        $x,         // 挿入位置 x 座標
        $y,         // 挿入位置 y 座標
        $color,     // 文字の色
        $font,  // フォントファイル
        $text
      );     // 挿入文字列
      //日付挿入--終了--


      //キーナンバー挿入--開始--
      // 挿入する文字列
      $text = 'No.' . str_pad($Code, 3, 0, STR_PAD_LEFT);

      // 挿入する文字列の色(白)
      $color = imagecolorallocate($Create_img, 1, 5, 12);

      // 挿入する文字列のサイズ(ピクセル)
      $size = 13;

      // 挿入する文字列の角度
      $angle = 0;

      // 挿入位置
      $x = imagesx($Create_img) - 65; // 左からの座標(ピクセル)
      $y = imagesy($Create_img) - 30; // 上からの座標(ピクセル)

      // 文字列挿入
      imagettftext(
        $Create_img,     // 挿入先の画像
        $size,      // フォントサイズ
        $angle,     // 文字の角度
        $x,         // 挿入位置 x 座標
        $y,         // 挿入位置 y 座標
        $color,     // 文字の色
        $font,  // フォントファイル
        $text
      );     // 挿入文字列

      //キーナンバー挿入--終了--

      //パスワード挿入--開始--

      // 挿入する文字列
      $text = 'Pass :' . $PassWord;

      // 挿入する文字列の色(白)
      $color = imagecolorallocate($Create_img, 1, 5, 12);

      // 挿入する文字列のサイズ(ピクセル)
      $size = 13;

      // 挿入する文字列の角度
      $angle = 0;

      // 挿入位置
      $x = imagesx($Create_img) * 0.3; // 左からの座標(ピクセル)
      $y = imagesy($Create_img) - 5; // 上からの座標(ピクセル)

      // 文字列挿入
      imagettftext(
        $Create_img,     // 挿入先の画像
        $size,      // フォントサイズ
        $angle,     // 文字の角度
        $x,         // 挿入位置 x 座標
        $y,         // 挿入位置 y 座標
        $color,     // 文字の色
        $font,  // フォントファイル
        $text
      );     // 挿入文字列

      //パスワード挿入--終了--

      //テンプレート画像とQRの合成--開始--

      //QRコードの余白を除去する為の土台
      $ReCreate_Qr_img = imagecreatetruecolor(111, 111);

      //余白を除去する画像(QRコード)を取り込む
      $Qr_img = imagecreatefrompng($CreateQR_Dir);

      //余白除去処理→除去済み画像($ReCreate_Qr_img)
      imagecopyresampled($ReCreate_Qr_img, $Qr_img, 0, 0, 19, 19, 111, 111, 111, 111);

      // 合成する画像のサイズを取得
      $sx = imagesx($ReCreate_Qr_img);
      $sy = imagesy($ReCreate_Qr_img);

      imageLayerEffect($ReCreate_Qr_img, IMG_EFFECT_ALPHABLEND); // 合成する際、透過を考慮する
      imagecopy($Create_img, $ReCreate_Qr_img, 65, 95, 0, 0, $sx, $sy); // 合成する

      $QRTicket_Name="QR_Ticket(" . $Key_Code . ").png";

      array_push($QRTicket_Name_array, $QRTicket_Name);

      imagepng($Create_img, $QrTicket_Dir . $QRTicket_Name);
      imagedestroy($Create_img);

      //テンプレート画像とQRの合成--終了--
    }

    //QRcodeチケットの保存場所内を全て操作端末にダウンロードする 
    $json_TargetDir = json_encode($QrTicket_Dir);
    $json_QRTicket_Name_array = json_encode($QRTicket_Name_array);
    $Judge = true;
    $json_Judge = json_encode($Judge);
    
  }
}
?>

<body>

  <?php echo $alert; ?>
  <form action="frm_CreateQR.php" method="post">
    <p>出動日<input type="date" id="txt_TargetDate" name="TargetDate" autocomplete="off" maxlength="8"></p>

    <p>作成数<input type="text" id="txt_Request" name="Request" autocomplete="off"></p>
    <br>
    <p>※※他端末で検証する場合のみホスト名、またはIPアドレスを入力してください。※※</p>
    <p>ホスト名<input type="text" id="txt_HostName" name="HostName" autocomplete="off"></p>
    <button class="btn_Create" id="btn_Create" name="Create">作成</button>
    
  </form>

  <?php echo $JS_Info ?>
</body>

<script>
  //作成ボタンクリック時
  $('#btn_Create').on('click', function() {

    var ErrorMsg = '';
    if ($("#txt_TargetDate").val() == "") {
      ErrorMsg += '出動日が選択してください。\n';
    }

    if ($("#txt_Request").val() == "") {
      ErrorMsg += '作成数を入力してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg);
      return false;
    } else {
      $('#form_id').submit();
    }

  });

 
  //画面遷移時
  $(window).on('load', function(event) {

    var Judge = JSON.parse('<?php echo $json_Judge; ?>');
    
    //QRチケット作成時は自動ダウンロードする
    if (Judge == true) {

      var TargetDir = JSON.parse('<?php echo $json_TargetDir; ?>');
    
      var QRTicketName_array = JSON.parse('<?php echo $json_QRTicket_Name_array; ?>');

      var count = 0;
      // 配列の中身を一つずつ処理
      $.each(QRTicketName_array, function(index, val) {

        var ImageName = (val);

        var a = document.createElement('a');
        a.download = ImageName;
        a.href = TargetDir + ImageName;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        count++;
      });

      window.alert("ダウンロード数：" + count);
    };
  });

  
 

</script>

</html>