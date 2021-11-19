<!DOCTYPE html>
<html lang="ja">

<?php

  session_start(); //セッションスタート

  //クラスファイルの読み込み
  require_once '../php/common.php';
  //クラスの生成
  $common = new common();
  
  //クラスファイルの読み込み
  require_once '../dao/dao_SubCategory_M.php';
  //クラスの生成
  $dao_SubCategory_M = new dao_SubCategory_M();

  //クラスファイルの読み込み
  require_once '../dao/dao_MainCategory_M.php';
  //クラスの生成
  $dao_MainCategory_M = new dao_MainCategory_M();

  $HeaderInfo = $common->HeaderCreation(5);

  $JS_Info = $common->Read_JSconnection();

?>

<?php echo $HeaderInfo; ?>

<?php

  if (isset ($_POST["MainCategory_CD"])){$MainCategory_CD=$_POST["MainCategory_CD"];}else{$MainCategory_CD=0;};
  
  if (isset ($_POST["DataChange"])){ 

    //利用フラグを宣言し、チェック時は1を格納するIf文    
    $UsageFlag = 0;
    if (isset($_POST["UsageFlag"])) {
      $UsageFlag = 1;
    };
        
    $info = array(
      'MainCategory_CD' => $_POST["MainCategory_CD"], 
      'SubCategory_CD' => $_POST["SubCategory_CD"], 
      'SubCategory_Name' => $_POST["SubCategory_Name"],
      'UsageFlag' => $UsageFlag,
      'Changer' => $_SESSION["Staff_ID"],
      'UpdateDate' => date("Y-m-d H:i:s")
    );

     //データ変更種類に種別  1=登録、2=更新、3=論理削除
      $Processing = $_POST["DataChange"];
      $Result = false;

      if ($Processing == 1) {
        $Result = $dao_SubCategory_M->DataChange($info, $Processing);
      } else if ($Processing == 2) {
        $Result = $dao_SubCategory_M->DataChange($info, $Processing);
      } else if ($Processing == 3) {
        $Result = $dao_SubCategory_M->DataChange($info, $Processing);
      }

      if ($Result ==true) {
        Header('Location: ' . $_SERVER['PHP_SELF']);
        exit(); //optional
      } 
  }

  //メインカテゴリーのプルダウン作成する為
  $items = $dao_MainCategory_M->GET_MainCategory_m();
  //0行目
  $PullDown = "<option value = 0 >選択してください</option>";
  foreach ($items as $item_val) {

    $PullDown .= "<option value = " . $item_val['MainCategory_CD'];

    if ($MainCategory_CD == $item_val['MainCategory_CD']) {
      $PullDown .= " selected>";
    } else {
      $PullDown .= " >";
    }
      $PullDown  .= $item_val['MainCategory_Name'] . "</option>";
  }

  //表示用Table作成用（メインカテゴリーコードで参照）
  $Data_Table = $dao_SubCategory_M->Get_SubCategory_M($MainCategory_CD);
  $Table = "";
  //取得したデータ数文ループ
  foreach ($Data_Table as $val) {
    $Table .="<tr class='List'>          
    <td style=display:none>" . $val['MainCategory_CD'] . "</td>
    <td>" . $val['MainCategory_Name'] . "</td>
    <td>" . $val['SubCategory_CD'] . "</td>
    <td>" . $val['SubCategory_Name'] . "</td>
    ";

    if ($val['UsageFlag'] == 0) {
      $Table .= " <td>×</td>";
    } else {
      $Table .= " <td>〇</td>";
    }
    $Table .= "</tr>";
  }

  //MainCategory_CDが1以上時のみ
  if ($MainCategory_CD > 0) {
  //メインカテゴリーコードを渡しサブカテゴリーコードのMax値取得
    $Max_CD = $dao_SubCategory_M->Get_MaxCD($MainCategory_CD);    
  } else {
    $Max_CD = "";
  }
?>

<body>

  <form action="frm_SubCategory_M.php" method="post">
    <p>大分類：<select ID='MainCategory_CD' name='MainCategory_CD'><?php echo $PullDown; ?></select></p>
    <p>中分類コード：<input type='text' id="SubCategory_CD" name='SubCategory_CD' value='<?php echo $Max_CD; ?>' readonly></p>
    <p>中分類名：<input type="text" id="SubCategory_Name" name="SubCategory_Name" autocomplete="off"></p>
    <p>利用フラグ：<input type="checkbox" id="chk_UsageFlag" name="UsageFlag" value="1" checked="checked"></p>

    <button class="btn_Insert" id="btn_Insert" name="DataChange" value="1">登録</button>
    <button class="btn_Update" id="btn_Update" name="DataChange" value="2">更新</button>
    <button class="btn_Delete" id="btn_Delete" name="DataChange" value="3">削除</button>    
  </form>
  <button class="btn_Clear" id="btn_Clear" name="DataChange" value="4">クリア</button>

  <table border='1'>
    <tr>
    <th>大分類名</th>
    <th>中分類コード</th>
    <th>中分類名</th>
    <th>利用フラグ</th>
    </tr>
    <?php echo $Table; ?>
  </table>

  <?php echo $JS_Info?>
</body>

<script>
  //画面遷移時
  $(window).on('load', function(event) {
    $("#btn_Insert").show();
    $("#btn_Update").hide();
    $("#btn_Delete").hide();
  });

  //テーブルクリック時
  $('.List').on('click', function() {

    var MainCategory_CD = $(this).children('td')[0].innerText;
    $("#MainCategory_CD").val(MainCategory_CD);

    var SubCategory_CD = $(this).children('td')[2].innerText;
    $("#SubCategory_CD").val(SubCategory_CD);

    var SubCategory_Name = $(this).children('td')[3].innerText;
    $("#SubCategory_Name").val(SubCategory_Name);

    var UsageFlag = $(this).children('td')[4].innerText;

    if (UsageFlag == '〇') {
      $("#chk_UsageFlag").prop('checked', true);
    } else {
      $("#chk_UsageFlag").prop('checked', false);
    }

    $("#btn_Insert").hide();
    $("#btn_Update").show();
    $("#btn_Delete").show();

  });

  //プルダウン変更時
  document.getElementById("MainCategory_CD").onchange = function() {
  
  //ポストするキーと値を格納
  var DataArray = 
  {MainCategory_CD:$("#MainCategory_CD").val() 
  };  

  //common.jsに実装
  post("frm_SubCategory_M.php", DataArray);

};

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
    window.location.href = 'frm_SubCategory_M.php'
  });

  //登録、更新時の値チェック
  function ValueCheck() {

    var ErrorMsg = '';
    if ($("#MainCategory_CD").val() == 0) {
      ErrorMsg += '大分類を選択してください。\n';
    }

    if ($("#SubCategory_Name").val() == "") {
      ErrorMsg += '中分類名を入力してください。\n';
    }

    if (!ErrorMsg == "") {
      ErrorMsg = '以下は必須項目です。\n' + ErrorMsg;
      window.alert(ErrorMsg); // 
      return false;
    } else {
      return true;
    }

  }
</script>

</html>