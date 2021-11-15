<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php

  //クラスファイルの読み込み
  require_once '../dao/dao_MailAddressAuthenticate_T.php';
  //クラスの生成
  $dao_MailAddressAuthenticate_T = new dao_MailAddressAuthenticate_T();  
    
  //後ほど削除予定↓
  $Key_Code = 23001231001;
  if (!empty($_GET['Key_Code'])) {
  //後ほど削除予定↑
  $Key_Code = $_GET['Key_Code'];
  }


  $Judge = false;

  //$Key_Codeでメールアドレス承認情報を取得し変数にセットする
  $GetMailAddressAuthenticateInfo = $dao_MailAddressAuthenticate_T ->GetMailAddressAuthenticateInfo($Key_Code);

  foreach ($GetMailAddressAuthenticateInfo as $val) {         
      $ID = $val['ID'];
      $Key_Code = $val['Key_Code'];
      $Password = $val['Password'];
      $MailAddress = $val['MailAddress'];
      $Name = $val['Name'];
      $CreateDateTime = new DateTimeImmutable($val['CreateDateTime']);        
  }  

  //登録日時に規定時間を加算し比較用の時間を作成
  $ComparisonDateTime = $CreateDateTime->modify("+3 hour");
  //現日時をセット
  $Now = new DateTimeImmutable(date("Y-m-d H:i:s"));

  

  //現日時が比較用時間以内であれば、有効。比較時間を超過している場合は無効
  if ($ComparisonDateTime > $Now) {

    echo "時間範囲内";

    //ポストされた確認する。
    if (count($_POST) > 1) {

      $InputPassword = $_POST["Password"];
      
      if ($InputPassword == $Password) {
        $Judge = true;
      }else{
        echo "パスワード不一致";
      }

    }

  }else{
    
    echo "時間切れ";

  }  
?>

<body>

  <form action="frm_MailAddressAuthenticate.php?Key_Code=<?php echo $Key_Code; ?>" method="POST">
    <p>パスワード：<input type="tel" id="Password" name="Password" autocomplete="off" maxlength="4"></p>
    <button class="btn_Check" id="btn_Check" name="Check" value="1">確認</button>
  </form>

  <script src="../js/jquery-3.6.0.min.js"></script>
</body>


<script>

   //登録ボタンクリック時
   $('#btn_Check').on('click', function() {

    var Password = document.getElementById('Password').value;

    if (String(Password).length != 4) {
      ErrorMsg = '４文字のパスワードを入力してください';
      window.alert(ErrorMsg); // 
      return false;      
    }       
    $('#form_id').submit();
  }); 

  //画面遷移時
$(window).on('load', function(event) {

  var Judge = "<?php echo $Judge; ?>";

  if (Judge == true) {
    post("frm_TemporaryRegistration.php", {
    Key_Code: "<?php echo $Key_Code; ?>"
  });
  } 

});

function post(path, params, method = 'post') {

const form = document.createElement('form');
form.method = method;
form.action = path;

for (const key in params) {
  if (params.hasOwnProperty(key)) {
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = key;
    hiddenField.value = params[key];

    form.appendChild(hiddenField);
  }
}

document.body.appendChild(form);
form.submit();
}



  
</script>

</html>