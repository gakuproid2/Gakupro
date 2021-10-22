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
  <title>中分類マスタ画面</title>
   
  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>中分類マスタ画面</p></div>
  </div>
</head>

<?php

  $CD = 0;
  //メインカテゴリーコードがあれば格納する
  if (!empty($_GET['Maincategory_CD'])) {
    $CD = $_GET['Maincategory_CD'];
  }

  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao = new dao_SubCategory_M();

  //ポストされたか確認する。
  if (count($_POST) > 1) {

    //利用フラグを宣言し、チェック時は1を格納するIf文    
    $UsageFlag = 0;
    if (isset($_POST["UsageFlag"])) {
      $UsageFlag = 1;
    };

    //POSTされた値を、変数と配列に格納
    $CD = $_POST["MainCategory_CD"];
    $info = array(
      'MainCategory_CD' => $_POST["MainCategory_CD"], 
      'SubCategory_CD' => $_POST["SubCategory_CD"], 
      'SubCategory_Name' => $_POST["SubCategory_Name"],
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
  $items = $dao->GET_Maincategory_m();
  //0行目
  $PullDown = "<option value = 0 >選択してください</option>";
  foreach ($items as $item_val) {

    $PullDown .= "<option value = " . $item_val['MainCategory_CD'];

    if ($CD == $item_val['MainCategory_CD']) {
      $PullDown .= " selected>";
    } else {
      $PullDown .= " >";
    }
      $PullDown  .= $item_val['MainCategory_Name'] . "</option>";
  }

  //表示用Table作成用（メインカテゴリーコードで参照）
  $Data_Table = $dao->Get_subCategory_M($CD);
  $Table = "";
  //取得したデータ数文ループ
  foreach ($Data_Table as $val) {
    $Table .="<tr class='List'>          
    <td style=display:none>" . $val['maincategory_cd'] . "</td>      
    <td>" . $val['MainCategory_name'] . "</td>
    <td>" . $val['subcategory_cd'] . "</td>
    <td>" . $val['subcategory_name'] . "</td>";

    if ($val['UsageFlag'] == 0) {
      $Table .= " <td>×</td>";
    } else {
      $Table .= " <td>〇</td>";
    }
    $Table .= "</tr>";
  }

  //CDが1以上時のみ
  if ($CD > 0) {
  //メインカテゴリーコードを渡しサブカテゴリーコードのMax値取得
    $Max_CD = $dao->Get_MaxCD($CD);    
  } else {
    $Max_CD = "";
  }
?>

<body>

  <form action="frm_SubCategory_M.php" method="post">
    <p>大分類：<select ID='MainCategory_CD' name='MainCategory_CD'><?php echo $PullDown; ?></select></p>
    <p>中分類コード：<input type='text' id="txt_SubCD" name='SubCategory_CD' value='<?php echo $Max_CD; ?>' readonly></p>
    <p>中分類名：<input type="text" id="txt_SubName" name="SubCategory_Name" autocomplete="off"></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
    <th>大分類名</th>
    <th>中分類コード</th>
    <th>中分類名</th>
    <th>利用フラグ</th>
    </tr>
    <?php echo $Table; ?>
  </table>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/common.js"></script>
</body>

<script>
  //画面遷移時
  $(window).on('load', function(event) {
    $("#btn_Insert").show();
    $("#btn_Update").hide();
    $("#btn_Delete").hide();
  });

  //テーブルクリック時
  $('.List').on('click', function() {

    var Main_CD = $(this).children('td')[0].innerText;
    $("#MainCategory_CD").val(Main_CD);

    var Sub_CD = $(this).children('td')[2].innerText;
    $("#txt_SubCD").val(Sub_CD);

    var Name = $(this).children('td')[3].innerText;
    $("#txt_SubName").val(Name);

    var UsageFlag = $(this).children('td')[4].innerText;

    if (UsageFlag == '〇') {
      $("#chk_UsageFlag").prop('checked', true);
    } else {
      $("#chk_UsageFlag").prop('checked', false);
    }

    $("#btn_Insert").hide();
    $("#btn_Update").show();
    $("#btn_Delete").show();

  });

  //プルダウン変更時
  document.getElementById("MainCategory_CD").onchange = function() {
    var CD = this.value;
    window.location.href = 'frm_SubCategory_M.php?Maincategory_CD=' + CD; // 通常の遷移
  };

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
    window.location.href = 'frm_SubCategory_M.php'
  });

  //登録、更新時の値チェック
  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#MainCategory_CD").val() == 0) {
      ErrorMsg += '大分類を選択してください。\n';
    }

    if ($("#txt_SubName").val() == "") {
      ErrorMsg += '中分類名を入力してください。\n';
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