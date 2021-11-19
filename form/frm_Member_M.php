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

<?php echo $HeaderInfo; ?>

<?php 
 
  //ポストされた確認する。
  if (count($_POST) > 1) {     

    $info = array(
      'Member_ID' => $_POST["Member_ID"],
      'Member_Name' => $_POST["LastName"].'　'.$_POST["FirstName"],
      'Member_NameYomi' => $_POST["LastNameYomi"].'　'.$_POST["FirstNameYomi"],
      'Birthday' => $_POST["Birthday"],
      'School_CD' => $_POST["School_CD"],
      'MajorSubject_CD' => $_POST["MajorSubject_CD"],
      'TEL' => $_POST["TEL"],
      'MailAddress' => $_POST["MailAddress"],
      'AdmissionYearMonth' => $_POST["AdmissionYearMonth"],
      'GraduationYearMonth' => $_POST["GraduationYearMonth"],
      'EmergencyContactRelations' => $_POST["EmergencyContactRelations"],
      'EmergencyContactTEL' => $_POST["EmergencyContactTEL"],     
      'Login_ID' => $_POST["Login_ID"],
      'Password' => $_POST["Password"],
      'Remarks' => $_POST["Remarks"],
      'RegistrationStatus' => $_POST["RegistrationStatus"],      
      'Operator' => $_SESSION["Staff_ID"]        
    );

    $Result = "";

    //登録、削除、更新の分岐
    if (isset($_POST['Insert'])) {
      $Result = $dao_Member_M->DataChange($info, 1);
    } else if (isset($_POST['Update'])) {
      $Result = $dao_Member_M->DataChange($info, 2);   
    }

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); //optional
  }

  $Data_Table = $dao_Member_M->Get_Member_M();

  $Table = "";
  foreach ($Data_Table as $val) {
  
    $EmergencyContactRelations='';
    if (isset($val['EmergencyContactRelations'])) {
      $EmergencyContactRelations ='('.$val['EmergencyContactRelations'].')';
    };


    $Table .=
    "<tr class='Table'>
      <td>" . $val['Member_ID'] . "</td>
      <td>" . $val['Member_Name'] . " </td>      
      <td>" . $val['Member_NameYomi'] . " </td>
      <td>" . $val['Birthday'] . " </td>       
      <td>" . $val['TEL'] . " </td>
      <td>" . $val['MailAddress'] . " </td>      
      <td style=display:none>" . $val['School_CD'] . "</td>      
      <td>" . $val['School_Name'] . " </td>  
      <td style=display:none>" . $val['MajorSubject_CD'] . "</td>      
      <td>" . $val['MajorSubject_Name'] . "</td>  
      <td>" . $val['AdmissionYearMonth'] . "</td>     
      <td>" . $val['GraduationYearMonth'] . "</td>    
      <td style=display:none>" . $val['Login_ID'] . "</td>     
      <td style=display:none>" . $val['Password'] . "</td>   
      <td>".$EmergencyContactRelations. $val['EmergencyContactTEL']."</td>           
      <td style=display:none>" . $val['EmergencyContactRelations'] . "</td>     
      <td style=display:none>" . $val['EmergencyContactTEL'] . "</td>         
      <td style=display:none>" . $val['Remarks'] . "</td> 
      <td style=display:none>" . $val['RegistrationStatus'] . "</td>     
      <td>" . $val['RegistrationStatusName'] . " </td>   
      <td style=display:none>" . $val['RegisteredPerson'] . "</td>  
      <td style=display:none>" . $val['RegisteredDate'] . "</td>           
      <td>" . $val['ChangerName'] . "</td>
      <td>" . $val['UpdateDate'] . "</td>
    "
    ; 

    

    $Table .= "</tr>";
  }

   //登録状況のプルダウン作成する為
   $Register_Info = $dao_SubCategory_M->GET_SubCategory_m(4);
   //0行目
   $Register_PullDown = "<option value = 0 >登録状況を選択して下さい</option>";
   foreach ($Register_Info as $val) {     
     $Register_PullDown .= "<option value = " . $val['SubCategory_CD']." >".$val['SubCategory_Name'] . "</option>";                
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
     $MajorSubject_PullDown .= "<option value = ". $val['majorsubject_cd']." >".$val['majorsubject_name'] . "</option>";          
   }

?>
<body>

  <form action="frm_Member_M.php" method="post">
  
  <input type="hidden" id="Member_ID" name="Member_ID" >
  
    <p class="Label">氏名</p>
    <p>
      姓:<input type="text" id="LastName" name="LastName" autocomplete="off">
      名:<input type="text" id="FirstName" name="FirstName" autocomplete="off">
    </p>

    <p class="Label">氏名(フリガナ)</p>
    <p>      
      姓:<input type="text" id="LastName_Yomi" name="LastNameYomi" autocomplete="off">
      名:<input type="text" id="FirstName_Yomi" name="FirstNameYomi" autocomplete="off">
    </p>         
    
    <p class="Label">生年月日</p>
    <p><input type="date" id="Birthday" name="Birthday" value="2005-04-01"><input type="text" id="Age" class="Age" readonly>歳</p> 

    <p class="Label">TEL</p>
    <p><input type="tel" id="TEL" name="TEL" autocomplete="off"></p>  

    <p class="Label">メールアドレス</p>
    <p><input type="email" id="MailAddress" name="MailAddress" autocomplete="off"></p>  
    
    <p class="Label">学校/専攻</p>
    <p>
      <select id='School_CD' name='School_CD'><?php echo $School_PullDown;?></select>    
      <select id='MajorSubject_CD' name='MajorSubject_CD'><?php echo $MajorSubject_PullDown; ?></select>
    </p>

    <p class="Label">在学期間</p>
    <p>
    <input type="month" class="YearMonth" id="AdmissionYearMonth" name="AdmissionYearMonth" value="2020-04">～
    <input type="month" class="YearMonth" id="GraduationYearMonth" name="GraduationYearMonth" value="2023-03">
    </p>

    <p class="Label">緊急連絡先情報</p>
    <p>
    <input type="text" id="EmergencyContactRelations" name="EmergencyContactRelations">
    <input type="text" id="EmergencyContactTEL" name="EmergencyContactTEL" style="margin-left: 20px;">
    </p>

    <p class="Label">備考</p>
    <p>
    <textarea id="Remarks" name="Remarks" autocomplete="off"></textarea>
    </p>

    <p class="Label">登録状況</p>
    <p>
      <select id='RegistrationStatus' name='RegistrationStatus'><?php echo $Register_PullDown; ?></select>          
    </p>

 


    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>    
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
    <th>メンバーID</th>
    <th>氏名</th>
    <th>フリガナ</th>
    <th>生年月日</th>
    <th>TEL</th>
    <th>メールアドレス</th>
    <th>学校</th>
    <th>専攻</th>
    <th>入学年月</th>
    <th>卒業年月</th>
    <th>緊急連絡先情報</th>
    <th>登録状況</th>    
    <th>最終更新者</th>
    <th>最終更新日</th>    
    </tr>
    <?php echo $Table; ?>
  </table>


  <?php echo $JS_Info?>
</body>

<script>

  //画面起動時の処理
  $(window).on('load', function(event) {
    $("#btn_Insert").show();
    $("#btn_Update").hide();
    
    if (document.getElementById('Birthday').value != "" )  {
      AgeCalculation();
    }
  });

  //テーブルクリック時
  $('.Table').on('click', function() {

    //MemberID
    var Member_ID = $(this).children('td')[0].innerText;
    $("#Member_ID").val(Member_ID);

    //名前    取得した名前を姓と名で分けてテキストに格納する
    var Name = $(this).children('td')[1].innerText;
    var NameSplit = Name.split('　');
    $("#LastName").val(NameSplit[0]);
    $("#FirstName").val(NameSplit[1]);

    //ﾌﾘｶﾞﾅ
    var Name_Yomi = $(this).children('td')[2].innerText;
    var Name_YomiSplit = Name_Yomi.split('　');
    $("#LastName_Yomi").val(Name_YomiSplit[0]);
    $("#FirstName_Yomi").val(Name_YomiSplit[1]);

    //誕生日
    var Birthday = $(this).children('td')[3].innerText;
    $("#Birthday").val(Birthday);

    //TEL
    var TEL = $(this).children('td')[4].innerText;
    $("#TEL").val(TEL);

    //MailAddress
    var MailAddress = $(this).children('td')[5].innerText;
    $("#MailAddress").val(MailAddress);

    //学校
    var School_CD = $(this).children('td')[6].innerText;
    $("#School_CD").val(School_CD);

    //専攻
    var MajorSubject_CD = $(this).children('td')[8].innerText;
    $("#MajorSubject_CD").val(MajorSubject_CD);

    //入学年月
    var AdmissionYearMonth = $(this).children('td')[10].innerText;
    $("#AdmissionYearMonth").val(AdmissionYearMonth);

    //卒業年月
    var GraduationYearMonth = $(this).children('td')[11].innerText;
    $("#GraduationYearMonth").val(GraduationYearMonth);

    //緊急連絡先相手続柄
    var EmergencyContactRelations = $(this).children('td')[15].innerText;
    $("#EmergencyContactRelations").val(EmergencyContactRelations);

    //緊急連絡先番号
    var EmergencyContactTEL = $(this).children('td')[16].innerText;
    $("#EmergencyContactTEL").val(EmergencyContactTEL);

    //備考
    var Remarks = $(this).children('td')[17].innerText;
    $("#Remarks").val(Remarks);

    //登録状況
    var RegistrationStatus = $(this).children('td')[18].innerText;
    $("#RegistrationStatus").val(RegistrationStatus);
    

    $("#btn_Insert").hide();
    document.getElementById("btn_Insert").disabled = true;
    $("#btn_Update").show();

    if (document.getElementById('Birthday').value != "" )  {
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
    if ($("#Screen_Name").val() == "") {
      ErrorMsg += '画面名を入力してください。\n';
    }

    if ($("#Screen_Path").val() == "") {
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

  
  $('#Birthday').change(function(e){    
    
    AgeCalculation();    

  });

  //年齢計算処理
  function AgeCalculation() {
    var Birthday =  document.getElementById("Birthday").value;  
    
    Birthday = Birthday.replace(/[/-]/g, "");

    var today = new Date();
	  targetdate = today.getFullYear() * 10000 + (today.getMonth() + 1) * 100 + today.getDate();
	  
    document.getElementById("Age").value = (Math.floor((targetdate - Birthday) / 10000));  
  }
</script>

</html>