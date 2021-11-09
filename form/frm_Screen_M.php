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
  <title>画面設定画面</title>
   
  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>画面設定画面</p></div>
  </div>
</head>

<?php
 
  //クラスファイルの読み込み
  require_once '../dao/dao_Screen_M.php';
  //クラスの生成
  $dao = new dao_Screen_M();

  //ポストされた確認する。
  if (count($_POST) > 1) {
    
    $UsageFlag = 0;
    if (isset($_POST["UsageFlag"])) {
      $UsageFlag = 1;
    };

    $info = array(
      'Screen_ID' => $_POST["Screen_ID"],
      'Screen_Name' => $_POST["Screen_Name"],
      'Screen_Path' => $_POST["Screen_Path"],
      'Authority' => $_POST["Authority"],
      'UsageFlag' => $UsageFlag,
      'Changer' => $_SESSION["Staff_ID"],
      'UpdateDate' => date("Y-m-d H:i:s")
    );

    $Result = "";

    //登録、削除、更新の分岐
    if (isset($_POST['Insert'])) {
      $Result = $dao->DataChange($info, 1);
    } else if (isset($_POST['Update'])) {
      $Result = $dao->DataChange($info, 2);
    } else if (isset($_POST['Delete'])) {
      $Result = $dao->DataChange($info, 3);
    }

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); //optional
  }

  //メインカテゴリーのプルダウン作成する為
  $items = $dao->GET_Authority();
  //0行目
  $PullDown = "<option value = 0 >選択してください</option>";
  foreach ($items as $item_val) {

    $PullDown .= "<option value = " . $item_val['SubCategory_CD'] . '>'. $item_val['SubCategory_Name'] . "</option>";
  }

  //Screen_MのMaxCD取得処理
  $Max_CD = $dao->Get_MaxCD();

  $Data_Table = $dao->Get_Screen_M();

  $Table = "";
  foreach ($Data_Table as $val) {

    $Table .=
    "<tr class='Table'>
      <td>" . $val['Screen_ID'] . "</td>
      <td>" . $val['Screen_Name'] . " </td>
      <td>" . $val['Screen_Path'] . " </td>
      <td style=display:none>" . $val['Authority'] . "</td>      
      <td>" . $val['AuthorityInfo'] . " </td>
      <td>" . $val['ChangerName'] . " </td>
      <td>" . $val['UpdateDate'] . " </td>
    "
    ;

    if ($val['UsageFlag'] == 0) {
      $Table .= " <td>×</td>";
    } else {
      $Table .= " <td>〇</td>";
    }

    $Table .= "</tr>";
  }
?>
<body>

  <form action="frm_Screen_M.php" method="post">
    <p>画面ID：<input type="text" id="txt_Screen_ID" name="Screen_ID" value='<?php echo $Max_CD; ?>' readonly> </p>
    <p>画面名：<input type="text" id="txt_Screen_Name" name="Screen_Name" autocomplete="off"></p>
    <p>画面パス：<input type="text" id="txt_Screen_Path" name="Screen_Path" autocomplete="off"></p>
    <p>権限選択：<select id='Authority' name='Authority'><?php echo $PullDown; ?></select></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
    <th>画面ID</th>
    <th>画面名</th>
    <th>画面パス</th>
    <th>操作権限</th>
    <th>最終更新者</th>
    <th>最終更新日</th>
    <th>利用フラグ</th>
    </tr>
    <?php echo $Table; ?>
  </table>

  <?php echo $JS_Info?>

</body>

<script>
  //画面起動時の処理
  $(window).on('load', function(event) {
    $("#btn_Insert").show();
    $("#btn_Update").hide();
    $("#btn_Delete").hide();
  });

  //テーブルクリック時
  $('.Table').on('click', function() {
    var Screen_ID = $(this).children('td')[0].innerText;
    $("#txt_Screen_ID").val(Screen_ID);

    var Screen_Name = $(this).children('td')[1].innerText;
    $("#txt_Screen_Name").val(Screen_Name);

    var Screen_Path = $(this).children('td')[2].innerText;
    $("#txt_Screen_Path").val(Screen_Path);

    var Authority = $(this).children('td')[3].innerText;
    $("#Authority").val(Authority);

    var UsageFlag = $(this).children('td')[5].innerText;

    if (UsageFlag == '〇') {
      $("#chk_UsageFlag").prop('checked', true);
    } else {
      $("#chk_UsageFlag").prop('checked', false);
    }

    $("#btn_Insert").hide();
    document.getElementById("btn_Insert").disabled = true;
    $("#btn_Update").show();
    $("#btn_Delete").show();    

  });


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

  //更新ボタンクリック時
  $('#btn_Update').on('click', function() {

    if (ValueCheck() == false) {
      return false;
    }

    if (window.confirm('更新してもよろしいですか？')) {
      $('#form_id').submit();
    } else {
      return false;
    }
  });

  //削除ボタンクリック時
  $('#btn_Delete').on('click', function() {

    if (window.confirm('削除してもよろしいですか？')) {
      $('#form_id').submit();
    } else {
      return false;
    }

  });

  //クリアボタンクリック時
  $('#btn_Clear').on('click', function() {
    window.location.href = 'frm_Screen_M.php'
  });

  //登録、更新時の値チェック
  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_Screen_Name").val() == "") {
      ErrorMsg += '画面名を入力してください。\n';
    }

    if ($("#txt_Screen_Path").val() == "") {
      ErrorMsg += '画面パスを入力してください。\n';
    }

    if ($("#Authority").val() == "0") {
      ErrorMsg += '権限を選択してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg); 
      return false;
    } else {
      return true;
    }
  }
  
</script>

</html>