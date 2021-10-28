<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>画像取得</title>
</head>

<?php
//クラスファイルの読み込み
require_once '../dao/dao_ImageGetResult.php';
//クラスの生成
$dao = new dao_ImageGetResult();

$ImageALL = "";

$json_Judge = true;
$json_TargetDir = '';
$json_ImageName_array = '';

//[写真確認]ボタンの押下確認
if (isset($_POST['PictureGet'])) {

  $Key_Code = $_POST["Key_Code"];
  $info = array(
    'Key_Code' => $_POST["Key_Code"],
    'Password' => $_POST["Password"]
  );

  //キーナンバーとパスワードでフォルダ名取得処理
  $GetData = $dao->PasswordCheck($info);

  $Judge = false;
  foreach ($GetData as $val) {
    $Judge = true;
  }

  $date = substr($Key_Code, 0, 8);
  $Key_Num = substr($Key_Code, 8);

  if ($Judge == true) {

    $downloadImg = '';


    $TargetDir = '../File/' . $date . '/Image/' . $Key_Num . '/';
    //ターゲットディレクトリにある全ファイル名を取得
    $ImageNameALL = glob($TargetDir . '*');

    $ImageName_array = [];

    foreach ($ImageNameALL as $ImageUrlName) {
      $ImageALL .= "<p class='sample'><img src=" . $ImageUrlName . "></p>";

      array_push($ImageName_array, str_replace($TargetDir, "", $ImageUrlName));
    }

    if ($ImageALL == "") {
      $ImageALL = '<h2>写真がまだアップロードされておりません。</h2>';
    }

    $json_Judge = json_encode($Judge);
    $json_TargetDir = json_encode($TargetDir);
    $json_ImageName_array = json_encode($ImageName_array);
  }
}
?>

<body>
  <h1>画像取得</h1>
  <?php echo $ImageALL; ?>

  <button class="btn_Download" id="btn_Download" name="Download">一括ダウンロード</button>
  <p>※一括ダウンロードはPCの場合のみ可能です※<br>
  PC以外は画像を長押ししてダウンロードしてください。</p>

  <script src="../js/jquery-3.6.0.min.js"></script>
</body>

<script>
  //画面遷移時
  $(window).on('load', function(event) {

    var Judge = JSON.parse('<?php echo $json_Judge; ?>');
    console.log(Judge)


    if (Judge !== true) {

      post("frm_ImageGet.php", {
        Key_Code: <?php echo $Key_Code; ?>,
        ErrorResult: false
      });
    };
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



  //ダウンロードボタンクリック時
  $('#btn_Download').on('click', function() {

    var TargetDir = JSON.parse('<?php echo $json_TargetDir; ?>');

    var ImageName_array = JSON.parse('<?php echo $json_ImageName_array; ?>');

    // 配列の中身を一つずつ処理
    $.each(ImageName_array, function(index, val) {

      var ImageName = (val);

      var a = document.createElement('a');
      a.download = ImageName;
      a.href = TargetDir + ImageName;

      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);

    });




  });
</script>

</html>