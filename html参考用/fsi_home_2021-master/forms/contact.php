<?php

// $from_name = $_POST['name'];
// $from_email = $_POST['email'];
// $subject = $_POST['subject'];
// $message = $_POST['message'];

// $errors = array();

//         if (empty($from_name )) {
//             $errors[] = '氏名は必須です。';
//         }

//         if (empty($from_email)) {
//             $errors[] = 'メールアドレスは必須です。';
//         }
// if(count($errors))
// {
//   return $errors;
// }
        

// シークレットキーを設定
$secretKey = '6LfVZTobAAAAAJvgdSQBm4BPyQHAWmsN-nbjskCF';
    
$verifyResult = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['recaptchaToken']);

$verifyResult = json_decode($verifyResult);

if ($verifyResult->success == false)
{
    // スパム認定された場合の処理
    // header('location: /message-page?type=danger&message=問い合わせエラー TEL 098－879－3316');
    echo '申し訳ございません。メッセージを送信に失敗しました。recaptcha';
    exit();
}
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address
  // $receiving_email_address = 'fsitest000@gmail.com';
  $receiving_email_address = 'info@fsi-web.com, fsitest000@gmail.com';
  // $receiving_email_address = 'k-nakamura@fsi-web.com, fsitest000@gmail.com';

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");
  $to = $receiving_email_address;
  $from_name = $_POST['name'];
  $from_email = $_POST['email'];
  $subject = $_POST['subject'].' ['.$from_name.']';
  $message = $_POST['message'];

  $body='以下のお問い合わせがありました。'."\r\n";
  $body.='お名前：'.$from_name."\r\n";
  $body.='メールアドレス：'.$from_email."\r\n";
  $body.='本文------------------↓'."\r\n";
  $body.=$message."\r\n";
  $body.='---------------------'."\r\n";

  if(mb_send_mail($to, $subject, $body)){
    header("HTTP/1.1 200 OK");
    echo 'OK';
    // header('location: /message-page?type=info&message=ありがとうございます。メッセージを送信しました。');
  } else {
    echo '申し訳ございません。メッセージを送信に失敗しました。b';
    // header('location: /message-page?type=danger&message=申し訳ございません。メッセージを送信に失敗しました。 TEL 098－879－3316');
  };

  // if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
  //   include( $php_email_form );
  // } else {
  //   die( 'Unable to load the "PHP Email Form" Library!');
  // }

  // $contact = new PHP_Email_Form;
  // $contact->ajax = true;
  
  // $contact->to = $receiving_email_address;
  // $contact->from_name = $_POST['name'];
  // $contact->from_email = $_POST['email'];
  // $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  // $contact->add_message( $_POST['name'], 'From');
  // $contact->add_message( $_POST['email'], 'Email');
  // $contact->add_message( $_POST['message'], 'Message', 10);

  // echo $contact->send();
?>
