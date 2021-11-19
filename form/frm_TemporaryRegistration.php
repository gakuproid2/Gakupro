<!DOCTYPE html>
<html lang="ja">

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
  width: 120px;  
}

</style>

<?php
  
  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();

  $JS_Info = $common->Read_JSconnection();

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
  
?>

<?php  

    if (count($_POST) > 0) {

     

      //登録処理
      if (isset($_POST['Insert'])) {

        $info = array(
          'Member_Name' => $_POST["LastName"].'　'.$_POST["FirstName"],
          'Member_NameYomi' => $_POST["LastNameYomi"].'　'.$_POST["FirstNameYomi"],
          'Birthday' => $_POST["Birthday"],
          'School_CD' => $_POST["School_CD"],
          'MajorSubject_CD' => $_POST["MajorSubject_CD"],
          'TEL' => $_POST["TEL"],
          'MailAddress' => $_POST["MailAddress"],
          'AdmissionYearMonth' => $_POST["AdmissionYearMonth"],
          'GraduationYearMonth' => $_POST["GraduationYearMonth"]
        );

        //登録処理成功時は[Member_ID]が返却される、失敗時はfalse
        $Result = $dao_Member_M->TemporaryRegistration($info);  
                
        if($Result == false) {
      
        } else{
          Header('Location: ' . 'frm_TemporaryRegistrationResult.php?Member_ID='.$Result);
          exit(); 
        }       
      }

      $Key_Code = $_POST["Key_Code"];

      //$Key_Codeで名前とメールアドレスをメールアドレス認証テーブルより取得
      $GetMailAddressAuthenticateInfo = $dao_MailAddressAuthenticate_T ->GetMailAddressAuthenticateInfo($Key_Code);

      foreach ($GetMailAddressAuthenticateInfo as $val) {                
        $MailAddress = $val['MailAddress'];
        $FullName = $val['Name'];        
        $LastName =  mb_strstr($FullName, '　', true);
        $FirstName =  str_replace($LastName.'　', "", $FullName);            
      }     

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
         $MajorSubject_PullDown .= "<option value = " . $val['majorsubject_cd']." >".$val['majorsubject_name'] . "</option>";          
       }
    }


?>

<body>

  <form action="frm_TemporaryRegistration.php" method="POST">
    <p class="Label">氏名</p>
    <p>
      姓:<input type="text" id="LastName" name="LastName" autocomplete="off" value='<?php echo $LastName; ?>'>
      名:<input type="text" id="FirstName" name="FirstName" autocomplete="off" value='<?php echo $FirstName; ?>'>
    </p>

    <p class="Label">氏名(フリガナ)</p>
    <p>      
      姓:<input type="text" id="LastName_Yomi" name="LastNameYomi" autocomplete="off">
      名:<input type="text" id="FirstName_Yomi" name="FirstNameYomi" autocomplete="off">
    </p>         
    
    <p class="Label">生年月日</p>
    <p><input type="date" id="Birthday" name="Birthday" value="2005-04-01"><input type="text" id="Age" class="Age" readonly>歳</p>

    <p class="Label">学校/専攻</p>
    <p>
      <select id='School_CD' name='School_CD'><?php echo $School_PullDown; ?></select>    
      <select id='MajorSubject_CD' name='MajorSubject_CD'><?php echo $MajorSubject_PullDown; ?></select>
    </p>

    <p class="Label">在学期間</p>
    <p>
    <input type="month" class="YearMonth" id="AdmissionYearMonth" name="AdmissionYearMonth" value="2020-04">～
    <input type="month" class="YearMonth" id="GraduationYearMonth" name="GraduationYearMonth" value="2023-03">
    </p>

    <p class="Label">TEL</p>
    <p><input type="tel" id="TEL" name="TEL" autocomplete="off"></p>  

    <p class="Label">メールアドレス</p>
    <p><input type="email" id="MailAddress" name="MailAddress" autocomplete="off" value='<?php echo $MailAddress; ?>'></p>  

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
    
  });

  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#MailAddress").val() == "") {
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
  $('#Birthday').change(function(e){    
    
    var Birthday =  document.getElementById("Birthday").value;  
    
    Birthday = Birthday.replace(/[/-]/g, "");

    var today = new Date();
	  targetdate = today.getFullYear() * 10000 + (today.getMonth() + 1) * 100 + today.getDate();
	  
    document.getElementById("Age").value = (Math.floor((targetdate - Birthday) / 10000));    

  });
 
</script>


</html>