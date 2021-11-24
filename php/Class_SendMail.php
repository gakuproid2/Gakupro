<?php

class Class_SendMail
{
  //仮登録時のメールアドレス認証時
  function TemporaryRegistrationMailSending($MailInfo)
  {
    //仮登録希望者への自動メール送信処理の結果を格納  true or false
    $Result = $this->MailSendingToMember($MailInfo);  

    //結果を管理者のメールアドレスに送信する
    $this->MailSendingToAdministrator($MailInfo,$Result);

    //仮登録希望者への自動メール送信処理の結果を返却
    return $Result;
  }

  //メンバーへのメール送信処理
  function MailSendingToMember($MailInfo)
  {

    //仮登録者情報
    $Key_Code = $MailInfo['Key_Code'];
    $Password = $MailInfo['Password'];
    $MailAddress = $MailInfo['MailAddress'];
    $Name = $MailInfo['Name'];    

     // 変数の設定
    $URL = "http://localhost/Gakupro/form/frm_MailAddressAuthenticate.php?Key_Code=" . $Key_Code;   
    $to = $MailAddress;
    $subject = "学プロ仮登録";

    //本文
    $message  = "
    $Name 様
    この度は学プロにご登録いただき誠にありがとうございます。
    登録頂いたメールアドレスが正しく送受信できることが確認できました。

    以下のURLからご登録の続きをよろしくお願いします。
    URLをクリックするとパスワードの入力画面が表示されますので、メール内記載の4桁の数字を入力してください。

    URL：$URL
    パスワード：$Password    
    ";

    //true or false
    return $this->Sendmail($to,$subject,$message);

  }

  //管理者へのメール送信処理
  function MailSendingToAdministrator($MailInfo,$Result)
  {
    $to = '※※管理者メールアドレス※※';
    $subject = "仮登録時メール自動送信の結果";

    //仮登録者情報
    $Key_Code = $MailInfo['Key_Code'];
    $Password = $MailInfo['Password'];
    $MailAddress = $MailInfo['MailAddress'];
    $Name = $MailInfo['Name'];    

    if ($Result==true){
      $ResultMessage ='メール失敗';
    }else{
      $ResultMessage ='メール成功';
    }

    //本文
    $message  = "
    仮登録者:$Name
    MailAddress:$MailAddress
    Key_Code:$Key_Code
    Password:$Password

    仮登録の結果:$ResultMessage
    ";   

    //true or false
    return $this->Sendmail($to,$subject,$message);

  }

  //共通メール送信処理
  function Sendmail($to, $subject, $message)
  {

    mb_language("Japanese");
    mb_internal_encoding("UTF-8");    

    // メール送信
    if (mb_send_mail($to, $subject, $message)) {
    //送信成功
    return true;
    } else {
    //送信失敗
    return false;
    }
  }

}
