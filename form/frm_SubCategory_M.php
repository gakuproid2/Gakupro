<!DOCTYPE html>
<html lang="ja">

<?php

session_start(); //セッションスタート

//クラスファイルの読み込み
require_once '../php/common.php';
//クラスの生成
$common = new common();

//クラスファイルの読み込み
require_once '../dao/dao_SubCategory_M.php';
//クラスの生成
$dao_SubCategory_M = new dao_SubCategory_M();

//クラスファイルの読み込み
require_once '../dao/dao_MainCategory_M.php';
//クラスの生成
$dao_MainCategory_M = new dao_MainCategory_M();

$HeaderInfo = $common->HeaderCreation(5);

$JS_Info = $common->Read_JSconnection();

?>

<?php echo $HeaderInfo; ?>

<?php

//非post時は初期値を設定する。['']or[0] Start--
if (isset($_POST["MainCategory_CD"])) {
  $MainCategory_CD = $_POST["MainCategory_CD"];
} else {
  $MainCategory_CD = 0;
};
if (isset($_POST["SubCategory_CD"])) {
  $SubCategory_CD = $_POST["SubCategory_CD"];
} else {
  $SubCategory_CD = 0;
};
if (isset($_POST["SubCategory_Name"])) {
  $SubCategory_Name = $_POST["SubCategory_Name"];
} else {
  $SubCategory_Name = '';
};
//非post時は初期値を設定する。['']or[0] End--

//データ更新処理実行時  Start--
if (isset($_POST["ProcessingType"])) {

  $info = array(
    'MainCategory_CD' => $MainCategory_CD,
    'SubCategory_CD' => $SubCategory_CD,
    'SubCategory_Name' => $SubCategory_Name,
    'ProcessingType' => $_POST["ProcessingType"]
  );

  $Result = $dao_SubCategory_M->DataChange($info);

  Header('Location: ' . $_SERVER['PHP_SELF']);
  exit(); //optional
}
//データ更新処理実行時  End--

//メインカテゴリーのプルダウン作成する為
$items = $dao_MainCategory_M->GET_MainCategory_m();
//0行目
$PullDown = "<option value = 0 >大分類選択</option>";
foreach ($items as $item_val) {

  $PullDown .= "<option value = " . $item_val['MainCategory_CD'];

  if ($MainCategory_CD == $item_val['MainCategory_CD']) {
    $PullDown .= " selected>";
  } else {
    $PullDown .= " >";
  }
  $PullDown  .= $item_val['MainCategory_Name'] . "</option>";
}

//表示用Table作成用（メインカテゴリーコードで参照）
$Data_Table = $dao_SubCategory_M->Get_SubCategory_M($MainCategory_CD);

$Data_Count = count($Data_Table);

//Table作成 Start--
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr  data-maincd='' >
  <th>大分類名</th>
  <th>中分類コード</th>
  <th>中分類名</th>
  <th id='TableDataCount'>データ総数[".$Data_Count. "件]</th>
</tr>
";
foreach ($Data_Table as $val) {

  if ($val['UsageSituation'] == 0) {
    $IconType = "<i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>";
  } else {
    $IconType = "<i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>";
  }

  $Table .= "
  <tr data-maincd='" . $val['MainCategory_CD'] . "' >
    <td style=display:none>" . $val['MainCategory_CD'] . "</td>
    <td>" . $val['MainCategory_Name'] . "</td>
    <td>" . $val['SubCategory_CD'] . " </td>
    <td>" . $val['SubCategory_Name'] . " </td>
    <td>

      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-maincd='" . $val['MainCategory_CD'] . "'
      data-mainname='" . $val['MainCategory_Name'] . "'  
      data-subcd='" . $val['SubCategory_CD'] . "'
      data-subname='" . $val['SubCategory_Name'] . "'               
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-maincd='" . $val['MainCategory_CD'] . "'
      data-mainname='" . $val['MainCategory_Name'] . "'  
      data-subcd='" . $val['SubCategory_CD'] . "'
      data-subname='" . $val['SubCategory_Name'] . "'                     
      data-usage='" . $val['UsageSituation'] . "' >
      " . $IconType . "              
      </button>

    </td>
  </tr>";
}

$Table .= "</table>";
//Table作成 End--

?>

<body>
  <div>
    <a href="" class="btn btn--red btn--radius btn--cubic" data-bs-toggle='modal' data-bs-target='#InsertModal'><i class='fas fa-plus-circle'></i>新規追加</a>
    <select name='MainCategory_CD' id='MainCategory_CD'><?php echo $PullDown; ?></select>
  </div>
  <?php echo $Table; ?>

  <!-- 登録用Modal -->
  <div class="modal fade" id="InsertModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="InsertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="InsertModalLabel">登録確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <div class="form-group row">
            <label for="Insert_MainCategory_CD" class="col-md-3 col-form-label">大分類</label>
            <select name='Insert_MainCategory_CD' id='Insert_MainCategory_CD' class="form-control col-md-3"><?php echo $PullDown; ?></select>
          </div>

          <div class="form-group row">
            <label for="Insert_SubCategory_Name" class="col-md-3 col-form-label">中分類名</label>
            <input type="text" name="Insert_SubCategory_Name" id="Insert_SubCategory_Name" value="" class="form-control col-md-3">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary ModalInsertButton">登録</button>
          </div>

        </div>

      </div>
    </div>
  </div>


  <!-- 更新用Modal -->
  <div class="modal fade" id="UpdateModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="UpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="UpdateModalLabel">更新確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <span id="Update_MainCategory_CD" hidden></span>

          <div class="form-group row">
            <label for="Update_MainCategory_Name" class="col-md-3 col-form-label">大分類名</label>
            <input type="text" name="Update_MainCategory_Name" id="Update_MainCategory_Name" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">
            <label for="Update_SubCategory_CD" class="col-md-3 col-form-label">中分類コード</label>
            <input type="text" name="Update_SubCategory_CD" id="Update_SubCategory_CD" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">
            <label for="Update_SubCategory_Name" class="col-md-3 col-form-label">中分類名</label>
            <input type="text" name="Update_SubCategory_Name" id="Update_SubCategory_Name" value="" class="form-control col-md-3">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary ModalUpdateButton">更新</button>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- 利用状況更新用Modal -->
  <div class="modal fade" id="ChangeUsageSituationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="ChangeUsageSituationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="ChangeUsageSituationModalLabel">利用状況変更確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <p>大分類名 = <span id="ChangeUsageSituation_MainCategory_Name"></span> | 中分類名 = <span id="ChangeUsageSituation_SubCategory_Name"></span></p>

          <span id="ChangeUsageSituation_MainCategory_CD" hidden></span>
          <span id="ChangeUsageSituation_SubCategory_CD" hidden></span>
          <span id="ChangeUsageSituation_UsageSituation" hidden></span>
          <p><span id="ChangeUsageSituation_Message"></span></p>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary ModalChangeUsageSituationButton"><span id="ChangeUsageSituation_ButtonName"></span></button>
          </div>

        </div>

      </div>
    </div>
  </div>



  <?php echo $JS_Info ?>
</body>

<script>
  document.getElementById("MainCategory_CD").onchange = function() {
    
    NarrowDownDataTable();   
  };
  
  //table絞り込み
  function NarrowDownDataTable() {    

  var Select_MainCategory_CD = document.getElementById('MainCategory_CD').value;   

  // table要素を取得
  var TargetTable = document.getElementById('DataInfoTable');      

  var TableDataCount = 0;
  for (i = 0, len = TargetTable.rows.length; i < len; i++) {

    var Target_MainCategory_CD = TargetTable.rows[i].dataset["maincd"];

      if(Select_MainCategory_CD == 0 || Target_MainCategory_CD == Select_MainCategory_CD || Target_MainCategory_CD ==''){
        TargetTable.rows[i].style='display:table-row';  
        TableDataCount += 1;        
      }else{
        TargetTable.rows[i].style='display:none';       
      }    
          
  }

  document.getElementById("TableDataCount").innerHTML = "データ総数["+ (TableDataCount - 1) +"件]";

  }

  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {

    $('#Insert_SubCategory_Name').val('');

  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);

    $('#Update_MainCategory_CD').val(evCon.data('maincd'));
    $('#Update_MainCategory_Name').val(evCon.data('mainname'));
    $('#Update_SubCategory_CD').val(evCon.data('subcd'));
    $('#Update_SubCategory_Name').val(evCon.data('subname'));

  });

  //利用状況変更モーダル表示時
  $('#ChangeUsageSituationModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);

    var UsageSituation = evCon.data('usage');


    if (UsageSituation == 0) {
      $('#ChangeUsageSituation_Message').html('利用可能にしますか？');
      $('#ChangeUsageSituation_ButtonName').html('利用可能にする');
    } else {
      $('#ChangeUsageSituation_Message').html('利用不可にしますか？');
      $('#ChangeUsageSituation_ButtonName').html('利用不可にする');
    }

    $('#ChangeUsageSituation_MainCategory_Name').html(evCon.data('mainname'));
    $('#ChangeUsageSituation_SubCategory_Name').html(evCon.data('subname'));


    $('#ChangeUsageSituation_MainCategory_CD').val(evCon.data('maincd'));
    $('#ChangeUsageSituation_SubCategory_CD').val(evCon.data('subcd'));
    $('#ChangeUsageSituation_SubCategory_Name').val(evCon.data('subname'));
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    var SelectMainCategory_CD = $("#Insert_MainCategory_CD").val();
    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,
      MainCategory_CD: $("#Insert_MainCategory_CD").val(),
      SubCategory_Name: $("#Insert_SubCategory_Name").val()
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage($("#Insert_SubCategory_Name").val(), SelectProcessingType)) {
      return;
    }

    BeforePosting(DataArray);

  });

  //更新ボタンクリック時
  $('.ModalUpdateButton').on('click', function() {

    var SelectProcessingType = 2;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,
      MainCategory_CD: $("#Update_MainCategory_CD").val(),
      SubCategory_CD: $("#Update_SubCategory_CD").val(),
      SubCategory_Name: $("#Update_SubCategory_Name").val()
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('大分類:' + $("#Update_MainCategory_Name").val() + '|' + '中分類CD:' + $("#Update_SubCategory_CD").val(), SelectProcessingType)) {
      return;
    }

    BeforePosting(DataArray);
  });

  //利用状況変更ボタンクリック時
  $('.ModalChangeUsageSituationButton').on('click', function() {

    var UsageSituation = $("#ChangeUsageSituation_UsageSituation").val();

    if (UsageSituation == 0) {
      var SelectProcessingType = 3;
    } else {
      var SelectProcessingType = 4;
    }


    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,
      MainCategory_CD: $("#ChangeUsageSituation_MainCategory_CD").val(),
      SubCategory_CD: $("#ChangeUsageSituation_SubCategory_CD").val(),
    };

    BeforePosting(DataArray);

  });

  function BeforePosting(DataArray) {
    //common.jsに実装
    originalpost("frm_SubCategory_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';

    if (DataArray.MainCategory_CD == "0") {
      ErrorMsg += '大分類を選択してください。\n';
    }

    if (DataArray.SubCategory_Name == "") {
      ErrorMsg += '中分類名を入力してください。\n';
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