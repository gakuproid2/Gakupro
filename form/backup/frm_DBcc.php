<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/style.css">
  <title>DB接続確認画面</title>
</head>

<?php
  //クラスファイルの読み込み
  require_once '../dao/DB_Connection.php';
  //クラスの生成
  $obj=new connect();
  //sql文の発行
  $sql="SHOW TABLES FROM gakupro;";

  //クラスの中の関数の呼び出し
  $AllTables=$obj->select($sql);

  $Table = "";
  $x = 1;

  foreach($AllTables as $val){
    $Table .=
    "<tr class='Table'>
    <td>" . $x++ . "</td>
    <td>" . $val['Tables_in_gakupro'] . " </td>
    </tr>";
  }
?>

<body>

  <a href="frm_MainMenu.php" class="btn_Top">メインメニュー</a> 

  <table border='1'>
    <tr>
    <th>Num</th>
    <th>テーブル名</th>      
    </tr>
    <?php echo $Table; ?>
  </table>

  <?php echo phpinfo(); ?>

  <script src="../js/common.js"></script>
</body>
