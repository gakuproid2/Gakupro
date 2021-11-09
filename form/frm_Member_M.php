<!DOCTYPE html>
<html lang="ja">

<?php
  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  $HeaderInfo = $common->HeaderCreation(14); 
  
  $JS_Info = $common->Read_JSConnection();
?>

<?php echo $HeaderInfo; ?>

<?php 
  //クラスファイルの読み込み
  require_once '../dao/dao_Member_M.php';
  //クラスの生成
  $dao = new dao_Member_M();

  //ポストされた確認する。
  if (count($_POST) > 1) {     

    $info = array(
      'Member_ID' => $_POST["Member_ID"],
      'Name' => $_POST["Name"],
      'Furigana' => $_POST["Furigana"],
      'Birthday' => $_POST["Birthday"],
      'School_CD' => $_POST["School_CD"],
      'MajorSubject_CD' => $_POST["MajorSubject_CD"],
      'TEL' => $_POST["TEL"],
      'EmergencyContact' => $_POST["EmergencyContact"],
      'Remarks' => $_POST["Remarks"],     
      'Changer' => $_SESSION["_ID"],
      'UpdateDate' => date("Y-m-d H:i:s")
    );

    $Result = "";

    //登録、削除、更新の分岐
    if (isset($_POST['Insert'])) {
      $Result = $dao->DataChange($info, 1);
    } else if (isset($_POST['Update'])) {
      $Result = $dao->DataChange($info, 2);
    } else if (isset($_POST['Delete'])) {
      $Result = $dao->DataChange($info, 3);
    }

    Header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); //optional
  }

  $Data_Table = $dao->Get_Member_M();

  $Table = "";
  foreach ($Data_Table as $val) {

    $Table .=
    "<tr class='Table'>
      <td>" . $val['Member_ID'] . "</td>
      <td>" . $val['Name'] . " </td>      
      <td>" . $val['Furigana'] . " </td>
      <td>" . $val['Birthday'] . " </td>  
      <td style=display:none>" . $val['School_CD'] . "</td>      
      <td>" . $val['School_Name'] . " </td>  
      <td style=display:none>" . $val['MajorSubject_CD'] . "</td>      
      <td>" . $val['MajorSubject_Name'] . " </td>  
      <td>" . $val['TEL'] . " </td>
      <td>" . $val['EmergencyContact'] . " </td>      
      <td style=display:none>" . $val['Remarks'] . "</td> 
      <td>" . $val['ChangerName'] . " </td>
      <td>" . $val['UpdateDate'] . " </td>
    "
    ; 

    $Table .= "</tr>";
  }
?>
<body>

  <form action="frm_Screen_M.php" method="post">
  
    <p>メンバーID：<input type="text" id="txt_ID" name="ID" readonly></p>
    <p>
      氏名
      姓：<input type="text" id="txt_LastName" name="LastName" autocomplete="off">　
      名：<input type="text" id="txt_Name" name="Name" autocomplete="off">
    </p>
    <p>
      氏名(ﾌﾘｶﾞﾅ)
      姓：<input type="text" id="txt_LastName_Yomi" name="LastNameYomi" autocomplete="off">　
      名：<input type="text" id="txt_Name_Yomi" name="NameYomi" autocomplete="off">
    </p>
    

    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="Update" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="Delete" value="3">削除</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="4">クリア</button>
  </form>

  <table border='1'>
    <tr>
    <th>メンバーID</th>
    <th>氏名</th>
    <th>フリガナ</th>
    <th>生年月日</th>
    <th>学校</th>
    <th>専攻</th>
    <th>TEL</th>
    <th>緊急連絡先</th> 
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
    $("#btn_Delete").hide();
  });

  //テーブルクリック時
  $('.Table').on('click', function() {

    //MemberID
    var Member_ID = $(this).children('td')[0].innerText;
    $("#txt_ID").val(Member_ID);

    //名前    取得した名前を姓と名で分けてテキストに格納する
    var Name = $(this).children('td')[1].innerText;
    var NameSplit = Name.split('　');
    $("#txt_LastName").val(NameSplit[0]);
    $("#txt_Name").val(NameSplit[1]);

    //ﾌﾘｶﾞﾅ
    var Name_Yomi = $(this).children('td')[2].innerText;
    var Name_YomiSplit = Name_Yomi.split(' ');
    $("#txt_LastName_Yomi").val(Name_YomiSplit[0]);
    $("#txt_Name_Yomi").val(Name_YomiSplit[1]);

    $("#btn_Insert").hide();
    document.getElementById("btn_Insert").disabled = true;
    $("#btn_Update").show();
    $("#btn_Delete").show();    

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

  //削除ボタンクリック時
  $('#btn_Delete').on('click', function() {

    if (window.confirm('削除してもよろしいですか？')) {
      $('#form_id').submit();
    } else {
      return false;
    }

  });

  //クリアボタンクリック時
  $('#btn_Clear').on('click', function() {
    window.location.href = 'frm_Screen_M.php'
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
</script>

</html>