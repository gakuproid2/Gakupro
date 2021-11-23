<!doctype html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>メール送信テスト画面</title>
</head>


<body>

  <form action="frm_SendmailJudge.php" method="POST">
    <p>メールアドレス：<input type="email" id="MailAddress" name="MailAddress" autocomplete="off"></p>
    <p>
      氏名
      姓：<input type="text" id="LastName" name="LastName" autocomplete="off">　
      名：<input type="text" id="FirstName" name="FirstName" autocomplete="off">
    </p>
    <button class="btn_Insert" id="btn_Insert" name="Insert" value="1">送信</button>
    <button class="btn_Clear" id="btn_Clear" name="Clear" value="2">クリア</button>
  </form>



</body>