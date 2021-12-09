<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();

  //クラスファイルの読み込み
  require_once '../dao/dao_Staff_M.php';
  //クラスの生成
  $dao_Staff_M = new dao_Staff_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao_SubCategory_M = new dao_SubCategory_M();
  
  $HeaderInfo = $common->HeaderCreation(12);  

  $JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<?php 


//非post時は初期値を設定する。['']or[0]
if (isset($_POST["Staff_ID"])) {
  $Staff_ID = $_POST["Staff_ID"];
} else {
  $Staff_ID = 0;
};
if (isset($_POST["Staff_Name"])) {
  $Staff_Name = $_POST["Staff_Name"];
} else {
  $Staff_Name = '';
};
if (isset($_POST["Staff_NameYomi"])) {
  $Staff_NameYomi = $_POST["Staff_NameYomi"];
} else {
  $Staff_NameYomi = '';
};
if (isset($_POST["NickName"])) {
  $NickName = $_POST["NickName"];
} else {
  $NickName = '';
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
if (isset($_POST["Authority"])) {
  $Authority = $_POST["Authority"];
} else {
  $Authority = 0;
};
//非post時は初期値を設定する。['']or[0] End--

//データ更新処理実行時  Start--
if (isset($_POST["ProcessingType"])) {

    $info = array(
      'Staff_ID' => $Staff_ID,
      'Staff_Name' => $Staff_Name,
      'Staff_NameYomi' => $Staff_NameYomi,      
      'NickName' => $NickName,
      'Login_ID' => $Login_ID,
      'Password' => $Password,
      'TEL' => $TEL,
      'MailAddress' => $MailAddress,      
      'Authority' => $Authority,
      'ProcessingType' => $_POST["ProcessingType"]
    );

    $Result = $dao_Staff_M->DataChange($info);

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); 
  }
  //データ更新処理実行時  End--

  //権限のプルダウン作成する為
  $items = $dao_SubCategory_M->GET_SubCategory_m(2);

  $PullDown = "<option value = 0 >権限選択</option>";
  foreach ($items as $item_val) {

    $PullDown .= "<option value = " . $item_val['SubCategory_CD'];

    if ($Authority == $item_val['SubCategory_CD']) {
      $PullDown .= " selected>";
    } else {
      $PullDown .= " >";
    }
    $PullDown  .= $item_val['SubCategory_Name'] . "</option>";
  }
  
  

$Data_Table = $dao_Staff_M->Get_Staff_M($Authority);

$Data_Count = count($Data_Table);

//Table作成 Start
$Table = "
<table class='DataInfoTable' id='DataInfoTable'>
<tr data-authority=''>
  <th>スタッフID</th>
  <th>氏名</th>
  <th>権限</th>
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
  <tr data-authority='" . $val['Authority'] . "'>
    <td>" . $val['Staff_ID'] . "</td>
    <td>" . $val['Staff_Name'] . " </td>
    <td>" . $val['AuthorityInfo'] ." </td>
    <td>

      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#UpdateModal' 
      data-staffid='" . $val['Staff_ID'] . "'
      data-staffname='" . $val['Staff_Name'] . "'
      data-staffnameyomi='" . $val['Staff_NameYomi'] . "'
      data-nickname='" . $val['NickName'] . "'
      data-Loginid='" . $val['Login_ID'] . "'
      data-password='" . $val['Password'] . "'
      data-tel='" . $val['TEL'] . "'
      data-mailaddress='" . $val['MailAddress'] . "'
      data-authority='" . $val['Authority'] . "'
      data-usage='" . $val['UsageSituation'] . "' >
      <i class='far fa-edit'></i>
      </button> 
   
      <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#ChangeUsageSituationModal'
      data-staffid='" . $val['Staff_ID'] . "'
      data-staffname='" . $val['Staff_Name'] . "'
      data-authority='" . $val['Authority'] . "'
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
    <select name='Authority' id='Authority' placeholder='Source Type'><?php echo $PullDown; ?></select>
  </div>
  <?php echo $Table; ?>

  <!-- 登録用Modal -->
  <div class="modal fade" id="InsertModal" tabindex="-1" aria-labelledby="InsertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="InsertModalLabel">登録確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">         
        
          <div class="form-group row">         
            <label for="Insert_Staff_LastName" class="col-md-3 col-form-label" style="width: 100%;">スタッフ氏名</label>              
            <input type="text" name="Insert_Staff_LastName" id="Insert_Staff_LastName" value="" class="form-control col-md-3" style="width: 35%;" placeholder="姓">
          　<input type="text" name="Insert_Staff_FirstName" id="Insert_Staff_FirstName" value="" class="form-control col-md-3" style="width: 35%;"placeholder="名">
          </div>

          <div class="form-group row">
            <label for="Insert_Staff_LastNameYomi" class="col-md-3 col-form-label" style="width: 100%;">スタッフ氏名（フリガナ）</label>            
            <input type="text" name="Insert_Staff_LastNameYomi" id="Insert_Staff_LastNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="セイ">
          　<input type="text" name="Insert_Staff_FirstNameYomi" id="Insert_Staff_FirstNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="メイ">
          </div>

          <div class="form-group row">
            <label for="Insert_NickName" class="col-md-4 col-form-label" style="width: 100%;">ニックネーム</label>
            <input type="text" name="Insert_NickName" id="Insert_NickName" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_Login_ID" class="col-md-3 col-form-label">ログインID</label>
            <input type="text" name="Insert_Login_ID" id="Insert_Login_ID" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_Password" class="col-md-3 col-form-label">パスワード</label>
            <input type="text" name="Insert_Password" id="Insert_Password" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_TEL" class="col-md-3 col-form-label">TEL</label>
            <input type="text" name="Insert_TEL" id="Insert_TEL" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_MailAddress" class="col-md-5 col-form-label">メールアドレス</label>
            <input type="text" name="Insert_MailAddress" id="Insert_MailAddress" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Insert_Authority" class="col-md-3 col-form-label">権限</label>
            <select name='Insert_Authority' id='Insert_Authority' class="form-control col-md-3" ><?php echo $PullDown; ?></select>
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
  <div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="UpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="UpdateModalLabel">更新確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">          
     
          <div class="form-group row">
            <label for="Update_Staff_ID" class="col-md-3 col-form-label">スタッフID</label>
            <input type="text" name="Update_Staff_ID" id="Update_Staff_ID" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">         
            <label for="Update_Staff_LastName" class="col-md-3 col-form-label" style="width: 100%;">スタッフ氏名</label>              
            <input type="text" name="Update_Staff_LastName" id="Update_Staff_LastName" value="" class="form-control col-md-3" style="width: 35%;" placeholder="姓">
          　<input type="text" name="Update_Staff_FirstName" id="Update_Staff_FirstName" value="" class="form-control col-md-3" style="width: 35%;"placeholder="名">
          </div>


          <div class="form-group row">
            <label for="Update_Staff_LastNameYomi" class="col-md-3 col-form-label" style="width: 100%;">スタッフ氏名（フリガナ）</label>            
            <input type="text" name="Update_Staff_LastNameYomi" id="Update_Staff_LastNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="セイ">
          　<input type="text" name="Update_Staff_FirstNameYomi" id="Update_Staff_FirstNameYomi" value="" class="form-control col-md-3" style="width: 35%;" placeholder="メイ">
          </div>

          <div class="form-group row">
          <label for="Update_NickName" class="col-md-4 col-form-label" style="width: 100%;">ニックネーム</label>
            <input type="text" name="Update_NickName" id="Update_NickName" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_Login_ID" class="col-md-3 col-form-label">ログインID</label>
            <input type="text" name="Update_Login_ID" id="Update_Login_ID" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_Password" class="col-md-3 col-form-label">パスワード</label>
            <input type="text" name="Update_Password" id="Update_Password" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_TEL" class="col-md-3 col-form-label">TEL</label>
            <input type="text" name="Update_TEL" id="Update_TEL" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_MailAddress" class="col-md-5 col-form-label">メールアドレス</label>
            <input type="text" name="Update_MailAddress" id="Update_MailAddress" value="" class="form-control col-md-3">
          </div>

          <div class="form-group row">
            <label for="Update_Authority" class="col-md-3 col-form-label">権限</label>
            <select name='Update_Authority' id='Update_Authority' class="form-control col-md-3"><?php echo $PullDown; ?></select>
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
  <div class="modal fade" id="ChangeUsageSituationModal" tabindex="-1" aria-labelledby="ChangeUsageSituationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="ChangeUsageSituationModalLabel">利用状況変更確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <p>スタッフID = <span id="ChangeUsageSituation_Staff_ID"></span> | 氏名 =<span id="ChangeUsageSituation_Staff_Name"></span></p>

          <span id="ChangeUsageSituation_Staff_ID" hidden></span>
          <span id="ChangeUsageSituation_Staff_Name" hidden></span>
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

  document.getElementById("Authority").onchange = function() {  
  NarrowDownDataTable();
  };

  //table絞り込み
  function NarrowDownDataTable() {
  
  var Select_Authority = document.getElementById('Authority').value;

  // table要素を取得
  var TargetTable = document.getElementById('DataInfoTable');      

  var TableDataCount = 0;
  for (i = 0, len = TargetTable.rows.length; i < len; i++) {

    var TargetAuthority = TargetTable.rows[i].dataset["authority"];

      if(Select_Authority == 0 || TargetAuthority == Select_Authority || TargetAuthority ==''){
        TargetTable.rows[i].style='display:table-row';  
        TableDataCount += 1;        
      }else{
        TargetTable.rows[i].style='display:none';       
      }    
          
  }

  document.getElementById("TableDataCount").innerHTML = "データ総数["+ (TableDataCount - 1) +"件]";

  }
  //登録用モーダル表示時
  $('#InsertModal').on('show.bs.modal', function(e) {   

    $('#Insert_Staff_LastName').val('');
    $('#Insert_Staff_FirstName').val('');    
    $('#Insert_Staff_LastNameYomi').val('');
    $('#Insert_Staff_FirstNameYomi').val('');
    $('#Insert_NickName').val('');    
    $('#Insert_Staff_Login_ID').val('');
    $('#Insert_Password').val('');
    $('#Insert_TEL').val('');
    $('#Insert_MailAddress').val('');   
    
  });

  //更新用モーダル表示時
  $('#UpdateModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);
   
    $('#Update_Staff_ID').val(evCon.data('staffid'));

    var FullNameSplit = (evCon.data('staffname')).split('　');
    $('#Update_Staff_LastName').val(FullNameSplit[0]);
    $('#Update_Staff_FirstName').val(FullNameSplit[1]);

    var FullNameyomiYomiSplit = (evCon.data('staffnameyomi')).split('　');    
    $('#Update_Staff_LastNameYomi').val(FullNameyomiYomiSplit[0]);
    $('#Update_Staff_FirstNameYomi').val(FullNameyomiYomiSplit[1]);

    $('#Update_NickName').val(evCon.data('nickname'));
    $('#Update_Login_ID').val(evCon.data('loginid'));
    $('#Update_Password').val(evCon.data('password'));
    $('#Update_TEL').val(evCon.data('tel'));
    $('#Update_MailAddress').val(evCon.data('mailaddress'));    
    $('#Update_Authority').val(evCon.data('authority'));

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

    $('#ChangeUsageSituation_Staff_ID').html(evCon.data('staffid'));
    $('#ChangeUsageSituation_Staff_Name').html(evCon.data('staffname'));


    $('#ChangeUsageSituation_Staff_ID').val(evCon.data('staffid'));
    $('#ChangeUsageSituation_Staff_Name').val(evCon.data('staffname'));    
    $('#ChangeUsageSituation_UsageSituation').val(evCon.data('usage'));

  });

  //登録ボタンクリック時
  $('.ModalInsertButton').on('click', function() {

    var SelectProcessingType = 1;

    //ポストするキーと値を格納
    var DataArray = {
      ProcessingType: SelectProcessingType,
      Staff_Name: $("#Insert_Staff_LastName").val() + '　' + $("#Insert_Staff_FirstName").val(),
      Staff_NameYomi: $("#Insert_Staff_LastNameYomi").val() + '　' + $("#Insert_Staff_FirstNameYomi").val(),      
      NickName: $("#Insert_NickName").val(),
      Login_ID: $("#Insert_Login_ID").val(),
      Password: $("#Insert_Password").val(),
      TEL: $("#Insert_TEL").val(),
      MailAddress: $("#Insert_MailAddress").val(),
      Authority: $("#Insert_Authority").val() 
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage(DataArray.Staff_Name, SelectProcessingType)) {
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
      Staff_ID: $("#Update_Staff_ID").val(),     
      Staff_Name: $("#Update_Staff_LastName").val() + '　' + $("#Update_Staff_FirstName").val(),
      Staff_NameYomi: $("#Update_Staff_LastNameYomi").val() + '　' + $("#Update_Staff_FirstNameYomi").val(),  
      NickName: $("#Update_NickName").val(),
      Login_ID: $("#Update_Login_ID").val(),
      Password: $("#Update_Password").val(),
      TEL: $("#Update_TEL").val(),
      MailAddress: $("#Update_MailAddress").val(),
      Authority: $("#Update_Authority").val() 
    };

    if (!ValueCheck(DataArray)) {
      return;
    }

    if (!ConfirmationMessage('スタッフID：' + $("#Update_Staff_ID").val(), SelectProcessingType)) {
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
      Staff_ID: $("#ChangeUsageSituation_Staff_ID").val()  
    };

    BeforePosting(DataArray);
  });

  function BeforePosting(DataArray) {
    //common.jsに実装
    originalpost("frm_Staff_M.php", DataArray);
  }


  //登録、更新時の値チェック
  function ValueCheck(DataArray) {

    var ErrorMsg = '';
    
    if (DataArray.Staff_Name.replace("　", "") == "") {
      ErrorMsg += '氏名を入力してください。\n';
    }

    if (DataArray.Staff_NameYomi.replace("　", "") == "") {
      ErrorMsg += '氏名（フリガナ）を入力してください。\n';
    }

    if (DataArray.Login_ID == "") {
      ErrorMsg += 'ログインIDを入力してください。\n';
    }

    if (DataArray.Password == "") {
      ErrorMsg += 'パスワードを入力してください。\n';
    }

    if (DataArray.Authority == "0") {
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
</script>

</html>
