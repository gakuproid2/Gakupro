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
  <title>詳細仮登録</title>

  <div class ='Header'>
    
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>詳細仮登録画面</p></div>
  </div>
</head>

<body>

  <?php
    //クラスファイルの読み込み
    require_once '../dao/dao_DetailedTemporaryRegistration.php';
    //クラスの生成
    $dao = new dao_DetailedTemporaryRegistration();

    // メールアドレス登録時に採番されたIDを元にデータを取得
    $items = $dao->Get_TemporaryMember_M($_SESSION['ID']);

    // 取得したデータからメールアドレスを抽出し変数に格納
    foreach ($items as $item_val) {
      $mailaddress = $item_val['Mailaddress'];
    }

    if (count($_POST) > 0) {

      //メールアドレスの登録処理を追加
      $info = array(
        //'Mailaddress' => $_POST['Mailaddress'],　メールアドレスはすでに登録されているのでいらないかも
        'Name' => $_POST['Name']
        // 以下に追加で登録したい項目があれば追記していく
      );

      $Result = "";

      // UPDATE処理を以下に追加　ここから作業開始
      //登録
      if (isset($_POST['Insert'])) {
        $Result = $dao->DataChange($info, 1);
      }


      Header('Location: ' . $_SERVER['PHP_SELF']);
      exit(); //optional
    }




  ?>

  <form action="frm_DetailedTemporaryRegistration.php" method="POST">
    <p>メールアドレス：<input type="text" id="txt_MailAddress" name="Mailaddress" value="<?php echo $mailaddress; ?>" autocomplete="off" readonly></p>
    <p>名前：<input type="text" id="txt_Name" name="Name" autocomplete="off"></p>
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

  $("#btn_Insert").show();
  $("#btn_Clear").show();
  $("#btn_Return").hide();  


  

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
    window.location.href = 'frm_DetailedTemporaryRegistration.php'
  });

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_MailAddress").val() == "") {
      ErrorMsg += 'メールアドレスを入力してください。\n';
    }

    if ($("#txt_Name").val() == "") {
      ErrorMsg += '名前を入力してください。\n';
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