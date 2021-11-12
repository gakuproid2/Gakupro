<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>本登録</title>
</head>

<body>
  <h1>本登録画面</h1>
  <a href="frm_MainMenu.php" class="btn_Top">メインメニュー</a>

  <?php
    session_start();//セッションスタート
    ini_set('date.timezone', 'Asia/Tokyo'); //後から削除

    //クラスファイルの読み込み
    require_once '../dao/dao_MainCategory_M.php';
    //クラスの生成
    $dao = new dao_MainCategory_M();


  ?>

  <form action="form.php" method="POST">
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
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="2">クリア</button>
  </form>


  

  <script src="../js/jquery-3.6.0.min.js"></script>
</body>


<script>

</script>


</html>