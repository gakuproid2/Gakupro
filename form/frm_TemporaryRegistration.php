<!DOCTYPE html>
<html lang="ja">

<?php
  
  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  //クラスファイルの読み込み
  require_once '../dao/dao_MailAddressAuthenticate_T.php';
  //クラスの生成
  $dao_MailAddressAuthenticate_T = new dao_MailAddressAuthenticate_T();    

  $JS_Info = $common->Read_JSconnection();
?>

<body>

  <?php  

    if (count($_POST) > 0) {

      $Key_Code = $_POST["Key_Code"];

      //$Key_Codeでメールアドレスを
      $GetMailAddressAuthenticateInfo = $dao_MailAddressAuthenticate_T ->GetMailAddressAuthenticateInfo($Key_Code);

      foreach ($GetMailAddressAuthenticateInfo as $val) {                
        $MailAddress = $val['MailAddress'];
        $FullName = $val['Name'];        
        $LastName =  mb_strstr($FullName, '　', true);
        $FirstName =  str_replace($LastName.'　', "", $FullName);    
      }  
    
    }


  ?>

  <form action="frm_TemporaryRegistration.php" method="POST">
    <p>
      氏名　
      姓：<input type="text" id="txt_LastName" name="LastName" autocomplete="off" value='<?php echo $LastName; ?>'>
      名：<input type="text" id="txt_FirstName" name="FirstName" autocomplete="off" value='<?php echo $FirstName; ?>'>
    </p>
    <p>
      氏名(フリガナ)
      姓：<input type="text" id="txt_LastName_Yomi" name="LastNameYomi" autocomplete="off">　
      名：<input type="text" id="txt_Name_Yomi" name="NameYomi" autocomplete="off">
    </p>     
    <p>メールアドレス：<input type="text" id="txt_MailAddress" name="Mailaddress" autocomplete="off" value='<?php echo $MailAddress; ?>'></p>    
    <p>生年月日：<input type="date" id="txt_Birthday" name="Birthday" value="2020-04"></p> 
    <p>入学年月：<input type="month" id="txt_AdmissionYearMonth" name="AdmissionYearMonth" value="2020-04"></p> 
    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="2">クリア</button>    
  </form>


  <?php echo $JS_Info?>
</body>


<script>  

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
  
  //クリアボタンクリック時
  $('#btn_Clear').on('click', function() {
    window.location.href = 'frm_TemporaryRegistration.php'
  });

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#txt_MailAddress").val() == "") {
      ErrorMsg += 'メールアドレスを入力してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg); // 
      return false;
    } else {
      return true;
    }
  }

  //年齢計算処理
  $('#txt_Birthday').change(function(e){
    
    
    var Birthday = $("#txt_Birthday").val();

    const date = new Date().getFullYearmonth();

    window.alert(date); 



  });

</script>


</html>