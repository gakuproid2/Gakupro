<!DOCTYPE html>
<html lang="ja">

<?php
  
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
 
  $Screen_Name = 'QRチケット作成';   
  define("title" ,$Screen_Name);
  require_once($_SERVER['DOCUMENT_ROOT'] . '/Gakupro/form/head.php');
?>


<?php

$Key_Code = 0;
$DataInfo='';

//データ更新処理実行時  Start--
if (isset($_POST["Key_Code"])) {

  $Key_Code = $_POST["Key_Code"];

  //$Key_Codeで名前とメールアドレスをメールアドレス認証テーブルより取得
  $GetMailAddressAuthenticateInfo = $dao_MailAddressAuthenticate_T ->GetMailAddressAuthenticateInfo($Key_Code);

  foreach ($GetMailAddressAuthenticateInfo as $val) {                
    $MailAddress = $val['MailAddress'];
    $FullName = $val['Name'];        
    $LastName =  mb_strstr($FullName, '　', true);
    $FirstName =  str_replace($LastName.'　', "", $FullName);            
  }    

  $DataInfo="data-lastname='". $LastName ."' data-firstname='". $FirstName ."' data-mailaddress='" . $MailAddress. "'";
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
?>

<body>
<a href="" class="btn btn--red btn--radius btn--cubic" data-bs-toggle='modal' data-bs-target='#InsertModal' <?php echo $DataInfo; ?> ><i class='fas fa-plus-circle'></i>登録する</a>
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
            <label for="Insert_Member_LastName" class="col-md-3 col-form-label" style="width: 100%;">氏名</label>              
            <input type="text" name="Insert_Member_LastName" id="Insert_Member_LastName" value="" class="form-control col-md-3" style="width: 35%;" placeholder="姓">
          　<input type="text" name="Insert_Member_FirstName" id="Insert_Member_FirstName" value="" class="form-control col-md-3" style="width: 35%;"placeholder="名">
          </div>

          <div class="form-group row">
            <label for="Insert_Member_LastNameYomi" class="col-md-3 col-form-label" style="width: 100%;">氏名（フリガナ）</label>            
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

          <div id="MajorSubjectRow" class="form-group row d-none">
            <label for="Insert_MajorSubject_List" class="col-md-3 col-form-label">専攻選択</label>
            <select name='Insert_MajorSubject_List' id='Insert_MajorSubject_List' class="form-control col-md-3" ><?php echo $Majorsubject_List; ?></select>
          </div>

          <div class="form-group row">
            <label for="Insert_AdmissionYearMonth" class="col-md-4 col-form-label" style="width: 50%;">入学年月</label>
            <label for="Insert_GraduationYearMonth" class="col-md-4 col-form-label" style="width: 50%;">卒業予定年月</label>
            <input type="month" name="Insert_AdmissionYearMonth" id="Insert_AdmissionYearMonth" min="2010-01-01"  class="form-control col-md-1" style="width: 50%;">
            <input type="month" name="Insert_GraduationYearMonth" id="Insert_GraduationYearMonth" min="2010-01-01" class="form-control col-md-1" style="width: 50%;">
          </div>  

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary ModalInsertButton">登録</button>
          </div>

        </div>

      </div>
    </div>
  </div>

  <?php echo $JS_Info ?>
</body>

<script>

const OriginalList_School_Division = document.getElementById('School_Division_List');
const OriginalList_School = document.getElementById('Insert_School_List');
const OriginalList_MajorSubject = document.getElementById('Insert_MajorSubject_List');

var ListAfterChange;


//学校区分が変更になるとイベントが発生
$('.School_Division_List').change(function() { 

  

});

//学校が変更になるとイベントが発生
$('#Insert_School_List').change(function() { 

  var SelectSchool_CD = document.getElementById('Insert_School_List').value;
  
  if (SelectSchool_CD == 0){
    
    $('#MajorSubjectRow').addClass('d-none');   

  }else if(SelectSchool_CD != 0){

    $('#MajorSubjectRow').removeClass('d-none'); 
        
    ListAfterChange = NarrowDownList(OriginalList_MajorSubject,'schoolcd',SelectSchool_CD);  
    document.getElementById('MajorSubject_List').innerHTML = ListAfterChange.innerHTML;   
    
  }

});




  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {   
  
    // イベント発生元
    let evCon = $(e.relatedTarget);  

    $('#Insert_Member_LastName').val(evCon.data('lastname'));
    $('#Insert_Member_FirstName').val(evCon.data('firstname'));
    $('#Insert_Member_LastNameYomi').val('');
    $('#Insert_Member_FirstNameYomi').val('');

    $('#Insert_Birthday').val('');
    $('#Insert_TEL').val('');
    $('#Insert_MailAddress').val(evCon.data('mailaddress'));    
    $('#Insert_School_List').val('0');
    $('#Insert_MajorSubject_List').val('0');
    $('#Insert_AdmissionYearMonth').val('');
    $('#Insert_GraduationYearMonth').val('');
    
  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 99;

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
  
  function BeforePosting(DataArray) {
    //common.jsに実装
    originalpost("frm_MemberTemporaryRegistrationResult.php", DataArray);
  }


  //登録時の値チェック
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
    AgeCalculation(Birthday);    

  });

  //年齢計算処理
  function AgeCalculation(Birthday) {    
    
    Birthday = Birthday.replace(/[/-]/g, "");

    var today = new Date();
	  targetdate = today.getFullYear() * 10000 + (today.getMonth() + 1) * 100 + today.getDate();
	  
   
    document.getElementById("Insert_Age").value = (Math.floor((targetdate - Birthday) / 10000));  
   
  }

</script>

</html>
