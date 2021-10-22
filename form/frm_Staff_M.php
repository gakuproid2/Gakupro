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
  <title>スタッフマスタ</title>

  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>スタッフマスタ画面</p></div>
  </div>
</head>

<body>

  <?php

  $CD = 0;
  
  //サブカテゴリーコードがあれば格納する
  if (!empty($_GET['SubCategory_CD'])) {
    $CD = $_GET['SubCategory_CD'];
  }

  //クラスファイルの読み込み
  require_once '../dao/dao_Staff_M.php';
  //クラスの生成
  $dao = new dao_Staff_M();

  //ポストされた確認する。
  if (count($_POST) > 0) {

    $UsageFlag = 0;
    if (isset ($_POST["UsageFlag"])){
      $UsageFlag = 1;
    };

    //名前の結合
    $Name = $_POST["LastName"] . "　" . $_POST["Name"];
    $NameYomi = $_POST["LastNameYomi"] . " " . $_POST["NameYomi"];
    
    $info = array(
      'ID' => $_POST["ID"],
      'Name' => $Name,
      'NameYomi' => $NameYomi,
      'NickName' => $_POST["NickName"],
      'LoginID' => $_POST["LoginID"],
      'Password' => $_POST["Password"],
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

  
  //権限のプルダウン作成する為
  $items = $dao->GET_Subcategory_m();
  //0行目
  $PullDown = "<option value = 0 >選択してください</option>";
  foreach ($items as $item_val) {

    $PullDown .= "<option value = " . $item_val['SubCategory_CD'];

    if ($CD == $item_val['SubCategory_CD']) {
      $PullDown .= " selected>";
    } else {
      $PullDown .= " >";
    }
    $PullDown  .= $item_val['SubCategory_Name'] . "</option>";
  }
  

  
  //Staff_MのMaxCD取得処理
  $Max_CD = $dao->Get_MaxCD();
  
  $Data_Table = $dao->Get_Staff_M();
  $Table = "";
  
  
  foreach ($Data_Table as $val) {
    $Table .= "<tr class='Table'>
    <td>" . $val['Staff_ID'] . "</td>
    <td>" . $val['Staff_Name'] . "</td>
    <td>" . $val['Staff_NameYomi']." </td>
    <td>" . $val['NickName']." </td>
    <td>" . $val['Login_ID']." </td>
    <td>" . $val['Password']." </td>
    <td>" . $val['Authority']." </td>";
  
    if ($val['UsageFlag'] == 0) {
      $Table .=" <td>×</td>";
    } else {
      $Table .=" <td>〇</td>";
    }
    
    
    $Table .= "</tr>";
  }
  

  ?>

  <form action="frm_Staff_M.php" method="post">
    <p>スタッフID：<input type="text" id="txt_ID" name="ID" value='<?php echo $Max_CD; ?>' readonly></p>
    <p>
      氏名　
      姓：<input type="text" id="txt_LastName" name="LastName" autocomplete="off">　
      名：<input type="text" id="txt_Name" name="Name" autocomplete="off">
    </p>
    <p>
      氏名(ﾌﾘｶﾞﾅ)
      姓：<input type="text" id="txt_LastName_Yomi" name="LastNameYomi" autocomplete="off">　
      名：<input type="text" id="txt_Name_Yomi" name="NameYomi" autocomplete="off">
    </p>
    <p>ニックネーム：<input type="text" id="txt_NickName" name="NickName" autocomplete="off"></p>
    <p>ログインID：<input type="text" id="txt_LoginID" name="LoginID" autocomplete="off"></p>
    <p>パスワード：<input type="text" id="txt_Password" name="Password" autocomplete="off"></p>
    <p>権限：<select id="Authority" name="Authority"><?php echo $PullDown; ?></select></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
      <th>スタッフID</th>
      <th>名前</th>
      <th>ﾌﾘｶﾞﾅ</th>
      <th>ニックネーム</th>
      <th>ログインID</th>
      <th>パスワード</th>
      <th>権限</th>
      <th>利用フラグ</th>
    </tr>
    <?php echo $Table; ?>
  </table>

  <?php echo $JS_Info?>
</body>

<script>
  $(window).on('load', function(event) {
    $("#btn_Insert").show();
    $("#btn_Update").hide();
    $("#btn_Delete").hide();
  });

  $('.Table').on('click', function() {
      //スタッフID
      var Staff_ID = $(this).children('td')[0].innerText;
      $("#txt_ID").val(Staff_ID);

      //名前    取得した名前を姓と名で分けてテキストに格納する
      var StaffName = $(this).children('td')[1].innerText;
      var StaffNameSplit = StaffName.split('　');
      $("#txt_LastName").val(StaffNameSplit[0]);
      $("#txt_Name").val(StaffNameSplit[1]);

      //ﾌﾘｶﾞﾅ
      var StaffName_Yomi = $(this).children('td')[2].innerText;
      var StaffName_YomiSplit = StaffName_Yomi.split(' ');
      $("#txt_LastName_Yomi").val(StaffName_YomiSplit[0]);
      $("#txt_Name_Yomi").val(StaffName_YomiSplit[1]);

      //ニックネーム
      var TEL = $(this).children('td')[3].innerText;
      $("#txt_NickName").val(TEL);

      //ログインID
      var URL = $(this).children('td')[4].innerText;
      $("#txt_LoginID").val(URL);

      //パスワード
      var URL = $(this).children('td')[5].innerText;
      $("#txt_Password").val(URL);

      //権限
      var URL = $(this).children('td')[6].innerText;
      $("#Authority").val(URL);

      //利用フラグ
      var UsageFlag = $(this).children('td')[7].innerText;

    if (UsageFlag == '〇') {
      $("#chk_UsageFlag").prop('checked', true);
    } else {
      $("#chk_UsageFlag").prop('checked', false);
    }

    $("#btn_Insert").hide();
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
    window.location.href = 'frm_Staff_M.php'
  });

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_LastName").val() == "") {
      ErrorMsg += '姓を入力してください。\n';
    }

    if ($("#txt_Name").val() == "") {
      ErrorMsg += '名前を入力してください。\n';
    }

    if ($("#txt_LastName_Yomi").val() == "") {
      ErrorMsg += '姓(ﾌﾘｶﾞﾅ)を入力してください。\n';
    }

    if ($("#txt_Name_Yomi").val() == "") {
      ErrorMsg += '名前(ﾌﾘｶﾞﾅ)を入力してください。\n';
    }

    if ($("#txt_NickName").val() == "") {
      ErrorMsg += 'ニックネームを入力してください。\n';
    }

    if ($("#txt_LoginID").val() == "") {
      ErrorMsg += 'ログインIDを入力してください。\n';
    }

    if ($("#txt_Password").val() == "") {
      ErrorMsg += 'パスワードを入力してください。\n';
    }

    if ($("#Authority").val() == "") {
      ErrorMsg += '権限を選択してください。\n';
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