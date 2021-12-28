<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  //クラスファイルの読み込み
  require_once '../dao/dao_Company_M.php';
  //クラスの生成
  $dao_Company_M = new dao_Company_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao_SubCategory_M = new dao_SubCategory_M();
  
  $HeaderInfo = $common->HeaderCreation("求人マスタ");  

  $JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<?php 


//非post時は初期値を設定する。['']or[0]
if (isset($_POST["Company_ID"])) {
  $Company_ID = $_POST["Company_ID"];
} else {
  $Company_ID = 0;
};
if (isset($_POST["Recruitment_CD"])) {
  $Recruitment_CD = $_POST["Recruitment_CD"];
} else {
  $Recruitment_CD = 0;
};
if (isset($_POST["Recruitment_Name"])) {
  $Recruitment_Name = $_POST["Recruitment_Name"];
} else {
  $Recruitment_Name = '';
};
if (isset($_POST["TEL1"])) {
  $TEL1 = $_POST["TEL1"];
} else {
  $TEL1 = '';
};
if (isset($_POST["TEL2"])) {
  $TEL2 = $_POST["TEL2"];
} else {
  $TEL2 = '';
};
if (isset($_POST["WorkPlaceAddress"])) {
  $WorkPlaceAddress = $_POST["WorkPlaceAddress"];
} else {
  $WorkPlaceAddress = '';
};
if (isset($_POST["URL"])) {
  $URL = $_POST["URL"];
} else {
  $URL = '';
};
if (isset($_POST["WorkTime"])) {
  $WorkTime = $_POST["WorkTime"];
} else {
  $WorkTime = '';
};
if (isset($_POST["SalaryInfo"])) {
  $SalaryInfo = $_POST["SalaryInfo"];
} else {
  $SalaryInfo = '';
};
if (isset($_POST["HolidayInfo"])) {
  $HolidayInfo = $_POST["HolidayInfo"];
} else {
  $HolidayInfo = '';
};
if (isset($_POST["Login_ID"])) {
  $Login_ID = $_POST["Login_ID"];
} else {
  $Login_ID = '';
};
if (isset($_POST["Password"])) {
  $Password = $_POST["Password"];
} else {
  $Password = '';
};

//非post時は初期値を設定する。['']or[0] End--

//データ更新処理実行時  Start--
if (isset($_POST["ProcessingType"])) {

    $info = array(
      'Company_ID' => $Company_ID,
      'Recruitment_CD' => $Recruitment_CD,
      'Recruitment_Name' => $Recruitment_Name,      
      'TEL1' => $TEL1,
      'TEL2' => $TEL2,
      'WorkPlaceAddress' => $WorkPlaceAddress,        
      'URL' => $_POST["URL"],
      'WorkTime' => $_POST["WorkTime"],
      'SalaryInfo' => $_POST["SalaryInfo"],
      'HolidayInfo' => $_POST["HolidayInfo"],
      'Login_ID' => $_POST["Login_ID"],
      'Password' => $_POST["Password"]
    );

    $Result = $dao_School_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); 
  }
  //データ更新処理実行時  End--

  //会社のプルダウン作成する為
  $items = $dao_Company_M->Get_Company_M();

  $List = "<option value = 0 >会社一覧</option>";
  foreach ($items as $item_val) {
    $List .= "<option value = " . $item_val['Company_ID']. ">" .$item_val['Company_Name'] . "</option>";    
  }  
  

$Data_Table = $dao_School_M->Get_School_M($Recruitment_CD);

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-schooldivision=''>
  <th>会社名</th>
  <th>求人CD</th>
  <th>求人名</th>  
  <th>HP_WorkPlaceAddress</th>  
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
    <tr data-schooldivision='" . $val['Recruitment_CD'] . "'>
    <td>" . $val['Company_ID'] . "</td>        
    <td>" . $val['DivisionInfo'] ." </td>
    <td>" . $val['Recruitment_Name'] ." </td>
    <td><button><a href='" . $val['WorkPlaceAddress'] . "' target='_blank' rel='noopener noreferrer' style='text-decoration:none';>HPへ</a></button></td>    
    <td>    
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-schoolcd='" . $val['Company_ID'] . "'
      data-schooldivision='" . $val['Recruitment_CD'] . "'
      data-schoolname='" . $val['Recruitment_Name'] . "'
      data-TEL1='" . $val['TEL1'] . "'
      data-WorkPlaceAddress='" . $val['WorkPlaceAddress'] . "'             
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-schoolcd='" . $val['Company_ID'] . "'
      data-schoolname='" . $val['Recruitment_Name'] . "'      
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
    <select name='Recruitment_CD_List' id='Recruitment_CD_List' placeholder='Source Type'><?php echo $List; ?></select>
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
            <label for="Insert_Recruitment_CD_List" class="col-md-3 col-form-label">学校区分</label>
            <select name='Insert_Recruitment_CD_List' id='Insert_Recruitment_CD_List' class="form-control col-md-3" ><?php echo $List; ?></select>
          </div>


          <div class="form-group row">
            <label for="Insert_Recruitment_Name" class="col-md-3 col-form-label">学校名</label>
            <input type="text" name="Insert_Recruitment_Name" id="Insert_Recruitment_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_TEL1" class="col-md-3 col-form-label">TEL1</label>
            <input type="text" name="Insert_TEL1" id="Insert_TEL1" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_WorkPlaceAddress" class="col-md-5 col-form-label">学校HP</label>
            <input type="text" name="Insert_WorkPlaceAddress" id="Insert_WorkPlaceAddress" value="" class="form-control col-md-3">
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
            <label for="Update_Company_ID" class="col-md-3 col-form-label">学校CD</label>
            <input type="text" name="Update_Company_ID" id="Update_Company_ID" value="" class="form-control col-md-3" readonly>
        </div>

        <div class="form-group row">
            <label for="Update_Recruitment_CD_List" class="col-md-3 col-form-label">学校区分</label>
            <select name='Update_Recruitment_CD_List' id='Update_Recruitment_CD_List' class="form-control col-md-3" ><?php echo $List; ?></select>
          </div>


          <div class="form-group row">
            <label for="Update_Recruitment_Name" class="col-md-3 col-form-label">学校名</label>
            <input type="text" name="Update_Recruitment_Name" id="Update_Recruitment_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_TEL1" class="col-md-3 col-form-label">TEL1</label>
            <input type="text" name="Update_TEL1" id="Update_TEL1" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_WorkPlaceAddress" class="col-md-5 col-form-label">学校HP</label>
            <input type="text" name="Update_WorkPlaceAddress" id="Update_WorkPlaceAddress" value="" class="form-control col-md-3">
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

          <p>学校CD = <span id="ChangeUsageSituation_Company_ID"></span> | 学校名 = <span id="ChangeUsageSituation_Recruitment_Name"></span></p>

          <span id="ChangeUsageSituation_Company_ID" hidden></span>
          <span id="ChangeUsageSituation_Recruitment_Name" hidden></span>
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

  const OriginalTable = document.geTEL1ementById('DataInfoTable'); 
  var TableAfterChange;
  
  document.geTEL1ementById("Recruitment_CD_List").onchange = function() {

    var SelectRecruitment_CD = document.geTEL1ementById('Recruitment_CD_List').value;  

    TableAfterChange = NarrowDownDataTable(OriginalTable,'schooldivision',SelectRecruitment_CD);
    document.geTEL1ementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;
    
    document.geTEL1ementById("TableDataCount").innerHTML = "データ総数["+ (SearchDataTableValidCases(TableAfterChange)) +"件]";  

  };  

  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {   
  
    $('#Insert_Recruitment_Name').val('');       
    $('#Insert_TEL1').val('');
    $('#Insert_WorkPlaceAddress').val('');   
    var SelectRecruitment_CD = document.geTEL1ementById('Recruitment_CD_List').value;
    $('#Insert_Recruitment_CD_List').val(SelectRecruitment_CD);
    
  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);
   
    $('#Update_Company_ID').val(evCon.data('schoolcd'));
    $('#Update_Recruitment_CD_List').val(evCon.data('schooldivision'));     
    $('#Update_Recruitment_Name').val(evCon.data('schoolname'));       
    $('#Update_WorkPlaceAddress').val(evCon.data('WorkPlaceAddress'));  
    $('#Update_TEL1').val(evCon.data('TEL1'));
     

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

    $('#ChangeUsageSituation_Company_ID').html(evCon.data('schoolcd'));
    $('#ChangeUsageSituation_Recruitment_Name').html(evCon.data('schoolname'));


    $('#ChangeUsageSituation_Company_ID').val(evCon.data('schoolcd'));
    $('#ChangeUsageSituation_Recruitment_Name').val(evCon.data('schoolname'));    
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,  
      Recruitment_CD: $("#Insert_Recruitment_CD_List").val(),
      Recruitment_Name: $("#Insert_Recruitment_Name").val(),
      TEL1: $("#Insert_TEL1").val(),   
      WorkPlaceAddress: $("#Insert_WorkPlaceAddress").val(),      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage(DataArray.Recruitment_Name, SelectProcessingType)) {
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
      Company_ID: $("#Update_Company_ID").val(),
      Recruitment_CD: $("#Update_Recruitment_CD_List").val(),
      Recruitment_Name: $("#Update_Recruitment_Name").val(),
      TEL1: $("#Update_TEL1").val(),   
      WorkPlaceAddress: $("#Update_WorkPlaceAddress").val(),      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('スクールCD：' + $("#Update_Company_ID").val(), SelectProcessingType)) {
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
      Company_ID: $("#ChangeUsageSituation_Company_ID").val()  
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
  
    if (DataArray.Recruitment_CD == "0") {
      ErrorMsg += '学校区分を選択してください。\n';
    }

    if (DataArray.Recruitment_Name == "") {
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
