<!DOCTYPE html>
<html lang="ja">

<?php
session_start(); //セッションスタート

//クラスファイルの読み込み
require_once '../php/common.php';
//クラスの生成
$common = new common();

//クラスファイルの読み込み
require_once '../dao/dao_MajorSubject_M.php';
//クラスの生成
$dao_MajorSubject_M = new dao_MajorSubject_M();

//クラスファイルの読み込み
require_once '../dao/dao_School_M.php';
//クラスの生成
$dao_School_M = new dao_School_M();

$HeaderInfo = $common->HeaderCreation(11);

$JS_Info = $common->Read_JSconnection();
?>

<style>
  .StudyPeriod::placeholder {
    text-align: right;
  }
</style>

<?php echo $HeaderInfo; ?>

<?php

if (isset($_POST["School_CD"])) {
  $School_CD = $_POST["School_CD"];
} else {
  $School_CD = 0;
};
if (isset($_POST["MajorSubject_Name"])) {
  $MajorSubject_Name = $_POST["MajorSubject_Name"];
} else {
  $MajorSubject_Name = '';
};
if (isset($_POST["MajorSubject_CD"])) {
  $MajorSubject_CD = $_POST["MajorSubject_CD"];
} else {
  $MajorSubject_CD = 0;
};
if (isset($_POST["StudyPeriod"])) {
  $StudyPeriod = $_POST["StudyPeriod"];
} else {
  $StudyPeriod = '';
};
if (isset($_POST["Remarks"])) {
  $Remarks = $_POST["Remarks"];
} else {
  $Remarks = '';
};
if (isset($_POST["UsageFlag"])) {
  $UsageFlag = $_POST["UsageFlag"];
} else {
  $UsageFlag = 0;
};

if (isset($_POST["DataChange"])) {

  $info = array(
    'School_CD' => $School_CD, 'MajorSubject_CD' => $MajorSubject_CD, 'MajorSubject_Name' => $MajorSubject_Name, 'StudyPeriod' => $StudyPeriod, 'Remarks' => $Remarks, 'UsageFlag' => $UsageFlag, 'Changer' => $_SESSION["Staff_ID"], 'UpdateDate' => date("Y-m-d H:i:s")
  );

  //データ変更種類に種別  1=登録、2=更新、3=論理削除
  $Processing = $_POST["DataChange"];
  $Result == false;
  //インサートとアップデートのみ
  if ($Processing == 1) {
    $Result = $dao_MajorSubject_M->DataChange($info, $Processing);
  } else if ($Processing == 2) {
    $Result = $dao_MajorSubject_M->DataChange($info, $Processing);
  } else if ($Processing == 3) {
    $Result = $dao_MajorSubject_M->DataChange($info, $Processing);
  }

  if ($Result == true) {
    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); //optional
  } else {
  }
}


//学校のプルダウン作成する為
$items = $dao_School_M->Get_School_M('', '');
//0行目
$PullDown = "<option value = 0 >選択してください</option>";
foreach ($items as $item_val) {

  $PullDown .= "<option value = " . $item_val['School_CD'];

  if ($School_CD == $item_val['School_CD']) {
    $PullDown .= " selected>";
  } else {
    $PullDown .= " >";
  }

  $PullDown .= $item_val['School_Name'] . "</option>";
}

//表示用Table作成用（メインカテゴリーコードで参照）
$Data_Table = $dao_MajorSubject_M->GET_Majorsubject_m($School_CD);
$Table = "
<table border='1'>
  <tr>
    <th>学校名</th><th>専攻コード</th><th>専攻名</th><th>在学期間</th><th>備考</th><th>利用フラグ</th>
  </tr>
";
//取得したデータ数文ループ
foreach ($Data_Table as $val) {
  $Table .= "<tr class='Table'>
  <td style=display:none>" . $val['school_cd'] . "</td>
  <td>" . $val['school_name'] . "</td>
  <td>" . $val['majorsubject_cd'] . "</td>
  <td>" . $val['majorsubject_name'] . "</td>
  <td>" . $val['studyPeriod'] . "</td>
  <td>" . $val['remarks'] . "</td>";

  if ($val['UsageFlag'] == 0) {
    $Table .= " <td>×</td>";
  } else {
    $Table .= " <td>〇</td>";
  }
  $Table .= "</tr>";
}
$Table .= "</table>";
//School_CDが1以上時のみ
if ($School_CD > 0) {
  //学校コードを渡し専攻コードのMax値取得
  $Max_MajorSubject_CD = $dao_MajorSubject_M->Get_MaxCD($School_CD);
} else {
  $Max_MajorSubject_CD = "";
}

?>

<body>

  <form action="frm_MajorSubject_M.php" method="post">
    <p>学校CD：<select id='School_CD' name='School_CD'><?php echo $PullDown; ?></select></p>
    <p>専攻CD：<input type='text' id='MajorSubject_CD' name='MajorSubject_CD' value='<?php echo $Max_MajorSubject_CD; ?>' readonly> </p>
    <p>専攻名：<input type="text" id='MajorSubject_Name' name="MajorSubject_Name" value='<?php echo $MajorSubject_Name; ?>' autocomplete="off"></p>
    <p>在学期間：<input type="text" id='StudyPeriod' class='StudyPeriod' name="StudyPeriod" value='<?php echo $StudyPeriod; ?>' placeholder="ヶ月" autocomplete="off"></p>
    <p>備考：<input type="text" id='Remarks' name="Remarks" value='<?php echo $Remarks; ?>' autocomplete="off"></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="DataChange" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="DataChange" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="DataChange" value="3">削除</button>
  </form>
  <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>

  <?php echo $Table; ?>

  <?php echo $JS_Info ?>

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
    $("#MajorSubject_CD").val(Major_CD);

    var Major_Name = $(this).children('td')[3].innerText;
    $("#MajorSubject_Name").val(Major_Name);

    var StudyPeriod = $(this).children('td')[4].innerText;
    $("#StudyPeriod").val(StudyPeriod);

    var Remarks = $(this).children('td')[5].innerText;
    $("#Remarks").val(Remarks);

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

    //ポストするキーと値を格納
    var DataArray = {
      School_CD: $("#School_CD").val(),
      MajorSubject_Name: $("#MajorSubject_Name").val(),
      StudyPeriod: $("#StudyPeriod").val(),
      Remarks: $("#Remarks").val()
    };

    //common.jsに実装
    originalpost("frm_MajorSubject_M.php", DataArray);

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

    if ($("#MajorSubject_Name").val() == "") {
      ErrorMsg += '専攻名を入力してください。\n';
    }

    if ($("#StudyPeriod").val() == "") {
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