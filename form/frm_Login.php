<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>ログイン画面</title>
</head>

<?php

  $_SESSION = array();

  //クラスファイルの読み込み
  require_once '../dao/dao_Login.php';
  //クラスの生成
  $dao = new dao_Login;

  $alert = "";
  //ポストされた確認する。
  if (count($_POST) > 0) {

    $info = array(
    'Login_ID' => $_POST["Login_ID"],
    'Password' => $_POST["Password"]
    );

    if (isset($_POST['Login'])) {

      $Data_Table = $dao->MatchConfirmation($info);

      $Judgement = false;

      foreach ($Data_Table as $val) {
        //セッションスタートし取得したstaff情報をセッション変数に格納
        session_start(); 
        $_SESSION["Staff_ID"] = $val['Staff_ID'];
        $_SESSION["Staff_Name"] = $val['Staff_Name'];
        $_SESSION["NickName"] = $val['NickName'];
        $_SESSION["Authority"] = $val['Authority'];

        $Judgement = true;
      }

      //パスワードとログインIDで一致する情報が無い場合はエラー表示し一致する情報があればメインメニュー画面に遷移
      if ($Judgement == false) {      
        $alert = "<script type='text/javascript'>alert('ログインIDとパスワードで一致する情報がありません。');</script>";
      } else {
        header("Location: frm_MainMenu.php");
      }
    }
  }
?>

<body>
  <h1>ログイン画面</h1>
  <?php echo $alert; ?>

  <form action="frm_Login.php" method="post">
    <p>ログインID：<input type="text" id="Login_ID" name="Login_ID" autocomplete="off"></p>
    <p>パスワード：<input type="text" id="Password" name="Password" autocomplete="off"></p>

    <button class="btn_Login" id="btn_Login" name="Login" value="1">ログイン</button>
  </form>

  <script src="../js/jquery-3.6.0.min.js"></script>
</body>

<script>
  //ログインボタンクリック時
  $('#btn_Login').on('click', function() {
    if (ValueCheck() == false) {
      return false;
    } else {
      $('#form_id').submit();
      }
    }
  );

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#Login_ID").val() == "") {

      ErrorMsg = 'ログインIDを入力してください。';
      window.alert(ErrorMsg); // 
      return false;
    }

    if ($("#Password").val() == "") {

      ErrorMsg = 'パスワードを入力してください。';
      window.alert(ErrorMsg); // 
     return false;
    }
   
    return true;
  }
</script>

</html>