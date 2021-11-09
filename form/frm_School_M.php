<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation(10);  

  $JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<body>

  <?php
    $CD = 0;
    //学校区分があれば格納する
    if (!empty($_GET['School_Division'])) {
      //if ($_GET['chk_Search'] == 1) {
        $CD = $_GET['School_Division'];
      //}
    } //else {
      //$CD = 0;
    //}

    $check = "";
    //チェックボックスの０か１を格納する
    if (!empty($_GET['chk_Search'])) {
      if (!$_GET['chk_Search'] == 0) {
        $check = 'checked="checked"';
      } else {
        $check = "";
      }
    }

    //クラスファイルの読み込み
    require_once '../dao/dao_School_M.php';
    //クラスの生成
    $dao = new dao_School_M();

    //ポストされた確認する。
    if (count($_POST) > 0) {

      $UsageFlag = 0;
      if (isset ($_POST["UsageFlag"])){
        $UsageFlag = 1;
      };
      
      $info = array(
        'CD' => $_POST["CD"],
        'Division' => $_POST["Division"],
        'Name' => $_POST["Name"],
        'TEL' => $_POST["TEL"],
        'URL' => $_POST["URL"],
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

    //学校区分のプルダウン作成する為
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
    
    //School_MのMaxCD取得処理
    $Max_CD = $dao->Get_MaxCD();
    
    $Data_Table = $dao->Get_School_M($CD, $check);
    $Table = "";
    
    foreach ($Data_Table as $val) {
      $Table .= "<tr class='Table'>
      <td>" . $val['School_CD'] . "</td>
      <td>" . $val['School_Division'] . "</td>
      <td>" . $val['School_Name']." </td>
      <td>" . $val['TEL']." </td>
      <td>" . $val['URL']." </td>";
    
      if ($val['UsageFlag'] == 0) {
        $Table .=" <td>×</td>";
      } else {
        $Table .=" <td>〇</td>";
      }
      
      
      $Table .= "</tr>";
    }

  ?>

  <form action="frm_School_M.php" method="post">
    <p>学校CD：<input type="text" id="txt_CD" name="CD" value='<?php echo $Max_CD; ?>' readonly> </p>
    <p>
      学校区分：<select id='School_Division' name='Division'><?php echo $PullDown; ?></select>　
      データ絞り込み機能：<input type="checkbox" id="chk_Search" name="Search" value="1" <?php echo $check; ?>>
    </p>
    <p>学校名：<input type="text" id="txt_Name" name="Name" autocomplete="off"></p>
    <p>代表電話番号：<input type="text" id="txt_TEL" name="TEL" autocomplete="off"></p>
    <p>ホームページURL：<input type="text" id="txt_URL" name="URL" autocomplete="off"></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
      <th>学校CD</th>
      <th>学校区分</th>
      <th>学校名</th>
      <th>代表電話番号</th>
      <th>ホームページURL</th>
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
      //学校CD
      var School_CD = $(this).children('td')[0].innerText;
      $("#txt_CD").val(School_CD);

      //学校区分
      var School_Division = $(this).children('td')[1].innerText;
      $("#School_Division").val(School_Division);

      //学校名
      var School_Name = $(this).children('td')[2].innerText;
      $("#txt_Name").val(School_Name);

      //代表電話番号
      var TEL = $(this).children('td')[3].innerText;
      $("#txt_TEL").val(TEL);

      //ホームページURL
      var URL = $(this).children('td')[4].innerText;
      $("#txt_URL").val(URL);

      //利用フラグ
      var UsageFlag = $(this).children('td')[5].innerText;

    if (UsageFlag == '〇') {
      $("#chk_UsageFlag").prop('checked', true);
    } else {
      $("#chk_UsageFlag").prop('checked', false);
    }

    $("#btn_Insert").hide();
    $("#btn_Update").show();
    $("#btn_Delete").show();
  });

  //チェックボックスでデータを絞り込む機能を作成
  document.getElementById("chk_Search").onchange = function() {
    const Division = document.getElementById("School_Division");
    const value = Division.value;
    var check;
    <?php 
    if ($check != "") {
    ?>
    check = 0;
    <?php
    } else {
    ?>
    check = 1;
    <?php
    }
    ?>
    window.location.href = 'frm_School_M.php?School_Division=' + value + '&chk_Search=' + check; // 通常の遷移
  };

  //チェックボックスがON状態の場合
  <?php
  if (!empty($_GET['chk_Search'])) {
    if ($_GET['chk_Search'] == 1) {
  ?>
  document.getElementById("School_Division").onchange = function() {
    var CD = this.value;
    var check = 1;
    window.location.href = 'frm_School_M.php?School_Division=' + CD + '&chk_Search=' + check; // 通常の遷移
  }
  <?php
    }
  }
  ?>

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

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#School_Division").val() == "") {
      ErrorMsg += '学校区分を選択してください。\n';
    }

    if ($("#txt_Name").val() == "") {
      ErrorMsg += '学校名を入力してください。\n';
    }

    if ($("#txt_TEL").val() == "") {
      ErrorMsg += '代表電話番号を入力してください。\n';
    }

    if ($("#txt_URL").val() == "") {
      ErrorMsg += 'ホームページURLを入力してください。\n';
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