<!DOCTYPE html>
<html lang="ja">


<?php
session_start(); //セッションスタート

//クラスファイルの読み込み
require_once '../php/common.php';
//クラスの生成
$common = new common();

//クラスファイルの読み込み
require_once '../dao/dao_MainCategory_M.php';
//クラスの生成
$dao_MainCategory_M = new dao_MainCategory_M();

$HeaderInfo = $common->HeaderCreation(4);

$JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<?php


if (isset($_POST["MainCategory_CD"])) {$MainCategory_CD = $_POST["MainCategory_CD"];} else {$MainCategory_CD = 0;};

//ポストされた確認する。
if (count($_POST) > 1) {

  $UsageFlag = 0;
  if (isset($_POST["UsageFlag"])) {
    $UsageFlag = 1;
  };

  $info = array(
    'MainCategory_CD' => $_POST["MainCategory_CD"],
    'MainCategory_Name' => $_POST["MainCategory_Name"],
    'UsageFlag' => $UsageFlag,
    'Changer' => $_SESSION["Staff_ID"],
    'UpdateDate' => date("Y-m-d H:i:s")
  );

  $Result = "";

  //登録、削除、更新の分岐
  if (isset($_POST['Insert'])) {
    $Result = $dao_MainCategory_M->DataChange($info, 1);
  } else if (isset($_POST['Update'])) {
    $Result = $dao_MainCategory_M->DataChange($info, 2);
  } else if (isset($_POST['delete'])) {
    $Result = $dao_MainCategory_M->DataChange($info, 3);
  }

  Header('Location: ' . $_SERVER['PHP_SELF']);
  exit(); //optional
}

//MainCategory_MのMaxCD取得処理
$Max_CD = $dao_MainCategory_M->Get_MaxCD();

$Data_Table = $dao_MainCategory_M->Get_MainCategory_M();



$Table = "
<table border='1'>
<tr>
  <th>大分類コード</th><th>大分類名</th><th></th>
</tr>
";
foreach ($Data_Table as $val) {

  $Table .=
  "
  <tr class='InfoTable'>
    <td>" . $val['MainCategory_CD'] . "</td>
    <td>" . $val['MainCategory_Name'] . " </td>
    <td>
      <button class='' data-bs-toggle='modal' data-bs-target='#exampleModal' 
      data-maincd='" . $val['MainCategory_CD'] . "'
      data-mainname='" . $val['MainCategory_Name'] . "'
      data-UsageFlag='" . $val['UsageFlag'] . "'><i class='far fa-edit'></i></button>   

    </td>
    <td>
    
    <button class='' data-bs-toggle='modal' data-bs-target='#deleteModal'
      data-maincd='" . $val['MainCategory_CD'] . "'
      data-mainname='" . $val['MainCategory_Name'] . "'
      data-UsageFlag='" . $val['UsageFlag'] . "' ><i class='far fa-times-circle'></i></button>   
    </td>
  "
  ;
}
  $Table .= "</table>";
?>

<body>

  <?php echo $Table; ?>

  <!-- データ詳細Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">  
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label for="MainCategory_CD" class="col-md-3 col-form-label">大分類コード</label>
            <input type="text" name="MainCategory_CD" id="MainCategory_CD" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">
            <label for="MainCategory_Name" class="col-md-3 col-form-label">大分類名</label>
            <input type="text" name="MainCategory_Name" id="MainCategory_Name" value="" class="form-control col-md-3">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary">更新</button>
          </div>
        </div>
      </div>
    </div>


   

    <?php echo $JS_Info ?>
</body>

<script>
  //画面遷移時
  $(window).on('load', function(event) {
    
  });



  $('#exampleModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);

    $('#MainCategory_CD').val(evCon.data('maincd'));
    $('#MainCategory_Name').val(evCon.data('mainname'));

  });

  $('#deleteModal').on('show.bs.modal', function(e) {
    // イベント発生元
    let evCon = $(e.relatedTarget);

    var MainCategory_CD = evCon.data('maincd');
   

  });

  
  //クリアボタンクリック時
  $('#btn_Clear').on('click', function() {
    window.location.href = 'frm_MainCategory_M.php'
  });

  //登録、更新時の値チェック
  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#MainCategory_Name").val() == "") {
      ErrorMsg += '大分類名を入力してください。\n';
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