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
  
  $JS_Info = $common->Read_JSConnection();
?>

<style>

.Label {
  margin: 0%;
  padding: 0%;
}

.Age {
  width: 30px;
  margin-left: 40px;
  margin-right: 10px; 
}

.YearMonth {
  width: 130px;  
}

textarea{
  resize: none;
  height: 100px;
  width: 200px;
  
}

</style>



<?php 
 
  //学校のプルダウン作成する為
  $School_Info = $dao_School_M->Get_School_M('','');
  //0行目
  $School_PullDown = "<option value = 0 >学校を選択して下さい</option>";
  foreach ($School_Info as $val) {
    $School_PullDown .= "<option value = " . $val['School_CD']." >".$val['School_Name'] . "</option>";          
  }

   //専攻コースのプルダウン作成する為
   $MajorSubject_Info = $dao_MajorSubject_M->GET_Majorsubject_m(0);
   //0行目
   $MajorSubject_PullDown = "<option value = 0 >専攻を選択して下さい</option>";
   foreach ($MajorSubject_Info as $val) {
     $MajorSubject_PullDown .= "<option value = ". $val['majorsubject_cd']." >".$val['majorsubject_name'] . "</option>";          
   }

?>
<body>

  <form action="frm_Member_M.php" method="post">
  
  <input type="hidden" id="txt_Member_ID" name="Member_ID" >
  
    <p class="Label">氏名</p>
    <p>
      姓:<input type="text" id="txt_LastName" name="LastName" autocomplete="off">
      名:<input type="text" id="txt_FirstName" name="FirstName" autocomplete="off">
    </p>

    <p class="Label">氏名(フリガナ)</p>
    <p>      
      姓:<input type="text" id="txt_LastName_Yomi" name="LastNameYomi" autocomplete="off">
      名:<input type="text" id="txt_FirstName_Yomi" name="FirstNameYomi" autocomplete="off">
    </p>         
    
    <p class="Label">生年月日</p>
    <p><input type="date" id="txt_Birthday" name="Birthday" value="2005-04-01"><input type="text" id="Age" class="Age" readonly>歳</p> 

    <p class="Label">TEL</p>
    <p><input type="tel" id="txt_TEL" name="TEL" autocomplete="off"></p>  

    <p class="Label">メールアドレス</p>
    <p><input type="email" id="txt_MailAddress" name="MailAddress" autocomplete="off"></p>  
    
    <p class="Label">学校/専攻</p>
    <p>
      <select id='txt_School_CD' name='School_CD'><?php echo $School_PullDown;?></select>    
      <select id='txt_MajorSubject_CD' name='MajorSubject_CD'><?php echo $MajorSubject_PullDown; ?></select>
    </p>

    <p class="Label">在学期間</p>
    <p>
    <input type="month" class="YearMonth" id="txt_AdmissionYearMonth" name="AdmissionYearMonth" value="2020-04">～
    <input type="month" class="YearMonth" id="txt_GraduationYearMonth" name="GraduationYearMonth" value="2023-03">
    </p>

    <p class="Label">緊急連絡先情報</p>
    <p>
    <input type="text" id="txt_EmergencyContactRelations" name="EmergencyContactRelations">
    <input type="text" id="txt_EmergencyContactTEL" name="EmergencyContactTEL" style="margin-left: 20px;">
    </p>

    <p class="Label">備考</p>
    <p>
    <textarea id="txt_Remarks" name="Remarks" autocomplete="off"></textarea>
    </p>
   
    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>    
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <?php echo $JS_Info?>
</body>

<script>

  //画面起動時の処理
  $(window).on('load', function(event) {
    $("#btn_Insert").show();
    $("#btn_Update").hide();
    
    if (document.getElementById('txt_Birthday').value != "" )  {
      AgeCalculation();
    }
  }); 


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
  

  //登録、更新時の値チェック
  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_Screen_Name").val() == "") {
      ErrorMsg += '画面名を入力してください。\n';
    }

    if ($("#txt_Screen_Path").val() == "") {
      ErrorMsg += '画面パスを入力してください。\n';
    }

    if ($("#Authority").val() == "0") {
      ErrorMsg += '権限を選択してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg); 
      return false;
    } else {
      return true;
    }
  }  

  
  $('#txt_Birthday').change(function(e){    
    
    AgeCalculation();    

  });

  //年齢計算処理
  function AgeCalculation() {
    var Birthday =  document.getElementById("txt_Birthday").value;  
    
    Birthday = Birthday.replace(/[/-]/g, "");

    var today = new Date();
	  targetdate = today.getFullYear() * 10000 + (today.getMonth() + 1) * 100 + today.getDate();
	  
    document.getElementById("Age").value = (Math.floor((targetdate - Birthday) / 10000));  
  }
</script>

</html>