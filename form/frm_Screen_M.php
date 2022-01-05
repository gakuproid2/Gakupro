<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();

  //クラスファイルの読み込み
  require_once '../dao/dao_Screen_M.php';
  //クラスの生成
  $dao_Screen_M = new dao_Screen_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao_SubCategory_M = new dao_SubCategory_M();
  
  $Screen_Name = '画面マスタ';
  $HeaderInfo = $common->HeaderCreation($Screen_Name);  
  define("title" ,$Screen_Name);
  require_once($_SERVER['DOCUMENT_ROOT'] . '/Gakupro/form/head.php');
    
  $JS_Info = $common->Read_JSConnection();
?>

<?php echo $HeaderInfo; ?>

<?php 


//非post時は初期値を設定する。['']or[0]
if (isset($_POST["Screen_CD"])) {
  $Screen_CD = $_POST["Screen_CD"];
} else {
  $Screen_CD = 0;
};
if (isset($_POST["Screen_Name"])) {
  $Screen_Name = $_POST["Screen_Name"];
} else {
  $Screen_Name = '';
};
if (isset($_POST["Screen_Path"])) {
  $Screen_Path = $_POST["Screen_Path"];
} else {
  $Screen_Path = '';
};
if (isset($_POST["Authority"])) {
  $Authority = $_POST["Authority"];
} else {
  $Authority = 0;
};
//非post時は初期値を設定する。['']or[0] End--

//データ更新処理実行時  Start--
if (isset($_POST["ProcessingType"])) {

    $info = array(
      'Screen_CD' => $Screen_CD,
      'Screen_Name' => $Screen_Name,
      'Screen_Path' => $Screen_Path,
      'Authority' => $Authority,
      'ProcessingType' => $_POST["ProcessingType"]
    );

    $Result = $dao_Screen_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); //optional
  }

  //権限のプルダウン作成する為
  $items = $dao_SubCategory_M->GET_SubCategory_m(2);

  $List = "<option value = 0 >権限選択</option>";
  foreach ($items as $item_val) {

    $List .= "<option value = " . $item_val['SubCategory_CD'];

    if ($Authority >= $item_val['SubCategory_CD']) {
      $List .= " selected>";
    } else {
      $List .= " >";
    }
    $List  .= $item_val['SubCategory_Name'] . "以上</option>";
  }
  

$Data_Table = $dao_Screen_M->Get_Screen_M($Authority);

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-authority=''>
  <th>画面ID</th>
  <th>画面名</th>
  <th>利用可能権限</th>
  <th id='TableDataCount'>データ総数[".$Data_Count. "件]</th>
</tr>
";
foreach ($Data_Table as $val) {

  if ($val['UsageSituation'] == 0) {
    $IconType = "<i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>";
  } else {
    $IconType = "<i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>";
  }

  $Table .=
    "
  <tr data-authority=" . $val['Authority'] . ">
    <td>" . $val['Screen_CD'] . "</td>    
    <td><a href='" . $val['Screen_Path'] . "' style='text-decoration:none;'>" . $val['Screen_Name'] . "</a></td>
    <td>" . $val['AuthorityInfo'] ." </td>
    <td>

      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-screencd='" . $val['Screen_CD'] . "'
      data-screenname='" . $val['Screen_Name'] . "'        
      data-screenpath='" . $val['Screen_Path'] . "'     
      data-authority='" . $val['Authority'] . "'
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-screencd='" . $val['Screen_CD'] . "'
      data-screenname='" . $val['Screen_Name'] . "'
      data-authority='" . $val['Authority'] . "'
      data-usage='" . $val['UsageSituation'] . "' >
      " . $IconType . "              
      </button>

    </td>
  </tr>
  ";
}

$Table .= "</table>";
//Table作成 End
?>

<body>
<div>
    <a href="" class="btn btn--red btn--radius btn--cubic" data-bs-toggle='modal' data-bs-target='#InsertModal'><i class='fas fa-plus-circle'></i>新規追加</a>
    <select name='Authority_List' id='Authority_List'><?php echo $List; ?></select>
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
            <label for="Insert_Screen_Name" class="col-md-3 col-form-label">画面名</label>
            <input type="text" name="Insert_Screen_Name" id="Insert_Screen_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_Screen_Path" class="col-md-3 col-form-label">URL</label>
            <input type="text" name="Insert_Screen_Path" id="Insert_Screen_Path" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_Authority_List" class="col-md-3 col-form-label">利用可能権限</label>
            <select name='Insert_Authority_List' id='Insert_Authority_List' class="form-control col-md-3"><?php echo $List; ?></select>
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
          
     
          <div class="form-group row">
            <label for="Update_Screen_CD" class="col-md-3 col-form-label">画面ID</label>
            <input type="text" name="Update_Screen_CD" id="Update_Screen_CD" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">
            <label for="Update_Screen_Name" class="col-md-3 col-form-label">画面名</label>
            <input type="text" name="Update_Screen_Name" id="Update_Screen_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_Screen_Path" class="col-md-3 col-form-label">URL</label>
            <input type="text" name="Update_Screen_Path" id="Update_Screen_Path" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_Authority_List" class="col-md-3 col-form-label">利用可能権限</label>
            <select name='Update_Authority_List' id='Update_Authority_List' class="form-control col-md-3"><?php echo $List; ?></select>
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

          <p>画面ID = <span id="ChangeUsageSituation_Screen_CD"></span> | 画面名 = <span id="ChangeUsageSituation_Screen_Name"></span></p>

          <span id="ChangeUsageSituation_Screen_CD" hidden></span>
          <span id="ChangeUsageSituation_Screen_Name" hidden></span>
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

  document.getElementById("Authority_List").onchange = function() {      
  
    var Select_Authority = document.getElementById('Authority_List').value;

    // table要素を取得
    var TargetTable = document.getElementById('DataInfoTable');      

    var TableDataCount = 0;

    //table絞り込み
    for (i = 0, len = TargetTable.rows.length; i < len; i++) {

      var TargetAuthority = TargetTable.rows[i].dataset["authority"];

      if(Select_Authority == 0 || TargetAuthority <= Select_Authority || TargetAuthority ==''){
        TargetTable.rows[i].style='display:table-row';  
        TableDataCount += 1;        
      }else{
        TargetTable.rows[i].style='display:none';       
      }              
    }

    document.getElementById("TableDataCount").innerHTML = "データ総数["+ (TableDataCount - 1) +"件]";

  };

  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {

    $('#Insert_Screen_Name').val('');
    var SelectAuthority = document.getElementById('Authority_List').value;
    $('#Insert_Authority_List').val(SelectAuthority);

  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);

    $('#Update_Screen_CD').val(evCon.data('screencd'));
    $('#Update_Screen_Name').val(evCon.data('screenname'));    
    $('#Update_Authority_List').val(evCon.data('authority'));
    $('#Update_Screen_Path').val(evCon.data('screenpath'));

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

    $('#ChangeUsageSituation_Screen_CD').html(evCon.data('screencd'));
    $('#ChangeUsageSituation_Screen_Name').html(evCon.data('screenname'));


    $('#ChangeUsageSituation_Screen_CD').val(evCon.data('screencd'));
    $('#ChangeUsageSituation_Screen_Name').val(evCon.data('screenname'));    
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    var SelectScreen_CD = $("#Insert_Screen_Path").val();
    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,
      Screen_Name: $("#Insert_Screen_Name").val(),
      Screen_Path: $("#Insert_Screen_Path").val(),
      Authority: $("#Insert_Authority_List").val()
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage($("#Insert_Screen_Name").val(), SelectProcessingType)) {
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
      Screen_CD: $("#Update_Screen_CD").val(),     
      Screen_Name: $("#Update_Screen_Name").val(),
      Screen_Path: $("#Update_Screen_Path").val(),
      Authority: $("#Update_Authority_List").val(),
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('画面ID：' + $("#Update_Screen_CD").val(), SelectProcessingType)) {
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
      Screen_CD: $("#ChangeUsageSituation_Screen_CD").val()  
    };

    BeforePosting(DataArray);

  });

  function BeforePosting(DataArray) {
    //common.jsに実装
    originalpost("frm_Screen_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';

    if (DataArray.Screen_Name == "") {
      ErrorMsg += '画面名を入力してください。\n';
    }

    if (DataArray.Screen_Path == "") {
      ErrorMsg += 'URLを入力してください。\n';
    }

    if (DataArray.Authority == "0") {
      ErrorMsg += '利用可能権限を選択してください。\n';
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