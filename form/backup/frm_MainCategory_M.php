<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation();  
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/Header.css">
  <title>大分類マスタ画面</title>
   
  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>大分類マスタ画面</p></div>
  </div>
</head>

<?php
 
  //クラスファイルの読み込み
  require_once '../dao/dao_MainCategory_M.php';
  //クラスの生成
  $dao = new dao_MainCategory_M();

  //ポストされた確認する。
  if (count($_POST) > 1) {

    $UsageFlag = 0;
    if (isset($_POST["UsageFlag"])) {
      $UsageFlag = 1;
    };

    $info = array(
      'CD' => $_POST["CD"],
      'Name' => $_POST["Name"],
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

  //MainCategory_MのMaxCD取得処理
  $Max_CD = $dao->Get_MaxCD();

  $Data_Table = $dao->Get_MainCategory_M();

  $Table = "";
  foreach ($Data_Table as $val) {

    $Table .=
    "<tr class='Table'>
    <td>" . $val['MainCategory_CD'] . "</td>
    <td>" . $val['MainCategory_Name'] . " </td>";

    if ($val['UsageFlag'] == 0) {
      $Table .= " <td>×</td>";
    } else {
      $Table .= " <td>〇</td>";
    }

    $Table .= "</tr>";
  }
?>
<body>

  <form action="frm_MainCategory_M.php" method="post">
    <p>大分類コード：<input type="text" id="txt_CD" name="CD" value='<?php echo $Max_CD; ?>' readonly> </p>
    <p>大分類名：<input type="text" id="txt_Name" name="Name" autocomplete="off"></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
    <th>大分類コード</th>
    <th>大分類名</th>
    <th>利用フラグ</th>
    </tr>
    <?php echo $Table; ?>
  </table>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/common.js"></script>
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
    var CD = $(this).children('td')[0].innerText;
    $("#txt_CD").val(CD);

    var Name = $(this).children('td')[1].innerText;
    $("#txt_Name").val(Name);

    var UsageFlag = $(this).children('td')[2].innerText;

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
    window.location.href = 'frm_MainCategory_M.php'
  });

  //登録、更新時の値チェック
  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_Name").val() == "") {
      ErrorMsg += '大分類名を入力してください。\n';
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