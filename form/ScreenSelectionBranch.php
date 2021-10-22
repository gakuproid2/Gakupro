<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
</head>

<?php

session_start(); //セッションスタート

if (isset($_SESSION['Staff_ID'])) {
  $PostUrl = 'frm_ImageUpload.php';
} else {
  $PostUrl = 'frm_ImageGet.php';
}

$Key_Code = '';
if (!empty($_GET['Key_Code'])) {
  $Key_Code = $_GET['Key_Code'];
}

?>

<body>

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