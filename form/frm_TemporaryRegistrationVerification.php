<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php

  //クラスファイルの読み込み
  require_once '../dao/dao_Temporarymember_T.php';
  //クラスの生成
  $dao_Temporarymember_T = new dao_Temporarymember_T();  

  $Key_Code = $_GET['Key_Code'];

  //$Key_Codeで仮登録情報を取得し変数にセットする
  $GetTemporaryInfo = $dao_Temporarymember_T ->GetTemporaryInfo($Key_Code);

  foreach ($GetTemporaryInfo as $val) {         
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
        echo "パスワード一致";
      }else{
        echo "パスワード不一致";
      }

    }

  }else{
    
    echo "時間切れ";

  }  
?>

<body>

  <form action="frm_TemporaryRegistrationVerification.php?Key_Code=<?php echo $Key_Code; ?>" method="POST">
    <p>パスワード：<input type="tel" id="Password" name="Password" autocomplete="off"></p>
    <button class="btn_Check" id="btn_Check" name="Check" value="1">確認</button>
  </form>

  <script src="../js/jquery-3.6.0.min.js"></script>
</body>


<script>
  //画面遷移時
  $(window).on('load', function(event) {
    
    post("<?php echo $PostUrl; ?>", {
      Key_Code: "<?php echo $Key_Code; ?>"
    });

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