<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  //クラスファイルの読み込み
  require_once '../dao/dao_School_M.php';
  //クラスの生成
  $dao_School_M = new dao_School_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao_SubCategory_M = new dao_SubCategory_M();
  
  $HeaderInfo = $common->HeaderCreation(10);  

  $JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<?php 


//非post時は初期値を設定する。['']or[0]
if (isset($_POST["School_CD"])) {
  $School_CD = $_POST["School_CD"];
} else {
  $School_CD = 0;
};
if (isset($_POST["School_Division"])) {
  $School_Division = $_POST["School_Division"];
} else {
  $School_Division = 0;
};
if (isset($_POST["School_Name"])) {
  $School_Name = $_POST["School_Name"];
} else {
  $School_Name = '';
};
if (isset($_POST["TEL"])) {
  $TEL = $_POST["TEL"];
} else {
  $TEL = '';
};
if (isset($_POST["URL"])) {
  $URL = $_POST["URL"];
} else {
  $URL = '';
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
      'School_Division' => $School_Division,
      'School_Name' => $School_Name,      
      'TEL' => $TEL,
      'URL' => $URL,        
      'ProcessingType' => $_POST["ProcessingType"]
    );

    $Result = $dao_School_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); 
  }
  //データ更新処理実行時  End--

  //学校区分のプルダウン作成する為
  $items = $dao_SubCategory_M->GET_SubCategory_m(3);

  $List = "<option value = 0 >学校区分選択</option>";
  foreach ($items as $item_val) {
    $List .= "<option value = " . $item_val['SubCategory_CD']. ">" .$item_val['SubCategory_Name'] . "</option>";    
  }  
  

$Data_Table = $dao_School_M->Get_School_M($School_Division);

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-schooldivision=''>
  <th>学校CD</th>
  <th>学校区分</th>
  <th>学校名</th>  
  <th>HP_URL</th>  
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
    <tr data-schooldivision='" . $val['School_Division'] . "'>
    <td>" . $val['School_CD'] . "</td>        
    <td>" . $val['DivisionInfo'] ." </td>
    <td>" . $val['School_Name'] ." </td>
    <td><button><a href='" . $val['URL'] . "' target='_blank' rel='noopener noreferrer' style='text-decoration:none';>HPへ</a></button></td>    
    <td>    
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-schoolcd='" . $val['School_CD'] . "'
      data-schooldivision='" . $val['School_Division'] . "'
      data-schoolname='" . $val['School_Name'] . "'
      data-tel='" . $val['TEL'] . "'
      data-url='" . $val['URL'] . "'             
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-schoolcd='" . $val['School_CD'] . "'
      data-schoolname='" . $val['School_Name'] . "'      
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
    <select name='School_Division_List' id='School_Division_List' placeholder='Source Type'><?php echo $List; ?></select>
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
            <label for="Insert_School_Division_List" class="col-md-3 col-form-label">学校区分</label>
            <select name='Insert_School_Division_List' id='Insert_School_Division_List' class="form-control col-md-3" ><?php echo $List; ?></select>
          </div>


          <div class="form-group row">
            <label for="Insert_School_Name" class="col-md-3 col-form-label">学校名</label>
            <input type="text" name="Insert_School_Name" id="Insert_School_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_TEL" class="col-md-3 col-form-label">TEL</label>
            <input type="text" name="Insert_TEL" id="Insert_TEL" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_URL" class="col-md-5 col-form-label">学校HP</label>
            <input type="text" name="Insert_URL" id="Insert_URL" value="" class="form-control col-md-3">
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
            <label for="Update_School_CD" class="col-md-3 col-form-label">学校CD</label>
            <input type="text" name="Update_School_CD" id="Update_School_CD" value="" class="form-control col-md-3" readonly>
        </div>

        <div class="form-group row">
            <label for="Update_School_Division_List" class="col-md-3 col-form-label">学校区分</label>
            <select name='Update_School_Division_List' id='Update_School_Division_List' class="form-control col-md-3" ><?php echo $List; ?></select>
          </div>


          <div class="form-group row">
            <label for="Update_School_Name" class="col-md-3 col-form-label">学校名</label>
            <input type="text" name="Update_School_Name" id="Update_School_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_TEL" class="col-md-3 col-form-label">TEL</label>
            <input type="text" name="Update_TEL" id="Update_TEL" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_URL" class="col-md-5 col-form-label">学校HP</label>
            <input type="text" name="Update_URL" id="Update_URL" value="" class="form-control col-md-3">
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

          <p>学校CD = <span id="ChangeUsageSituation_School_CD"></span> | 学校名 = <span id="ChangeUsageSituation_School_Name"></span></p>

          <span id="ChangeUsageSituation_School_CD" hidden></span>
          <span id="ChangeUsageSituation_School_Name" hidden></span>
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

  const OriginalTable = document.getElementById('DataInfoTable'); 
  var TableAfterChange;
  
  document.getElementById("School_Division_List").onchange = function() {

    var SelectSchool_Division = document.getElementById('School_Division_List').value;  

    TableAfterChange = NarrowDownDataTable(OriginalTable,'schooldivision',SelectSchool_Division);
    document.getElementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;
    
    document.getElementById("TableDataCount").innerHTML = "データ総数["+ (SearchDataTableValidCases(TableAfterChange)) +"件]";  

  };  

  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {   
  
    $('#Insert_School_Name').val('');       
    $('#Insert_TEL').val('');
    $('#Insert_URL').val('');   
    var SelectSchool_Division = document.getElementById('School_Division_List').value;
    $('#Insert_School_Division_List').val(SelectSchool_Division);
    
  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);
   
    $('#Update_School_CD').val(evCon.data('schoolcd'));
    $('#Update_School_Division_List').val(evCon.data('schooldivision'));     
    $('#Update_School_Name').val(evCon.data('schoolname'));       
    $('#Update_URL').val(evCon.data('url'));  
    $('#Update_TEL').val(evCon.data('tel'));
     

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

    $('#ChangeUsageSituation_School_CD').html(evCon.data('schoolcd'));
    $('#ChangeUsageSituation_School_Name').html(evCon.data('schoolname'));


    $('#ChangeUsageSituation_School_CD').val(evCon.data('schoolcd'));
    $('#ChangeUsageSituation_School_Name').val(evCon.data('schoolname'));    
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,  
      School_Division: $("#Insert_School_Division_List").val(),
      School_Name: $("#Insert_School_Name").val(),
      TEL: $("#Insert_TEL").val(),   
      URL: $("#Insert_URL").val(),      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage(DataArray.School_Name, SelectProcessingType)) {
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
      School_Division: $("#Update_School_Division_List").val(),
      School_Name: $("#Update_School_Name").val(),
      TEL: $("#Update_TEL").val(),   
      URL: $("#Update_URL").val(),      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('スクールCD：' + $("#Update_School_CD").val(), SelectProcessingType)) {
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
      School_CD: $("#ChangeUsageSituation_School_CD").val()  
    };

    BeforePosting(DataArray);
  });

  function BeforePosting(DataArray) {
    //common.jsに実装
    originalpost("frm_School_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';  
  
    if (DataArray.School_Division == "0") {
      ErrorMsg += '学校区分を選択してください。\n';
    }

    if (DataArray.School_Name == "") {
      ErrorMsg += '学校名を入力してください。\n';
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
