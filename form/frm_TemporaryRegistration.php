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
  <title>仮登録</title>

  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>仮登録画面</p></div>
  </div>
</head>

<body>

  <?php
    //クラスファイルの読み込み
    require_once '../dao/dao_TemporaryRegistration.php';
    //クラスの生成
    $dao = new dao_TemporaryRegistration();

    //登録状態を保持する変数（0:登録前　1:登録後）
    //$Status;

    if (count($_POST) > 0) {

      //メールアドレスの登録処理を追加
      $info = array(
        'Password' => $dao->CreatePassword(),
        'Mailaddress' => $_POST['Mailaddress']
      );

      $Result = "";

      //登録
      if (isset($_POST['Insert'])) {
        $Result = $dao->DataChange($info, 1);
      }

      
      //登録ができたか確認＋メール自動送信
      $result = $dao->ChackPassword($info);
      if ($result == 1) {
        echo '<p>メールを送信しました。メールのURLから登録の続きを行ってください。</p>';
        echo '<p><a href="http://localhost/Gakupro/form/frm_TemporaryRegistration.php">戻る</a></p>';
      } else if ($result == 0) {
        echo '<p>メールの送信に失敗しました。時間を空けて再度ご登録お願いいたします。</p>';
      }
      return;
      $Status = 1;

      Header('Location: ' . $_SERVER['PHP_SELF']);
      exit(); //optional
    }




  ?>

  <form action="frm_TemporaryRegistration.php" method="POST">
    <p>メールアドレス：<input type="text" id="txt_MailAddress" name="Mailaddress" autocomplete="off"></p>
    <input type="hidden" id="RegistStatus" name="Status" value='<?php echo $Status; ?>'>
    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="2">クリア</button>
    <!--<button class="btn_Return" id="btn_Return" name="Return" value="3">最初の画面に戻る</button>-->
  </form>


  <?php echo $JS_Info?>
</body>


<script>
  //画面起動時の処理
  $(window).on('load', function(event) {
    
    
  });

  if ($("#RegistStatus").val() == 0) {
      $("#btn_Insert").show();
      $("#btn_Clear").show();
      $("#btn_Return").hide();
    } else if ($("#RegistStatus").val() == 1) {
      //登録終了後の処理
      $("#btn_Insert").hide();
      $("#btn_Clear").hide();
      $("#btn_Return").show();
    }

  

  //登録ボタンクリック時
  $('#btn_Insert').on('click', function() {
    if (ValueCheck() == false) {
      return false;
    }

    if (window.confirm('登録してもよろしいですか？')) {
      $('#form_id').submit();
    } else {
      return false;
    }
  });
  
  //クリアボタンクリック時
  $('#btn_Clear').on('click', function() {
    window.location.href = 'frm_TemporaryRegistration.php'
  });

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_MailAddress").val() == "") {
      ErrorMsg += 'メールアドレスを入力してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg); // 
      return false;
    } else {
      return true;
    }
  }

</script>


</html>