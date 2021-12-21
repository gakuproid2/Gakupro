<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();

  $JS_Info = $common->Read_JSconnection();

  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao_SubCategory_M = new dao_SubCategory_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_MailAddressAuthenticate_T.php';
  //クラスの生成(メールアドレス認証テーブル)
  $dao_MailAddressAuthenticate_T = new dao_MailAddressAuthenticate_T();    

  //クラスファイルの読み込み
  require_once '../dao/dao_School_M.php';
  //クラスの生成(学校マスタ)
  $dao_School_M = new dao_School_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_MajorSubject_M.php';
  //クラスの生成(専攻マスタ)
  $dao_MajorSubject_M = new dao_MajorSubject_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_Member_M.php';
  //クラスの生成
  $dao_Member_M = new dao_Member_M();
   
  $HeaderInfo = $common->HeaderCreation(13); 
  
  $JS_Info = $common->Read_JSConnection();
?>

<?php echo $HeaderInfo; ?>

<?php

//非post時は初期値を設定する。['']or[0]
if (isset($_POST["Member_ID"])) {
  $Member_ID = $_POST["Member_ID"];
} else {
  $Member_ID = 0;
};
if (isset($_POST["Member_Name"])) {
  $Member_Name = $_POST["Member_Name"];
} else {
  $Member_Name = '';
};
if (isset($_POST["Member_NameYomi"])) {
  $Member_NameYomi = $_POST["Member_NameYomi"];
} else {
  $Member_NameYomi = '';
};
if (isset($_POST["Birthday"])) {
  $Birthday = $_POST["Birthday"];
} else {
  $Birthday = '1111-11-11';
};
if (isset($_POST["TEL"])) {
  $TEL = $_POST["TEL"];
} else {
  $TEL = '';
};
if (isset($_POST["MailAddress"])) {
  $MailAddress = $_POST["MailAddress"];
} else {
  $MailAddress = '';
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
if (isset($_POST["AdmissionYearMonth"])) {
  $AdmissionYearMonth = $_POST["AdmissionYearMonth"];
} else {
  $AdmissionYearMonth = '';
};
if (isset($_POST["GraduationYearMonth"])) {
  $GraduationYearMonth = $_POST["GraduationYearMonth"];
} else {
  $GraduationYearMonth = '';
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
if (isset($_POST["EmergencyContactRelations"])) {
  $EmergencyContactRelations = $_POST["EmergencyContactRelations"];
} else {
  $EmergencyContactRelations = '';
};
if (isset($_POST["EmergencyContactTEL"])) {
  $EmergencyContactTEL = $_POST["EmergencyContactTEL"];
} else {
  $EmergencyContactTEL = '';
};
if (isset($_POST["Remarks"])) {
  $Remarks = $_POST["Remarks"];
} else {
  $Remarks = '';
};
if (isset($_POST["RegistrationStatus"])) {
  $RegistrationStatus = $_POST["RegistrationStatus"];
} else {
  $RegistrationStatus = 0;
};
if (isset($_POST["EmergencyContactTEL"])) {
  $EmergencyContactTEL = $_POST["EmergencyContactTEL"];
} else {
  $EmergencyContactTEL = '';
};
//非post時は初期値を設定する。['']or[0] End--

//データ更新処理実行時  Start--
if (isset($_POST["ProcessingType"])) {

    $info = array(
      'Member_ID' => $Member_ID,
      'Member_Name' => $Member_Name,
      'Member_NameYomi' => $Member_NameYomi,      
      'Birthday' => $Birthday,
      'TEL' => $TEL,
      'MailAddress' => $MailAddress,
      'School_CD' => $School_CD,
      'MajorSubject_CD' => $MajorSubject_CD,      
      'AdmissionYearMonth' => $AdmissionYearMonth,
      'GraduationYearMonth' => $GraduationYearMonth, 
      'Login_ID' => $Login_ID,
      'Password' => $Password,
      'EmergencyContactRelations' => $EmergencyContactRelations,      
      'EmergencyContactTEL' => $EmergencyContactTEL,
      'Remarks' => $Remarks, 
      'RegistrationStatus' => $RegistrationStatus,      
      'ProcessingType' => $_POST["ProcessingType"]
    );

    $Result = $dao_Member_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); 
  }
  //データ更新処理実行時  End--

  //学校区分のプルダウン作成する為
  $items = $dao_SubCategory_M->GET_SubCategory_m(3);

  $School_Division_List = "<option data-schooldivision='' value = 0 >学校区分選択</option>";
  foreach ($items as $item_val) {
    $School_Division_List .= "<option data-schooldivision=". $item_val['SubCategory_CD']. " value = ". $item_val['SubCategory_CD'].">".$item_val['SubCategory_Name'] . "</option>";    
  }  

  //学校のプルダウン作成する為
  $items = $dao_School_M->Get_School_M(0);
  
  $School_List = "<option value = 0 data-schoolcd='' data-schooldivision=''>学校選択</option>";
  foreach ($items as $item_val) {
    $School_List .= "<option data-schoolcd=". $item_val['School_CD']. " data-schooldivision=". $item_val['School_Division']. " value = ". $item_val['School_CD'] . ">". $item_val['School_Name'] . "</option>";        
  }  

  //専攻のプルダウン作成する為
  $items = $dao_MajorSubject_M->GET_Majorsubject_m(0);

  $Majorsubject_List = "<option data-schoolcd='' data-majorsubjectcd='' value = 0 >専攻選択</option>";
  foreach ($items as $item_val) {
    $Majorsubject_List .= "<option data-schoolcd=". $item_val['School_CD']. " data-majorsubjectcd=". $item_val['MajorSubject_CD']. " value = ". $item_val['MajorSubject_CD'].">".$item_val['MajorSubject_Name'] . "</option>";    
  }  
  
  //登録状況のプルダウン作成する為
  $Register_Info = $dao_SubCategory_M->GET_SubCategory_m(4);
  //0行目
  $Register_List = "<option value = 0 >登録状況を選択して下さい</option>";
  foreach ($Register_Info as $val) {     
    $Register_List .= "<option value = " . $val['SubCategory_CD']." >".$val['SubCategory_Name'] . "</option>";                
  }

$Data_Table = $dao_Member_M->Get_Member_M();

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-schooldivision='' data-schoolcd='' data-majorSubjectcd=''>
  <th>氏名</th>
  <th>学校名</th>
  <th>専攻名</th>  
  <th>在学期間</th>  
  <th id='TableDataCount'>データ総数[".$Data_Count. "件]</th>
</tr>
";
foreach ($Data_Table as $val) { 

  $Table .=
    "
    <tr data-schooldivision=" . $val['School_Division'] ." data-schoolcd=" . $val['School_CD'] ." data-majorSubjectcd=" . $val['MajorSubject_CD'] .">
      <td><div style='font-size: 75%;'>" . $val['Member_NameYomi'] . "<br></div>" . $val['Member_Name'] ."</td>        
      <td>" . $val['School_Name'] ."</td>
      <td>" . $val['MajorSubject_Name'] ."</td>    
      <td>" . $val['AdmissionYearMonth'] ."<br>" . $val['GraduationYearMonth'] ."</td>
      <td>    
        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
        data-memberid='" . $val['Member_ID'] . "'
        data-membername='" . $val['Member_Name'] . "'    
        data-membernameyomi='" . $val['Member_NameYomi'] . "' 
        data-birthday='" . $val['Birthday'] . "'
        data-tel='" . $val['TEL'] . "'
        data-mailaddress='" . $val['MailAddress'] . "'
        data-schoolcd='" . $val['School_CD'] . "' 
        data-majorSubjectcd='" . $val['MajorSubject_CD'] . "' 
        data-admissionyearmonth='" . $val['AdmissionYearMonth'] . "' 
        data-graduationyearmonth='" . $val['GraduationYearMonth'] . "' 
        data-loginid='" . $val['Login_ID'] . "' 
        data-password='" . $val['Password'] . "' 
        data-emergencycontactrelations='" . $val['EmergencyContactRelations'] . "' 
        data-emergencycontacttel='" . $val['EmergencyContactTEL'] . "' 
        data-remarks='" . $val['Remarks'] . "' 
        data-registrationstatus='" . $val['RegistrationStatus'] . "'>                  
        <i class='far fa-edit'></i>
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
    <a href="" class="btn btn--red btn--radius btn--cubic" data-backdrop="static" data-bs-toggle='modal' data-bs-target='#InsertModal'><i class='fas fa-plus-circle'></i>新規追加</a>
    
      <select  class="School_Division_List" name='School_Division_List' id='School_Division_List'><?php echo $School_Division_List; ?></select>
      <select  class="School_List" name='School_List' id='School_List' style="display:none"><?php echo $School_List; ?></select>
      <select  class="MajorSubject_List" name='MajorSubject_List' id='MajorSubject_List' style="display:none"><?php echo $Majorsubject_List; ?></select>      
    
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
            <label for="Insert_Member_LastName" class="col-md-3 col-form-label" style="width: 100%;">メンバー氏名</label>              
            <input type="text" name="Insert_Member_LastName" id="Insert_Member_LastName" value="" class="form-control col-md-3" style="width: 35%;" placeholder="姓">
          　<input type="text" name="Insert_Member_FirstName" id="Insert_Member_FirstName" value="" class="form-control col-md-3" style="width: 35%;"placeholder="名">
          </div>

          <div class="form-group row">
            <label for="Insert_Member_LastNameYomi" class="col-md-3 col-form-label" style="width: 100%;">メンバー氏名（フリガナ）</label>            
            <input type="text" name="Insert_Member_LastNameYomi" id="Insert_Member_LastNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="セイ">
          　<input type="text" name="Insert_Member_FirstNameYomi" id="Insert_Member_FirstNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="メイ">
          </div>

          <div class="form-group row">
            <label for="Insert_Birthday" class="col-md-4 col-form-label"style="width: 100%;">生年月日</label>            
            <input type="date" name="Insert_Birthday" id="Insert_Birthday"  min="1950-01-01" max="2021-12-31" value="" class="form-control col-md-1" style="width: 50%;">
          　<input type="text" name="Insert_Age" id="Insert_Age" value="" class="form-control col-md-3" style="width: 20%;" readonly><label class="col-md-4 col-form-label"style="width: 10%;">歳</label>
          </div>

          <div class="form-group row">         
            <label for="Insert_TEL" class="col-md-3 col-form-label" style="width: 100%;">TEL</label>              
            <input type="text" name="Insert_TEL" id="Insert_TEL" value="" class="form-control col-md-3" style="width: 50%;">          
          </div>

          <div class="form-group row">         
            <label for="Insert_MailAddress" class="col-md-3 col-form-label" style="width: 100%;">メールアドレス</label>              
            <input type="text" name="Insert_MailAddress" id="Insert_MailAddress" value="" class="form-control col-md-3">          
          </div>


          <div class="form-group row">
            <label for="Insert_School_List" class="col-md-3 col-form-label" style="width: 100%;">学校選択</label>
            <select name='Insert_School_List' id='Insert_School_List' class="form-control col-md-3" ><?php echo $School_List; ?></select>
          </div>

          <div class="form-group row">
            <label for="Insert_MajorSubject_List" class="col-md-3 col-form-label">専攻選択</label>
            <select name='Insert_MajorSubject_List' id='Insert_MajorSubject_List' class="form-control col-md-3" ><?php echo $Majorsubject_List; ?></select>
          </div>

          <div class="form-group row">
            <label for="Insert_AdmissionYearMonth" class="col-md-4 col-form-label" style="width: 50%;">入学年月</label>
            <label for="Insert_GraduationYearMonth" class="col-md-4 col-form-label" style="width: 50%;">卒業予定年月</label>
            <input type="month" name="Insert_AdmissionYearMonth" id="Insert_AdmissionYearMonth" min="2010-01-01"  class="form-control col-md-1" style="width: 50%;">
            <input type="month" name="Insert_GraduationYearMonth" id="Insert_GraduationYearMonth" min="2010-01-01" class="form-control col-md-1" style="width: 50%;">
          </div>

          <div class="form-group row">         
            <label for="Insert_Login_ID" class="col-md-3 col-form-label" style="width: 100%;">ログインID</label>              
            <input type="text" name="Insert_Login_ID" id="Insert_Login_ID" value="" class="form-control col-md-3" style="width: 50%;">          
          </div>

          <div class="form-group row">         
            <label for="Insert_Password" class="col-md-3 col-form-label" style="width: 100%;">パスワード</label>              
            <input type="text" name="Insert_Password" id="Insert_Password" value="" class="form-control col-md-3" style="width: 50%;">          
          </div>

          <div class="form-group row">         
            <label for="Insert_EmergencyContactRelations" class="col-md-3 col-form-label" style="width: 100%;">緊急連絡先情報</label>              
            <input type="text" name="Insert_EmergencyContactRelations" id="Insert_EmergencyContactRelations" value="" class="form-control col-md-3" style="width: 30%;" placeholder="続柄"> 
            <input type="text" name="Insert_EmergencyContactTEL" id="Insert_EmergencyContactTEL" value="" class="form-control col-md-3" style="width: 70%;" placeholder="電話番号">
          </div>

          <div class="form-group row">
            <label for="Insert_RegistrationStatus" class="col-md-3 col-form-label" style="width: 100%;">登録状況</label>
            <select name='Insert_RegistrationStatus' id='Insert_RegistrationStatus' class="form-control col-md-3" ><?php echo $Register_List; ?></select>
          </div>
          
          
          <div class="form-group row">
            <label for="Insert_Remarks" class="col-md-5 col-form-label">備考</label>            
            <textarea class="form-control col-md-3" id="Insert_Remarks" name="Insert_Remarks" autocomplete="off"></textarea>
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
          <h5 class="modal-title" id="UpdateModalLabel">登録確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">         
                 
        <div class="form-group row">
            <label for="Update_Member_ID" class="col-md-3 col-form-label">メンバーID</label>
            <input type="text" name="Update_Member_ID" id="Update_Member_ID" value="" class="form-control col-md-3" readonly>
        </div>

        <div class="form-group row">         
            <label for="Update_Member_LastName" class="col-md-3 col-form-label" style="width: 100%;">メンバー氏名</label>              
            <input type="text" name="Update_Member_LastName" id="Update_Member_LastName" value="" class="form-control col-md-3" style="width: 35%;" placeholder="姓">
          　<input type="text" name="Update_Member_FirstName" id="Update_Member_FirstName" value="" class="form-control col-md-3" style="width: 35%;"placeholder="名">
        </div>

         <div class="form-group row">
            <label for="Update_Member_LastNameYomi" class="col-md-3 col-form-label" style="width: 100%;">メンバー氏名（フリガナ）</label>            
            <input type="text" name="Update_Member_LastNameYomi" id="Update_Member_LastNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="セイ">
          　<input type="text" name="Update_Member_FirstNameYomi" id="Update_Member_FirstNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="メイ">
          </div>

          <div class="form-group row">
            <label for="Update_Birthday" class="col-md-4 col-form-label"style="width: 100%;">生年月日</label>            
            <input type="date" name="Update_Birthday" id="Update_Birthday"  min="1950-01-01" max="2021-12-31" value="" class="form-control col-md-1" style="width: 50%;">
          　<input type="text" name="Update_Age" id="Update_Age" value="" class="form-control col-md-3" style="width: 20%;" readonly><label class="col-md-4 col-form-label"style="width: 10%;">歳</label>
          </div>

          <div class="form-group row">         
            <label for="Update_TEL" class="col-md-3 col-form-label" style="width: 100%;">TEL</label>              
            <input type="text" name="Update_TEL" id="Update_TEL" value="" class="form-control col-md-3" style="width: 50%;">          
          </div>

          <div class="form-group row">         
            <label for="Update_MailAddress" class="col-md-3 col-form-label" style="width: 100%;">メールアドレス</label>              
            <input type="text" name="Update_MailAddress" id="Update_MailAddress" value="" class="form-control col-md-3">          
          </div>

          <div class="form-group row">
            <label for="Update_School_List" class="col-md-3 col-form-label" style="width: 100%;">学校選択</label>
            <select name='Update_School_List' id='Update_School_List' class="form-control col-md-3" ><?php echo $School_List; ?></select>
          </div>

          <div class="form-group row">
            <label for="Update_MajorSubject_List" class="col-md-3 col-form-label">専攻選択</label>
            <select name='Update_MajorSubject_List' id='Update_MajorSubject_List' class="form-control col-md-3" ><?php echo $Majorsubject_List; ?></select>
          </div>

          <div class="form-group row">
            <label for="Update_AdmissionYearMonth" class="col-md-4 col-form-label" style="width: 50%;">入学年月</label>
            <label for="Update_GraduationYearMonth" class="col-md-4 col-form-label" style="width: 50%;">卒業予定年月</label>
            <input type="month" name="Update_AdmissionYearMonth" id="Update_AdmissionYearMonth" min="2010-01-01"  class="form-control col-md-1" style="width: 50%;">
            <input type="month" name="Update_GraduationYearMonth" id="Update_GraduationYearMonth" min="2010-01-01" class="form-control col-md-1" style="width: 50%;">
          </div>

          <div class="form-group row">         
            <label for="Update_Login_ID" class="col-md-3 col-form-label" style="width: 100%;">ログインID</label>              
            <input type="text" name="Update_Login_ID" id="Update_Login_ID" value="" class="form-control col-md-3" style="width: 50%;">          
          </div>

          <div class="form-group row">         
            <label for="Update_Password" class="col-md-3 col-form-label" style="width: 100%;">パスワード</label>              
            <input type="text" name="Update_Password" id="Update_Password" value="" class="form-control col-md-3" style="width: 50%;">          
          </div>

          <div class="form-group row">         
            <label for="Update_EmergencyContactRelations" class="col-md-3 col-form-label" style="width: 100%;">緊急連絡先情報</label>              
            <input type="text" name="Update_EmergencyContactRelations" id="Update_EmergencyContactRelations" value="" class="form-control col-md-3" style="width: 30%;" placeholder="続柄"> 
            <input type="text" name="Update_EmergencyContactTEL" id="Update_EmergencyContactTEL" value="" class="form-control col-md-3" style="width: 70%;" placeholder="電話番号">
          </div>

          <div class="form-group row">
            <label for="Update_RegistrationStatus" class="col-md-3 col-form-label" style="width: 100%;">登録状況</label>
            <select name='Update_RegistrationStatus' id='Update_RegistrationStatus' class="form-control col-md-3" ><?php echo $Register_List; ?></select>
          </div>
          
          
          <div class="form-group row">
            <label for="Update_Remarks" class="col-md-5 col-form-label">備考</label>            
            <textarea class="form-control col-md-3" id="Update_Remarks" name="Update_Remarks" autocomplete="off"></textarea>
          </div>   

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary ModalUpdateButton">登録</button>
          </div>

        </div>

      </div>
    </div>
  </div>

 

  <?php echo $JS_Info ?>
</body>

<script>
const OriginalList_School_Division = document.getElementById('School_Division_List');
const OriginalList_School = document.getElementById('School_List');
const OriginalList_MajorSubject = document.getElementById('MajorSubject_List');

const OriginalTable_Member = document.getElementById('DataInfoTable');

var ListAfterChange;
var TableAfterChange;




//学校区分が変更になるとイベントが発生
$('.School_Division_List').change(function() { 

  var SelectSchool_Division = document.getElementById('School_Division_List').value;

  var OriginalTable = OriginalTable_Member;

  if (SelectSchool_Division == 0){
    
    ListAfterChange = StateChangeList(OriginalList_School,0);
    document.getElementById('School_List').innerHTML = ListAfterChange.innerHTML;

    ListAfterChange = StateChangeList(OriginalList_MajorSubject,0);
    document.getElementById('MajorSubject_List').innerHTML = ListAfterChange.innerHTML;

    }else if(SelectSchool_Division != 0){

    ListAfterChange = StateChangeList(OriginalList_School,1);
    document.getElementById('School_List').innerHTML = ListAfterChange.innerHTML;

    ListAfterChange = StateChangeList(OriginalList_MajorSubject,0);
    document.getElementById('MajorSubject_List').innerHTML = ListAfterChange.innerHTML;
    
    ListAfterChange = NarrowDownList(OriginalList_School,'schooldivision',SelectSchool_Division);  
    document.getElementById('School_List').innerHTML = ListAfterChange.innerHTML;
 
  }

  TableAfterChange = NarrowDownDataTable(OriginalTable,'schooldivision',SelectSchool_Division);

  document.getElementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;
    
  document.getElementById("TableDataCount").innerHTML = "データ総数["+ (SearchDataTableValidCases(TableAfterChange)) +"件]";
  
  
});

//学校が変更になるとイベントが発生
$('.School_List').change(function() { 

  var SelectSchool_Division = document.getElementById('School_Division_List').value;
  var SelectSchool_CD = document.getElementById('School_List').value;

  var OriginalTable = OriginalTable_Member;

  

  if (SelectSchool_CD == 0){

    ListAfterChange = StateChangeList(OriginalList_MajorSubject,0);
    document.getElementById('MajorSubject_List').innerHTML = ListAfterChange.innerHTML; 
  
    ListAfterChange = NarrowDownList(OriginalList_School,'schooldivision',SelectSchool_Division);    
    document.getElementById('School_List').innerHTML = ListAfterChange.innerHTML;
  
    TableAfterChange = NarrowDownDataTable(OriginalTable,'schooldivision',SelectSchool_Division);
    document.getElementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;

  }else if(SelectSchool_CD != 0){

    ListAfterChange = StateChangeList(OriginalList_MajorSubject,1);
    document.getElementById('MajorSubject_List').innerHTML = ListAfterChange.innerHTML; 
  
    ListAfterChange = NarrowDownList(OriginalList_MajorSubject,'schoolcd',SelectSchool_CD);  
    document.getElementById('MajorSubject_List').innerHTML = ListAfterChange.innerHTML;
 
    TableAfterChange = NarrowDownDataTable(OriginalTable,'schoolcd',SelectSchool_CD);
    document.getElementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;
  }
  
  var table = document.getElementById('DataInfoTable');  
  document.getElementById("TableDataCount").innerHTML = "データ総数["+ (SearchDataTableValidCases(table)) +"件]";
 

});

//専攻が変更になるとイベントが発生
$('.MajorSubject_List').change(function() {  

  var SelectSchool_CD = document.getElementById('School_List').value;
  var SelectMajorSubject_CD = document.getElementById('MajorSubject_List').value;  

  var OriginalTable = OriginalTable_Member;

  if (SelectMajorSubject_CD == 0){    
        
    TableAfterChange = NarrowDownDataTable(OriginalTable_Member,'schoolcd',SelectSchool_CD);
    document.getElementById('DataInfoTable').innerHTML = TableAfterChange.innerHTML;

  }else if(SelectMajorSubject_CD != 0){   

    OriginalTable = NarrowDownDataTable(OriginalTable,'schoolcd',SelectSchool_CD);
    OriginalTable = NarrowDownDataTable(OriginalTable,'majorsubjectcd',SelectMajorSubject_CD);
    document.getElementById('DataInfoTable').innerHTML = OriginalTable.innerHTML;
  }  

  var table = document.getElementById('DataInfoTable');
  document.getElementById("TableDataCount").innerHTML = "データ総数["+ (SearchDataTableValidCases(table)) +"件]";

});

//List表示状態変更
function StateChangeList(targetlist,displaystate) {
  
  targetlist.value = 0;

  if(displaystate==0){
    targetlist.style='display:none';   
  }else{
    targetlist.style='display:select'; 
  }
  
  return targetlist;

}

//List絞り込み
function NarrowDownList(targetlist,listtagetname,targetdata) {
  
    for(var i= 0;i<targetlist.length;i++){

    ListTagetValue = (targetlist[i].dataset[listtagetname]);

      if(ListTagetValue == '' || targetdata == ListTagetValue || targetdata == 0){
        targetlist[i].style='display:option';        
      }else{
        targetlist[i].style='display:none';          
      }   
  }

  return targetlist;

}

  //table絞り込み
  function NarrowDownDataTable(targettable,tagetcolumnname,targetdata) {    

    var Difference = 0;

    var test;
    for(i = 0, len = targettable.rows.length; i < len; i++) {

      var ColumnTargetValue = targettable.rows[i].dataset[tagetcolumnname];         

      if(ColumnTargetValue == '' || ColumnTargetValue == targetdata || targetdata == 0){        
        // targettable.rows[i].style='display:table-row';                  
      }else{
        // targettable.rows[i - Difference].style='display:none';   
        targettable.rows[i - Difference].remove();
        Difference -= 1;
      }    

    }

    return targettable;
    
  }

  //Table表示件数検索
  function SearchDataTableValidCases(targettable) {    

    var ValidCases = 0;
    for(i = 0, len = targettable.rows.length; i < len; i++) {  
      
      if(targettable.rows[i].style.display == 'table-row'){      
        ValidCases += 1;            
      }    
    }

    return ValidCases - 1;

  }
     
  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {   
  
    $('#Insert_Member_LastName').val('');
    $('#Insert_Member_FirstName').val('');
    $('#Insert_Member_LastNameYomi').val('');
    $('#Insert_Member_FirstNameYomi').val('');

    $('#Insert_Birthday').val('');
    $('#Insert_TEL').val('');
    $('#Insert_MailAddress').val('');
    $('#Insert_School_List').val(0);
    $('#Insert_MajorSubject_List').val(0);
    $('#Insert_AdmissionYearMonth').val('');
    $('#Insert_GraduationYearMonth').val('');
    $('#Insert_Login_ID').val('');
    $('#Insert_Password').val('');
    $('#Insert_EmergencyContactRelations').val('');
    $('#Insert_EmergencyContactTEL').val('');
    $('#Insert_Remarks').val('');
    
  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);

    $('#Update_Member_ID').val(evCon.data('memberid')); 

    var FullNameSplit = (evCon.data('membername')).split('　');
    $('#Update_Member_LastName').val(FullNameSplit[0]);
    $('#Update_Member_FirstName').val(FullNameSplit[1]);

    var FullNameyomiYomiSplit = (evCon.data('membernameyomi')).split('　');    
    $('#Update_Member_LastNameYomi').val(FullNameyomiYomiSplit[0]);
    $('#Update_Member_FirstNameYomi').val(FullNameyomiYomiSplit[1]);
 
    $('#Update_Birthday').val(evCon.data('birthday')); 
    AgeCalculation(document.getElementById("Update_Birthday").value,2);  
    
    $('#Update_TEL').val(evCon.data('tel')); 
    $('#Update_MailAddress').val(evCon.data('mailaddress')); 
    $('#Update_School_List').val(evCon.data('schoolcd')); 
    $('#Update_MajorSubject_List').val(evCon.data('majorSubjectcd')); 
    $('#Update_AdmissionYearMonth').val(evCon.data('admissionyearmonth')); 
    $('#Update_GraduationYearMonth').val(evCon.data('graduationyearmonth')); 
    $('#Update_Login_ID').val(evCon.data('loginid')); 
    $('#Update_Password').val(evCon.data('password')); 
    $('#Update_EmergencyContactRelations').val(evCon.data('emergencycontactrelations')); 
    $('#Update_EmergencyContactTEL').val(evCon.data('emergencycontacttel')); 
    $('#Update_RegistrationStatus').val(evCon.data('registrationstatus')); 
    $('#Update_Remarks').val(evCon.data('remarks')); 
  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,  
      Member_Name: $("#Insert_Member_LastName").val() + '　' + $("#Insert_Member_FirstName").val(),
      Member_NameYomi: $("#Insert_Member_LastNameYomi").val() + '　' + $("#Insert_Member_FirstNameYomi").val(),
      Birthday: $("#Insert_Birthday").val(),   
      TEL: $("#Insert_TEL").val(),   
      MailAddress: $("#Insert_MailAddress").val(),   
      School_CD: $("#Insert_School_List").val(),   
      MajorSubject_CD: $("#Insert_MajorSubject_List").val(),   
      AdmissionYearMonth: $("#Insert_AdmissionYearMonth").val(),   
      GraduationYearMonth: $("#Insert_GraduationYearMonth").val(),   
      Login_ID: $("#Insert_Login_ID").val(),   
      Password: $("#Insert_Password").val(),   
      EmergencyContactRelations: $("#Insert_EmergencyContactRelations").val(),   
      EmergencyContactTEL: $("#Insert_EmergencyContactTEL").val(),   
      Remarks: $("#Insert_Remarks").val(),   
      RegistrationStatus: $("#Insert_RegistrationStatus").val()      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage(DataArray.Member_Name, SelectProcessingType)) {
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
      Member_Name: $("#Update_Member_LastName").val() + '　' + $("#Update_Member_FirstName").val(),
      Member_NameYomi: $("#Update_Member_LastNameYomi").val() + '　' + $("#Update_Member_FirstNameYomi").val(),
      Birthday: $("#Update_Birthday").val(),   
      TEL: $("#Update_TEL").val(),   
      MailAddress: $("#Update_MailAddress").val(),   
      School_CD: $("#Update_School_List").val(),   
      MajorSubject_CD: $("#Update_MajorSubject_List").val(),   
      AdmissionYearMonth: $("#Update_AdmissionYearMonth").val(),   
      GraduationYearMonth: $("#Update_GraduationYearMonth").val(),   
      Login_ID: $("#Update_Login_ID").val(),   
      Password: $("#Update_Password").val(),   
      EmergencyContactRelations: $("#Update_EmergencyContactRelations").val(),   
      EmergencyContactTEL: $("#Update_EmergencyContactTEL").val(),   
      Remarks: $("#Update_Remarks").val(),   
      RegistrationStatus: $("#Update_RegistrationStatus").val()      
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('学校名：' + $("#Update_School_Name").val() + '専攻名：' + $("#Update_Member_NameYomi").val(), SelectProcessingType)) {
      return;
    }

    BeforePosting(DataArray);
  });

  
  function BeforePosting(DataArray) {
    //common.jsに実装
    Originalpost("frm_Member_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';  
  
    
    if (DataArray.Member_Name == "") {
      ErrorMsg += '氏名を入力してください。\n';
    }

    if (DataArray.Member_NameYomi == "") {
      ErrorMsg += '氏名（フリガナ）を入力してください。\n';
    }

    if (DataArray.School_ID == "0") {
      ErrorMsg += '学校を選択してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg);
      return false;
    } else {
      return true;
    }
  }


  $('#Insert_Birthday').change(function(e){    
    
    var Birthday =  document.getElementById("Insert_Birthday").value;
    AgeCalculation(Birthday,1);    

  });

  $('#Update_Birthday').change(function(e){    
    
    var Birthday =  document.getElementById("Update_Birthday").value;
    AgeCalculation(Birthday,2);    

  });

  //年齢計算処理
  function AgeCalculation(Birthday,Branch) {    
    
    Birthday = Birthday.replace(/[/-]/g, "");

    var today = new Date();
	  targetdate = today.getFullYear() * 10000 + (today.getMonth() + 1) * 100 + today.getDate();
	  
    if(Branch==1){
      document.getElementById("Insert_Age").value = (Math.floor((targetdate - Birthday) / 10000));  
    }else{
      document.getElementById("Update_Age").value = (Math.floor((targetdate - Birthday) / 10000));  
    }    
  }

</script>

</html>
