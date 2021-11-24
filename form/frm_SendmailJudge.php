<!doctype html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>メール送信判定</title>
</head>

<?php
//クラスファイルの読み込み
require_once '../php/Class_SendMail.php';
//クラスの生成
$Class_SendMail = new Class_SendMail();

//クラスファイルの読み込み
require_once '../dao/dao_MailAddressAuthenticate_T.php';
//クラスの生成
$dao_MailAddressAuthenticate_T = new dao_MailAddressAuthenticate_T();

//ポストされた確認する。
if (count($_POST) > 1) {

  // 乱数の範囲(4桁に設定する)
  $Password_min = 1000;
  $Password_max = 9999;
  //設定した最小値と最大値の範囲内で乱数生成
  $Password = mt_rand($Password_min, $Password_max);

  //キーコード作成処理  
  $Key_Code = $dao_MailAddressAuthenticate_T->GetMaxKeyCode_OnTheDay();

  //ポストされた情報と生成した情報を配列に格納
  $PostInfo = array(
    'MailAddress' => $_POST["MailAddress"],
    'FullName' => $_POST['LastName'] . '　' . $_POST['Name'],
    'Password' => $Password,
    'Key_Code' => $Key_Code
  );

  //メールアドレス認証用テーブルにデータ登録処理
  //失敗時はfalse、成功時はture
  $DataInsertResult = $dao_MailAddressAuthenticate_T->DataInsert($PostInfo);
  
  //false時は〇〇〇
  if ($DataInsertResult == false) {
  }

  //登録された情報をメールアドレス認証用テーブルから再取得する
  $GetMailAddressAuthenticateInfo = $dao_MailAddressAuthenticate_T->GetMailAddressAuthenticateInfo($Key_Code);

  foreach ($GetMailAddressAuthenticateInfo as $val) {
    $MailInfo = array(
      'ID' => $val['ID'],
      'Key_Code' => $val['Key_Code'],
      'Password' => $val['Password'],
      'MailAddress' => $val['MailAddress'],
      'Name' => $val['Name'],
      'CreateDateTime' => $val['CreateDateTime']
    );
  }

  $Result = $Class_SendMail->TemporaryRegistrationMailSending($MailInfo);

  if ($Result == true) {

    $Password = $MailInfo['Password'];
    $MailAddress = $MailInfo['MailAddress'];
    $Name = $MailInfo['Name'];
    
    echo "テストの為
      メール成功
      パスワード = $Password
      メールアドレス = $MailAddress
      名前 = $Name      
      ";
  } else {
    echo 'メール失敗';
  }
}
?>

<body>




</body>