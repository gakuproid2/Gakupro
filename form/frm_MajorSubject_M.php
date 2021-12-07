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

//クラスファイルの読み込み
require_once '../dao/dao_SubCategory_M.php';
//クラスの生成
$dao_SubCategory_M = new dao_SubCategory_M();

$HeaderInfo = $common->HeaderCreation(11);

$JS_Info = $common->Read_JSconnection();
?>

<style>
  .StudyPeriod::placeholder {
    text-align: right;
  }
</style>

<?php echo $HeaderInfo;?>



<?php

//非post時は初期値を設定する。['']or[0]
if (isset($_POST["School_Division"])) {
  $School_Division = $_POST["School_Division"];
} else {
  $School_Division = 0;
};

if (isset($_POST["School_CD"])) {
  $School_CD = $_POST["School_CD"];
} else {
  $School_CD = 0;
};
if (isset($_POST["MajorSubject_CD"])) {
  $MajorSubject_CD = $_POST["MajorSubject_CD"];
} else {
  $MajorSubject_CD = 0;
};
if (isset($_POST["MajorSubject_Name"])) {
  $MajorSubject_Name = $_POST["MajorSubject_Name"];
} else {
  $MajorSubject_Name = '';
};
if (isset($_POST["StudyPeriod"])) {
  $StudyPeriod = $_POST["StudyPeriod"];
} else {
  $StudyPeriod = 0;
};
if (isset($_POST["Remarks"])) {
  $Remarks = $_POST["Remarks"];
} else {
  $Remarks = '';
};
if (isset($_POST["UsageSituation"])) {
  $UsageSituation = $_POST["UsageSituation"];
} else {
  $UsageSituation = 0;
};
//非post時は初期値を設定する。['']or[0] End--

//データ更新処理実行時  Start--
if (isset($_POST["ProcessingType"])) {

    $info = array(
      'School_CD' => $School_CD,
      'MajorSubject_CD' => $MajorSubject_CD,
      'MajorSubject_Name' => $MajorSubject_Name,      
      'StudyPeriod' => $StudyPeriod,
      'Remarks' => $Remarks,        
      'ProcessingType' => $_POST["ProcessingType"]
    );

    $Result = $dao_MajorSubject_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); 
  }
  //データ更新処理実行時  End--

  //学校区分のプルダウン作成する為
  $items = $dao_SubCategory_M->GET_SubCategory_m(3);

  $School_Division_PullDown = "<option value = 0 >選択してください</option>";
  foreach ($items as $item_val) {

    $School_Division_PullDown .= "<option value = ". $item_val['SubCategory_CD'];

    if ($School_Division == $item_val['SubCategory_CD']) {
      $School_Division_PullDown .= " selected>";
    } else {
      $School_Division_PullDown .= " >";
    }
    $School_Division_PullDown  .= $item_val['SubCategory_Name'] . "</option>";
  }  

  //学校のプルダウン作成する為
  $items = $dao_School_M->Get_School_M($School_Division);
  
  $SchoolPullDown = "<option value = 0 data-schooldivision=''>選択してください</option>";
  foreach ($items as $item_val) {
    $SchoolPullDown .= "<option value = ". $item_val['School_CD'] . " data-schooldivision=". $item_val['School_Division']. ">". $item_val['School_Name'] . "</option>";        
  }  
  

$Data_Table = $dao_MajorSubject_M->GET_Majorsubject_m($School_CD);

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-schooldivision='' data-schoolcd=''>
  <th>学校名</th>
  <th>専攻CD</th>
  <th>専攻名</th>  
  <th>期間</th>  
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
    <tr data-schooldivision=" . $val['School_Division'] . " data-schoolcd=" . $val['School_CD'] . ">
      <td>" . $val['School_Name'] . "</td>        
      <td>" . $val['MajorSubject_CD'] ."</td>
      <td>" . $val['MajorSubject_Name'] ."</td>    
      <td>" . $val['StudyPeriod'] ."ヶ月</td>    
      <td>    
        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
        data-schoolcd='" . $val['School_CD'] . "'        
        data-schoolname='" . $val['School_Name'] . "' 
        data-majorsubjectcd='" . $val['MajorSubject_CD'] . "'
        data-majorsubjectname='" . $val['MajorSubject_Name'] . "'
        data-studyperiod='" . $val['StudyPeriod'] . "'
        data-remarks='" . $val['Remarks'] . "'             
        data-usage='" . $val['UsageSituation'] . "' >
        <i class='far fa-edit'></i>
        </button> 
    
        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
        data-schoolcd='" . $val['School_CD'] . "'
        data-schoolname='" . $val['School_Name'] . "' 
        data-majorsubjectcd='" . $val['MajorSubject_CD'] . "'   
        data-majorsubjectname='" . $val['MajorSubject_Name'] . "'      
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
    <a>
      学校区分：<select  class="School_Division" name='School_Division' id='School_Division'><?php echo $School_Division_PullDown; ?></select>
      学校選択：<select  class="School_CD" name='School_CD' id='School_CD'><?php echo $SchoolPullDown; ?></select>
    </a>
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
            <label for="Insert_School_CD" class="col-md-3 col-form-label">学校選択</label>
            <select name='Insert_School_CD' id='Insert_School_CD' class="form-control col-md-3" ><?php echo $SchoolPullDown; ?></select>
          </div>

          <div class="form-group row">
            <label for="Insert_MajorSubject_Name" class="col-md-3 col-form-label">専攻名</label>
            <input type="text" name="Insert_MajorSubject_Name" id="Insert_MajorSubject_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_StudyPeriod" class="col-md-4 col-form-label">学習期間（ヶ月）</label>
            <input type="text" name="Insert_StudyPeriod" id="Insert_StudyPeriod" value="" class="form-control col-md-1" placeholder="ヶ月">
          </div>

          <div class="form-group row">
            <label for="Insert_Remarks" class="col-md-5 col-form-label">備考</label>
            <input type="text" name="Insert_Remarks" id="Insert_Remarks" value="" class="form-control col-md-3">
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
     
        <span id="Update_School_CD" hidden></span>

        <div class="form-group row">
            <label for="Update_School_Name" class="col-md-3 col-form-label">学校名</label>
            <input type="text" name="Update_School_Name" id="Update_School_Name" value="" class="form-control col-md-3" readonly>
        </div>

        <div class="form-group row">
            <label for="Update_MajorSubject_CD" class="col-md-3 col-form-label">専攻CD</label>
            <input type="text" name="Update_MajorSubject_CD" id="Update_MajorSubject_CD" value="" class="form-control col-md-3" readonly>
        </div>        

        <div class="form-group row">
          <label for="Update_MajorSubject_Name" class="col-md-3 col-form-label">専攻名</label>
          <input type="text" name="Update_MajorSubject_Name" id="Update_MajorSubject_Name" value="" class="form-control col-md-3">
        </div>

        <div class="form-group row">
          <label for="Update_StudyPeriod" class="col-md-4 col-form-label">学習期間（ヶ月）</label>
          <input type="text" name="Update_StudyPeriod" id="Update_StudyPeriod" value="" class="form-control col-md-3" placeholder="ヶ月">
        </div>

        <div class="form-group row">
          <label for="Update_Remarks" class="col-md-5 col-form-label">備考</label>
          <input type="text" name="Update_Remarks" id="Update_Remarks" value="" class="form-control col-md-3">
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

          <p>学校名 = <span id="ChangeUsageSituation_School_Name"></span> | 専攻名 = <span id="ChangeUsageSituation_MajorSubject_Name"></span></p>

          <span id="ChangeUsageSituation_School_CD" hidden></span>
          <span id="ChangeUsageSituation_MajorSubject_CD" hidden></span>
          <span id="ChangeUsageSituation_MajorSubject_Name" hidden></span>
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

//学校区分が変更になるとイベントが発生
$('.School_Division').change(function() { 
 //選択された学校区分の値を入れる
 var SelectSchool_Division = $(this).val();
 NarrowDownPullDown(SelectSchool_Division);
 NarrowDownDataTableBySchoolDivision(SelectSchool_Division);
});

//学校名が変更になるとイベントが発生
$('.School_CD').change(function() { 
 //選択された学校区分の値を入れる
 var SelectSchool_CD = $(this).val();
 NarrowDownDataTableBySelectSchoolCD(SelectSchool_CD);
});

//プルダウン絞り込み
function NarrowDownPullDown(SelectSchool_Division) {

  
  //select要素をidで取得
  var list = document.getElementById('School_CD').options;

  for(var i=0;i<list.length;i++){

    TargetSchool_Division = (list[i].dataset["schooldivision"]);

    if(SelectSchool_Division == 0 || TargetSchool_Division == SelectSchool_Division || TargetSchool_Division ==''){
      list[i].style='display:option';        
    }else{
      list[i].style='display:none';          
    }   

  }

}

  //学校区分でtable絞り込み
  function NarrowDownDataTableBySchoolDivision(SelectSchool_Division) {
    
    // table要素を取得
    var TargetTable = document.getElementById('DataInfoTable');      

    var TableDataCount = 0;
    for (i = 0, len = TargetTable.rows.length; i < len; i++) {

      var TargetSchool_Division = TargetTable.rows[i].dataset["schooldivision"];

        if(SelectSchool_Division == 0 || TargetSchool_Division == SelectSchool_Division || TargetSchool_Division ==''){
          TargetTable.rows[i].style='display:table-row';  
          TableDataCount += 1;        
        }else{
          TargetTable.rows[i].style='display:none';       
        }    
            
    }

    document.getElementById("TableDataCount").innerHTML = "データ総数["+ (TableDataCount - 1) +"件]";

  }

    //学校でtable絞り込み
    function NarrowDownDataTableBySelectSchoolCD(SelectSchool_CD) {      
     
      let element = document.getElementById('School_Division');
      School_Division = (element.value);

    // table要素を取得
    var TargetTable = document.getElementById('DataInfoTable');      

    var TableDataCount = 0;
    for (i = 0, len = TargetTable.rows.length; i < len; i++) {

      var TargetSchool_CD = TargetTable.rows[i].dataset["schoolcd"];

        if(SelectSchool_CD == 0 || TargetSchool_CD == SelectSchool_CD || TargetSchool_CD ==''){
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
  
    $('#Insert_MajorSubject_Name').val('');       
    $('#Insert_StudyPeriod').val('');
    $('#Insert_Remarks').val('');   
    
  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);
    $('#Update_School_CD').val(evCon.data('schoolcd'));    
    $('#Update_School_Name').val(evCon.data('schoolname'));    
    $('#Update_MajorSubject_CD').val(evCon.data('majorsubjectcd'));     
    $('#Update_MajorSubject_Name').val(evCon.data('majorsubjectname'));       
    $('#Update_StudyPeriod').val(evCon.data('studyperiod'));
    $('#Update_Remarks').val(evCon.data('remarks'));  
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

    
    $('#ChangeUsageSituation_School_Name').html(evCon.data('schoolname'));    
    $('#ChangeUsageSituation_MajorSubject_Name').html(evCon.data('majorsubjectname'));


    $('#ChangeUsageSituation_School_CD').val(evCon.data('schoolcd'));
    $('#ChangeUsageSituation_School_Name').val(evCon.data('schoolname'));
    $('#ChangeUsageSituation_MajorSubject_CD').val(evCon.data('majorsubjectcd'));
    $('#ChangeUsageSituation_MajorSubject_Name').val(evCon.data('majorsubjectname'));    
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,  
      School_CD: $("#Insert_School_CD").val(),
      MajorSubject_Name: $("#Insert_MajorSubject_Name").val(),
      StudyPeriod: $("#Insert_StudyPeriod").val(),   
      Remarks: $("#Insert_Remarks").val(),      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage(DataArray.MajorSubject_Name, SelectProcessingType)) {
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
      School_CD: $("#Update_School_CD").val(),
      MajorSubject_CD: $("#Update_MajorSubject_CD").val(),
      MajorSubject_Name: $("#Update_MajorSubject_Name").val(),
      StudyPeriod: $("#Update_StudyPeriod").val(),   
      Remarks: $("#Update_Remarks").val(),      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('学校名：' + $("#Update_School_Name").val() + '専攻名：' + $("#Update_MajorSubject_Name").val(), SelectProcessingType)) {
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
      School_CD: $("#ChangeUsageSituation_School_CD").val(),
      MajorSubject_CD: $("#ChangeUsageSituation_MajorSubject_CD").val()  

    };

    BeforePosting(DataArray);
  });

  function BeforePosting(DataArray) {
    //common.jsに実装
    originalpost("frm_MajorSubject_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';  
  
    if (DataArray.School_CD == "0") {
      ErrorMsg += '学校を選択してください。\n';
    }

    if (DataArray.MajorSubject_Name == "") {
      ErrorMsg += '専攻名を入力してください。\n';
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
