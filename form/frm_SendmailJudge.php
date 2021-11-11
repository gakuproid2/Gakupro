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

  //ポストされた確認する。
  if (count($_POST) > 1) {
  
    $Info = array(
      'MailAddress' => $_POST["MailAddress"],
      'Name' => $_POST["Name"],   
      'Password' => $Class_SendMail->CreatePassword(),
    );

    $Result = $Class_SendMail->MailSending($Info);

    if ($Result == true) {
      

      $Password = $Info['Password'];
      $MailAddress = $Info['MailAddress'];
      $Name = $Info['Name'];  

      echo"テストの為
      メール成功
      パスワード = $Password
      メールアドレス = $MailAddress
      名前 = $Name      
      ";


    }else{
      echo'メール失敗';
    }
  }
?>

<body>



  
</body>
