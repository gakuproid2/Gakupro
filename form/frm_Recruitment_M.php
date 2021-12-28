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
<tr data-companyid='' data-recruitmentcd=''>
  <th>会社名</th>
  <th>求人CD</th>
  <th>求人名</th>    
  <th>募集期間</th>  
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
    <tr data-companyid='" . $val['Company_ID'] . "' data-recruitmentcd='" . $val['Recruitment_CD'] . "'>
    <td>" . $val['Company_Name'] . "</td>        
    <td>" . $val['Recruitment_CD'] ." </td>
    <td>" . $val['Recruitment_Name'] ." </td>
    <td>募集期間</td>
    <td>    
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-companyid='" . $val['Company_ID'] . "'
      data-recruitmentcd='" . $val['Recruitment_CD'] . "'
      data-schoolname='" . $val['Recruitment_Name'] . "'
      data-TEL1='" . $val['TEL1'] . "'
      data-WorkPlaceAddress='" . $val['WorkPlaceAddress'] . "'             
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-companyid='" . $val['Company_ID'] . "'
      data-recruitmentcd='" . $val['Recruitment_CD'] . "'      
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
    <select name='Company_List' id='Company_List' placeholder='Source Type'><?php echo $List; ?></select>
  </div>
  <?php echo $Table; ?>


  <!-- 確認用Modal -->
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



  <?php echo $JS_Info ?>
</body>

<script>

  const OriginalTable = document.geTEL1ementById('DataInfoTable'); 
  var TableAfterChange;
  
  document.geTEL1ementById("Company_List").onchange = function() {

    var SelectCompany_ID = document.getLementById('Company_List').value;  

    TableAfterChange = NarrowDownDataTable(OriginalTable,'companyid',SelectCompany_ID);
    document.geTEL1ementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;
    
    document.geTEL1ementById("TableDataCount").innerHTML = "データ総数["+ (SearchDataTableValidCases(TableAfterChange)) +"件]";  

  };  

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);
   
    $('#Update_Company_ID').val(evCon.data('companyid'));
    $('#Update_Recruitment_CD_List').val(evCon.data('recruitmentcd'));     
    $('#Update_Recruitment_Name').val(evCon.data('schoolname'));       
    $('#Update_WorkPlaceAddress').val(evCon.data('WorkPlaceAddress'));  
    $('#Update_TEL1').val(evCon.data('TEL1'));
     

  });

</script>

</html>
