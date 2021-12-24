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
  
  $HeaderInfo = $common->HeaderCreation("会社登録");  

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
if (isset($_POST["Company_Name"])) {
  $Company_Name = $_POST["Company_Name"];
} else {
  $Company_Name = '';
};
if (isset($_POST["TEL1"])) {
  $TEL1 = $_POST["TEL1"];
} else {
  $TEL1 = '';
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
      'Company_ID' => $Company_ID,      
      'Company_Name' => $Company_Name,      
      'TEL1' => $TEL1,
      'TEL2' => $TEL2,
      'Address' => $Address,
      'URL' => $URL,
      'MailAddress' => $MailAddress,
      'Password' => $Password,
      'ProcessingType' => $_POST["ProcessingType"]
    );

    $Result = $dao_Company_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); 
  }
  //データ更新処理実行時  End--
 

$Data_Table = $dao_Company_M->Get_Company_M($Company_Division);

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-Companydivision=''>
  <th>会社ID</th>
  <th>会社名</th>  
  <th>TEL</th>  
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
    <tr data-Companydivision='" . $val['Company_Division'] . "'>
    <td>" . $val['Company_ID'] . "</td>        
    <td>" . $val['Company_Name'] ." </td>    
    <td>" . $val['TEL1'] ." </td> 
    <td><button><a href='" . $val['TEL1'] . "' target='_blank' rel='noopener noreferrer' style='text-decoration:none';>HPへ</a></button></td>    
    <td><button><a href='tel:" . $val['URL'] . "'>". $val['URL'] . "</a></button></td>    
    <td>    
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-companyid='" . $val['Company_ID'] . "'      
      data-companyname='" . $val['Company_Name'] . "'
      data-tel1='" . $val['TEL1'] . "'
      data-tel2='" . $val['TEL2'] . "'
      data-address='" . $val['Address'] . "'
      data-url='" . $val['URL'] . "'
      data-mailaddress='" . $val['MailAddress'] . "'      
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-companyid='" . $val['Company_ID'] . "'
      data-companyname='" . $val['Company_Name'] . "'      
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
            <label for="Insert_Company_Name" class="col-md-3 col-form-label">会社名</label>
            <input type="text" name="Insert_Company_Name" id="Insert_Company_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_TEL1" class="col-md-3 col-form-label">TEL1</label>
            <input type="text" name="Insert_TEL1" id="Insert_TEL1" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_TEL2" class="col-md-3 col-form-label">TEL2</label>
            <input type="text" name="Insert_TEL2" id="Insert_TEL2" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_Address1" class="col-md-5 col-form-label">住所</label>
            <input type="text" name="Insert_Address1" id="Insert_Address1" value="" class="form-control col-md-3">
            <input type="text" name="Insert_Address2" id="Insert_Address2" value="" class="form-control col-md-3">
          </div>  

          <div class="form-group row">
            <label for="Insert_URL" class="col-md-5 col-form-label">会社HP</label>
            <input type="text" name="Insert_URL" id="Insert_URL" value="" class="form-control col-md-3">
          </div>  
          
          <div class="form-group row">
            <label for="Insert_MailAddress" class="col-md-5 col-form-label">メールアドレス</label>
            <input type="text" name="Insert_MailAddress" id="Insert_MailAddress" value="" class="form-control col-md-3">
          </div>  

          <div class="form-group row">
            <label for="Insert_Login_ID" class="col-md-5 col-form-label">ログインID</label>
            <input type="text" name="Insert_Login_ID" id="Insert_Login_ID" value="" class="form-control col-md-3">
          </div>  

          <div class="form-group row">
            <label for="Insert_Password" class="col-md-5 col-form-label">パスワード</label>
            <input type="text" name="Insert_Password" id="Insert_Password" value="" class="form-control col-md-3">
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
            <label for="Update_Company_ID" class="col-md-3 col-form-label">会社ID</label>
            <input type="text" name="Update_Company_ID" id="Update_Company_ID" value="" class="form-control col-md-3" readonly>
          </div>
     
        <div class="form-group row">
            <label for="Update_Company_Name" class="col-md-3 col-form-label">会社名</label>
            <input type="text" name="Update_Company_Name" id="Update_Company_Name" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_TEL1" class="col-md-3 col-form-label">TEL1</label>
            <input type="text" name="Update_TEL1" id="Update_TEL1" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_TEL2" class="col-md-3 col-form-label">TEL2</label>
            <input type="text" name="Update_TEL2" id="Update_TEL2" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_Address1" class="col-md-5 col-form-label">住所</label>
            <input type="text" name="Update_Address1" id="Update_Address1" value="" class="form-control col-md-3">
            <input type="text" name="Update_Address2" id="Update_Address2" value="" class="form-control col-md-3">
          </div>  

          <div class="form-group row">
            <label for="Update_URL" class="col-md-5 col-form-label">会社HP</label>
            <input type="text" name="Update_URL" id="Update_URL" value="" class="form-control col-md-3">
          </div>  
          
          <div class="form-group row">
            <label for="Update_MailAddress" class="col-md-5 col-form-label">メールアドレス</label>
            <input type="text" name="Update_MailAddress" id="Update_MailAddress" value="" class="form-control col-md-3">
          </div>  

          <div class="form-group row">
            <label for="Update_Login_ID" class="col-md-5 col-form-label">ログインID</label>
            <input type="text" name="Update_Login_ID" id="Update_Login_ID" value="" class="form-control col-md-3">
          </div>  

          <div class="form-group row">
            <label for="Update_Password" class="col-md-5 col-form-label">パスワード</label>
            <input type="text" name="Update_Password" id="Update_Password" value="" class="form-control col-md-3">
          </div>        

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary ModalUpdateButton">登録</button>
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

          <p>会社ID = <span id="ChangeUsageSituation_Company_ID"></span> | 会社名 = <span id="ChangeUsageSituation_Company_Name"></span></p>

          <span id="ChangeUsageSituation_Company_ID" hidden></span>
          <span id="ChangeUsageSituation_Company_Name" hidden></span>
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

  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {   
  
    $('#Insert_Company_Name').val('');       
    $('#Insert_TEL1').val('');
    $('#Insert_TEL2').val('');       
    $('#Insert_Address1').val('');       
    $('#Insert_Address2').val('');           
    $('#Insert_URL').val('');           
    $('#Insert_MailAddress').val('');       
    $('#Insert_Login_ID').val('');
    $('#Insert_Password').val('');           
    
  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);
   
    $('#Update_Company_ID').val(evCon.data('companyid'));     
    $('#Update_Company_Name').val(evCon.data('companyname'));       
    $('#Update_TEL1').val(evCon.data('tel1'));
    $('#Update_TEL2').val(evCon.data('tel2'));       
    $('#Update_Address1').val(evCon.data('address1'));       
    $('#Update_Address2').val(evCon.data('address2'));           
    $('#Update_URL').val(evCon.data('url'));           
    $('#Update_MailAddress').val(evCon.data('mailaddress'));       
    $('#Update_Login_ID').val(evCon.data('loginid'));
    $('#Update_Password').val(evCon.data('password'));   
     

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

    $('#ChangeUsageSituation_Company_ID').html(evCon.data('companyid'));
    $('#ChangeUsageSituation_Company_Name').html(evCon.data('companyname'));


    $('#ChangeUsageSituation_Company_ID').val(evCon.data('companyid'));
    $('#ChangeUsageSituation_Company_Name').val(evCon.data('companyname'));    
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,        
      Company_Name: $("#Insert_Company_Name").val(),
      TEL1: $("#Insert_TEL1").val(),
      TEL2: $("#Insert_TEL2").val(),
      Address1: $("#Insert_Address1").val(),
      Address2: $("#Insert_Address2").val(),
      URL: $("#Insert_URL").val(),
      MailAddress: $("#Insert_MailAddress").val(),
      Login_ID: $("#Insert_Login_ID").val(),
      Password: $("#Insert_Password").val()
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage(DataArray.Company_Name, SelectProcessingType)) {
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
      Company_Name: $("#Update_Company_Name").val(),
      TEL1: $("#Update_TEL1").val(),
      TEL2: $("#Update_TEL2").val(),
      Address1: $("#Update_Address1").val(),
      Address2: $("#Update_Address2").val(),
      URL: $("#Update_URL").val(),
      MailAddress: $("#Update_MailAddress").val(),
      Login_ID: $("#Update_Login_ID").val(),
      Password: $("#Update_Password").val() 
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
    originalpost("frm_Company_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';  
  
    if (DataArray.Company_Name == "") {
      ErrorMsg += '会社名を入力してください。\n';
    }

    if (DataArray.TEL1 == "" && DataArray.TEL2 == "") {
      ErrorMsg += '電話番号を入力してください。\n';
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
