<?php

//画面遷移ボタンの表示判定
class Class_SendMail {

  //メール送信実行
  function MailSending($Info)
  {       
   
    //クラスファイルの読み込み
    require_once '../dao/dao_MailAddressAuthenticate_T.php';
    //クラスの生成
    $dao_MailAddressAuthenticate_T = new dao_MailAddressAuthenticate_T();
  
    //データ登録失敗時はfalseが戻る。成功時は生成したキーコードが戻る
    $Key_Code = $dao_MailAddressAuthenticate_T->DataInsert($Info);

    //false時は処理抜け
    if ($Key_Code == false) {
      return false;
    }

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

    return $this->Sendmail($MailInfo);

  } 
  
  function CreatePassword() {
        
    // 乱数の範囲(4桁に設定する)
    $Password_min = 1000;
    $Password_max = 9999;
    //設定した最小値と最大値の範囲内で乱数生成
    $password = mt_rand($Password_min, $Password_max);

    return $password;
  }

  function Sendmail($MailInfo) {  
    
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    $Key_Code = $MailInfo['Key_Code'];
    $Password = $MailInfo['Password'];
    $MailAddress = $MailInfo['MailAddress'];
    $Name = $MailInfo['Name'];  
    
    $URL = "http://localhost/Gakupro/form/frm_MailAddressAuthenticate.php?Key_Code=" . $Key_Code;
    
    // 変数の設定
    $to = $MailAddress;
    $subject = "学プロ仮登録";
    
    $message  = "
    この度は学プロにご登録いただき誠にありがとうございます。
    ご登録者様のメールアドレスが正しく送受信できることが確認できました。

    以下のURLから登録の続きをよろしくお願いします。
    URLをクリックするとパスワードの入力画面が表示されますので、メール内記載の4桁の数字を入力してください。

    パスワード：$Password
    URL：$URL
    ";

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


?>