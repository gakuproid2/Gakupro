<?php

//画面遷移ボタンの表示判定
class common {

  //ヘッダ部分の設定、画面遷移の為のプルダウン作成
  function HeaderCreation($ScreenInfo)
  {       
    //ログイン情報から権限取得
    $Authority = 0;
    if (isset($_SESSION['Authority'])) {
      $Authority = $_SESSION['Authority'];
    }
  
    //ログイン情報からニックネーム取得
    $NickName = 'ログインをやり直してください';
    if (isset($_SESSION['NickName'])) {
      $NickName = $_SESSION['NickName'];
    }

    //画面マスタから画面情報を取得、条件：ログイン者の権限、利用有無
    $Data_Table = $this->ScreenSelection($Authority);

    //Css情報取得
    $CssInfo = $this->Read_CssConnection();

    //ScreenInfoが数値ならScreenIDと判断しマスタから取得。数値以外(文字列)なら画面名と判断しそのまま画面名にセット
    if (is_numeric($ScreenInfo)) {
       //表示する画面名取得
    $Screen_Name = $this->GetScreenName($ScreenInfo);
    } else {
      $Screen_Name = $ScreenInfo;
    }

   

    
    $SlectForm = ''; 
    foreach ($Data_Table as $val) {
      $SlectForm .= " <option value=" . $val['Screen_Path'] . ">" . $val['Screen_Name'] . "</option>";       
    }

    $HeaderInfo = "      
      <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>      
        <title>" . $Screen_Name . "</title>
        "
          . $CssInfo .
        "
        <div class ='Header'>
          <div class='Header_PullMenu'>
            <form name='pullForm'>
            <select name='pullMenu' id='' onChange='screenChange()'>
            <option value=''></option>
            "
            . $SlectForm .
            "      
            </select>          
            </form>
            </div>      
          <div class ='Header_StaffName'><p>" . $NickName . "</p></div>        
          <div class ='Header_ScreenName'><p>" . $Screen_Name . "</p></div>
        </div>
      </head>      
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

  function GetScreenName($Screen_ID)
  {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj = new connect();

    $SQL = "
    SELECT
    Screen_ID
    ,Screen_Name 
    FROM
    Screen_M
    WHERE
    Screen_ID = $Screen_ID   
    ";
    //クラスの中の関数の呼び出し
    $items = $obj->plural($SQL);

    $Screen_Name = '';
    foreach ($items as $val) {
      $Screen_Name = $val['Screen_Name'];
    }

    return $Screen_Name;

  }

  //JavaScript関連の管理  ＠追加する場合はInfo内に追記してください
  function Read_JSConnection()
  {
    $Info = '
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/common.js"></script>    
    ';
    return $Info;
  }

  //Css関連の管理  ＠追加する場合はInfo内に追記してください
  function Read_CssConnection()
  {
    $Info = '
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/Header.css">  
    ';
    return $Info;
  }
  
  function GET_Subcategory_m($MainCategory_CD) {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj = new connect();

    //SQL文の発行
    $SQL ="
    SELECT 
    SubCategory_CD 
    ,SubCategory_Name 
    ,UsageFlag
    FROM
    Subcategory_m
    WHERE 
    MainCategory_CD = $MainCategory_CD
    and 
    UsageFlag = 1;
    ";

    //クラスの中の関数の呼び出し
    $items = $obj->select($SQL);
    return $items;
  }

}

?>