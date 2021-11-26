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

if (isset($_POST["MainCategory_CD"])) {$MainCategory_CD = $_POST["MainCategory_CD"];} else {$MainCategory_CD = 0;};
if (isset($_POST["SubCategory_CD"])) {$SubCategory_CD = $_POST["SubCategory_CD"];} else {$SubCategory_CD = 0;};
if (isset($_POST["SubCategory_Name"])) {$SubCategory_Name = $_POST["SubCategory_Name"];} else {$SubCategory_Name = 0;};

//DBアクセス関連の場合
if (isset($_POST["ProcessingType"])) {

  $info = array(
    'MainCategory_CD' => $MainCategory_CD,
    'SubCategory_CD' => $SubCategory_CD,
    'SubCategory_Name' => $SubCategory_Name,
    'ProcessingType' => $_POST["ProcessingType"]   
  );

  //データ変更種類に種別  1=登録、2=更新、3=論理削除
  $Processing = $_POST["DataChange"];
  $Result = false;

  $Result = $dao_SubCategory_M->DataChange($info);   
  
    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); //optional
 
}

//メインカテゴリーのプルダウン作成する為
$items = $dao_MainCategory_M->GET_MainCategory_m();
//0行目
$PullDown = "<option value = 0 >選択してください</option>";
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

//Table作成 Start
$Table = "
<table class='DataInfoTable'>
<tr>
  <th>大分類名</th>
  <th>中分類コード</th>
  <th>中分類名</th>
  <th></th>  
</tr>
";
foreach ($Data_Table as $val) {  

  if($val['UsageSituation']==0){
    $IconType = "<i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>";        
  }else{
    $IconType = "<i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>";    
  }

  $Table .=
  "
  <tr>
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
  <tr>
  "
  ;
  
}

$Table .= "</table>";
//Table作成 End

?>

<body>

<div>
  <a href="" class="btn btn--red btn--radius btn--cubic" data-bs-toggle='modal' data-bs-target='#InsertModal'><i class='fas fa-plus-circle'></i>新規追加</a>
  <a>大分類：<select name='MainCategory_CD' id='MainCategory_CD'><?php echo $PullDown; ?></select></a>
</div>
  <?php echo $Table; ?>

    <!-- 登録用Modal -->
    <div class="modal fade" id="InsertModal" tabindex="-1" aria-labelledby="InsertModalLabel" aria-hidden="true">  
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
  <div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="UpdateModalLabel" aria-hidden="true">  
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="UpdateModalLabel">更新確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <div class="form-group row">
            <label for="Update_MainCategory_CD" class="col-md-3 col-form-label">大分類コード</label>
            <input type="text" name="Update_MainCategory_CD" id="Update_MainCategory_CD" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">
            <label for="Update_MainCategory_Name" class="col-md-3 col-form-label">大分類名</label>
            <input type="text" name="Update_MainCategory_Name" id="Update_MainCategory_Name" value="" class="form-control col-md-3">
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
  <div class="modal fade" id="ChangeUsageSituationModal" tabindex="-1" aria-labelledby="ChangeUsageSituationModalLabel" aria-hidden="true">  
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="ChangeUsageSituationModalLabel">利用状況変更確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <p>大分類CD = <span id="ChangeUsageSituation_MainCategory_CD"></span> | <span id="ChangeUsageSituation_MainCategory_Name"></span></p>             
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

//ポストするキーと値を格納
var DataArray = {
  MainCategory_CD: $("#MainCategory_CD").val(),  
};

//common.jsに実装
originalpost("frm_SubCategory_M.php", DataArray);

};

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

  $('#ChangeUsageSituation_MainCategory_CD').html(evCon.data('maincd'));
  $('#ChangeUsageSituation_MainCategory_Name').html(evCon.data('mainname'));    

  $('#ChangeUsageSituation_MainCategory_CD').val(evCon.data('maincd'));
  $('#ChangeUsageSituation_MainCategory_Name').val(evCon.data('mainname'));    
  $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));    

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

  var SelctProcessingType=1;

  //ポストするキーと値を格納
  var DataArray = {
  ProcessingType: SelctProcessingType,
  MainCategory_Name: $("#Insert_SubCategory_Name").val()
  };

  if (!ValueCheck(DataArray)) {exit;}

  if (!ConfirmationMessage($("#Insert_SubCategory_Name").val(),SelctProcessingType)) {exit;}

  //common.jsに実装
  originalpost("frm_MainCategory_M.php", DataArray);
  });

  //更新ボタンクリック時
  $('.ModalUpdateButton').on('click', function() {

  var SelctProcessingType=2;

  //ポストするキーと値を格納
  var DataArray = {
  ProcessingType: SelctProcessingType,
  MainCategory_CD: $("#Update_MainCategory_CD").val(),
  MainCategory_Name: $("#Update_MainCategory_Name").val()
  };

  if (!ValueCheck(DataArray)) {exit;}

  if (!ConfirmationMessage('大分類コード:' + $("#Update_MainCategory_CD").val(),SelctProcessingType)) {exit;}

  //common.jsに実装
  originalpost("frm_MainCategory_M.php", DataArray);
  });

  //利用状況変更ボタンクリック時
  $('.ModalChangeUsageSituationButton').on('click', function() {

  var UsageSituation = $("#ChangeUsageSituation_UsageSituation").val();

  if(UsageSituation==0){
  var SelctProcessingType=3;
  }else{
  var SelctProcessingType=4;
  }

  if (!ConfirmationMessage($("#ChangeUsageSituation_MainCategory_Name").val(),SelctProcessingType)) {exit;}

  //ポストするキーと値を格納
  var DataArray = {
  ProcessingType: SelctProcessingType,
  MainCategory_CD: $("#ChangeUsageSituation_MainCategory_CD").val()      
  };

  //common.jsに実装
  originalpost("frm_MainCategory_M.php", DataArray);
  });


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

  var ErrorMsg = '';
  if (DataArray.MainCategory_Name == "") {
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