<?php

//画面遷移ボタンの表示判定
class common {

  //ヘッダ部分の設定、画面遷移の為のプルダウン作成
  function HeaderCreation()
  {       
    $Authority = 0;
    if (isset($_SESSION['Authority'])) {
      $Authority = $_SESSION['Authority'];
    }
  
    $NickName = 'ログインをやり直してください';
    if (isset($_SESSION['NickName'])) {
      $NickName = $_SESSION['NickName'];
    }

    $Data_Table = $this->ScreenSelection($Authority);

    $SlectForm = ''; 

    foreach ($Data_Table as $val) {
      $SlectForm .= " <option value=" . $val['Screen_Path'] . ">" . $val['Screen_Name'] . "</option>";       
    }

    $HeaderInfo = "      
      <div class='Header_PullMenu'>
        <form name='pullForm'>
          <select name='pullMenu' id='' onChange='screenChange()'>
          <option value=''></option>
          "
          .  $SlectForm .
          "      
          </select>          
        </form>
      </div>      
      <div class ='Header_StaffName'><p>" .  $NickName . "</p></div>      
    "
    ;

    return $HeaderInfo;
  } 
     
  //メインメニュー画面のボタン作成処理
  function MainMenu_ButtonCreation()
  {   
    
    $Authority = 0;
    if (isset($_SESSION['Authority'])) {
      $Authority = $_SESSION['Authority'];
    }
  
    $Data_Table = $this->ScreenSelection($Authority);

    $ButtonInfo = ''; 

    foreach ($Data_Table as $val) {
      $ButtonInfo .= "
       <a class = 'btn_MainMenu' href='" . $val['Screen_Path'] . "'>". $val['Screen_Name'] . "</a>";       
    }
       
    return $ButtonInfo;
  } 


  function ScreenSelection($Authority)
  {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj = new connect();

    $SQL = "
    SELECT
    Screen_ID
    ,Screen_Name
    ,Screen_Path 
    ,Authority
    FROM
    Screen_M
    WHERE
    Authority >= $Authority
    AND
    UsageFlag > 0
    ";
    //クラスの中の関数の呼び出し
    $items = $obj->plural($SQL);

    return $items;
  }

  //JavaScript関連の管理  ＠追加する場合はInfo内に追記してください
  function Read_JSconnection()
  {
    $Info = '
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/common.js"></script>    
    ';

    return $Info;
  }
  

}

?>