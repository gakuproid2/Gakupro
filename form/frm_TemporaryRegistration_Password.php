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
  <title>仮登録_パスワード確認</title>

  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>仮登録_パスワード画面</p></div>
  </div>
</head>

<body>

  <?php
    //session_start();
    
    //$_SESSION[$_GET['ID']];

    //クラスファイルの読み込み
    require_once '../dao/dao_TemporaryRegistration_Password.php';
    //クラスの生成
    $dao = new dao_TemporaryRegistration_Password();

    //URLに付与されたIDをgetする
    //$kariID;
    if (!empty($_GET['ID'])) {
      $_SESSION["kariID"] = $_GET['ID'];
    }

    if (count($_POST) > 0) {

      //入力された値を取得する（パスワード）
      $Password = $_POST["Password"];
      //正しいIDを取得
      $ID = $_SESSION["kariID"] / $Password;

      //IDとパスワードをdaoに送る。
      $item = $dao->Chackdata($ID, $Password);

      if (!empty($item)) {
        // データベースに登録されているIDとパスワードが一致
        $_SESSION['ID'] = $ID;
        header('Location: frm_DetailedTemporaryRegistration.php');
        return;
      } else {
        // データベースに登録されているIDとパスワードが不一致
        echo "パスワードが間違っています。再度入力してください。";
        echo '<p><a href="http://localhost/Gakupro/form/frm_TemporaryRegistration_Password.php">戻る</a></p>';
        return;
      }



      Header('Location: ' . $_SERVER['PHP_SELF']);
      //exit(); //optional
    }




  ?>

  <form action="frm_TemporaryRegistration_Password.php" method="POST">
    <p>パスワード：<input type="text" id="txt_Password" name="Password" autocomplete="off"></p>
    <button class="btn_Check" id="btn_Check" name="Check" value="1">確認</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="2">クリア</button>
  </form>


  <?php echo $JS_Info?>
</body>


<script>
  //画面起動時の処理
  $(window).on('load', function(event) {
    
  });

  //登録ボタンクリック時
  $('#btn_Insert').on('click', function() {
    if (ValueCheck() == false) {
      return false;
    }

    if (window.confirm('入力した値でよろしいですか？')) {
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
    if ($("#txt_Password").val() == "") {
      ErrorMsg += '4桁のパスワードを入力してください。\n';
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