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
  <title>専攻マスタ</title>

  <div class ='Header'>
    <?php echo $HeaderInfo; ?>
    <div class ='Header_ScreenName'><p>専攻マスタ画面</p></div>
  </div>
</head>

<body>

  <?php
  $CD = 0;
  //学校コードがあれば格納する
  if (!empty($_GET['School_CD'])) {
    $CD = $_GET['School_CD'];
  }
  
  //クラスファイルの読み込み
  require_once '../dao/dao_MajorSubject_M.php';
  //クラスの生成
  $dao = new dao_MajorSubject_M();
  
  //ポストされたか確認する。
  if (count($_POST) > 0) {
    //利用フラグを宣言し、チェック時は1を格納するIf文
    $UsageFlag = 0;
    if (isset ($_POST["UsageFlag"])){
      $UsageFlag = 1;
    };

    //POSTされた値を、変数と配列に格納
    $CD = $_POST["School_CD"];
    $info = array(
    'School_CD' => $_POST["School_CD"]
    ,'MajorSubject_CD' => $_POST["MajorSubject_CD"]
    ,'MajorSubject_Name' => $_POST["MajorSubject_Name"]
    ,'StudyPeriod' => $_POST["StudyPeriod"]
    ,'Remarks' => $_POST["Remarks"]
    ,'UsageFlag' => $UsageFlag
    ,'Changer' => $_SESSION["Staff_ID"]
    ,'UpdateDate' => date("Y-m-d H:i:s")
    );
    
    $Result = "";
    
    //インサートとアップデートのみ
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
  

  //学校のプルダウン作成する為
  $items = $dao->Get_School_M();
  //0行目
  $PullDown = "<option value = 0 >選択してください</option>";
  foreach ($items as $item_val) {
  
    $PullDown .= "<option value = " . $item_val['School_CD'];
    
    if ($CD == $item_val['School_CD']) {
      $PullDown .= " selected>";
    } else {
      $PullDown .= " >";
    }
  
    $PullDown .= $item_val['School_Name'] . "</option>";
  }
  
  $Table = "";

  //表示用Table作成用（メインカテゴリーコードで参照）
  $Data_Table = $dao->GET_Majorsubject_m($CD);
  
  //取得したデータ数文ループ
  foreach ($Data_Table as $val) {
    $Table .="<tr class='Table'>
    <td style=display:none>" . $val['school_cd'] . "</td>
    <td>" . $val['school_name'] . "</td>
    <td>" . $val['majorsubject_cd'] . "</td>
    <td>" . $val['majorsubject_name'] . "</td>
    <td>" . $val['studyPeriod'] . "</td>
    <td>" . $val['remarks'] . "</td>";

    if ($val['UsageFlag'] == 0) {
      $Table .=" <td>×</td>";
    } else {
      $Table .=" <td>〇</td>";
    }
    $Table .= "</tr>";
  }

  //CDが1以上時のみ
  if ($CD > 0) {
    //学校コードを渡し専攻コードのMax値取得
    $Max_CD = $dao->Get_MaxCD($CD);
  } else {
    $Max_CD = "";
  }
  
  ?>

  <form action="frm_MajorSubject_M.php" method="post">
    <p>学校CD：<select id='School_CD' name='School_CD'><?php echo $PullDown; ?></select></p>
    <p>専攻CD：<input type='text' id='txt_MajorCD' name='MajorSubject_CD' value='<?php echo $Max_CD; ?>' readonly> </p>
    <p>専攻名：<input type="text" id='txt_MajorName' name="MajorSubject_Name" autocomplete="off"></p>
    <p>在学期間：<input type="text" id='txt_StudyPeriod' name="StudyPeriod" autocomplete="off"></p>
    <p>備考：<input type="text" id='txt_Remarks' name="Remarks" autocomplete="off"></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
      <th>学校名</th>
      <th>専攻コード</th>
      <th>専攻名</th>
      <th>在学期間</th>
      <th>備考</th>
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
    var School_CD = $(this).children('td')[0].innerText;
    $("#School_CD").val(School_CD);

    var Major_CD = $(this).children('td')[2].innerText;
    $("#txt_MajorCD").val(Major_CD);

    var Major_Name = $(this).children('td')[3].innerText;
    $("#txt_MajorName").val(Major_Name);

    var StudyPeriod = $(this).children('td')[4].innerText;
    $("#txt_StudyPeriod").val(StudyPeriod);

    var Remarks = $(this).children('td')[5].innerText;
    $("#txt_Remarks").val(Remarks);

    var UsageFlag = $(this).children('td')[6].innerText;

    if (UsageFlag == '〇') {
      $("#chk_UsageFlag").prop('checked', true);
    } else {
      $("#chk_UsageFlag").prop('checked', false);
    }

    $("#btn_Insert").hide();
    $("#btn_Update").show();
    $("#btn_Delete").show();
  });

  document.getElementById("School_CD").onchange = function() {
    var CD = this.value;
    window.location.href = 'frm_MajorSubject_M.php?School_CD=' + CD; // 通常の遷移
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
    window.location.href = 'frm_MajorSubject_M.php'
  });


  function ValueCheck() {
    var ErrorMsg = '';
    if ($("#School_CD").val() == 0) {
      ErrorMsg += '学校CDを選択してください。\n';
    }

    if ($("#txt_MajorName").val() == "") {
      ErrorMsg += '専攻名を入力してください。\n';
    }

    if ($("#txt_StudyPeriod").val() == "") {
      ErrorMsg += '在学期間を入力してください。\n';
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