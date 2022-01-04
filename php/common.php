<?php

//画面遷移ボタンの表示判定
class common
{  
  //ヘッダ部分の設定、画面遷移の為のプルダウン作成
  function HeaderCreation($ScreenInfo)
  {   
     //クラスファイルの読み込み
     require_once '../dao/dao_Screen_M.php';
     //クラスの生成
     $dao_Screen_M = new dao_Screen_M();

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

    //画面マスタから画面情報を取得、条件：ログイン者の権限 & 利用有無
    $Data_Table = $dao_Screen_M->Get_Screen_M($Authority);

    //Css情報取得
    $CssInfo = $this->Read_CssConnection();

    //ScreenInfoが数値ならScreenIDと判断しマスタから取得。数値以外(文字列)なら画面名と判断しそのまま画面名にセット
    if (is_numeric($ScreenInfo)) {
      
      foreach ($Data_Table as $val) {
        //表示する画面名取得
        if($ScreenInfo == $val['Screen_CD']){
          $Screen_Name = $val['Screen_Name'];
          break;
        }      
      }

    } else {
      $Screen_Name = $ScreenInfo;
    }

    $SlectForm = '';
    foreach ($Data_Table as $val) {
      $SlectForm .= " <option value=". $val['Screen_Path'] . ">" . $val['Screen_Name'] . "</option>";
    }

    $HeaderInfo = "      
      <head> 
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>      
        <title>" . $Screen_Name . "</title>"
      . $CssInfo .
      "<div class ='Header'>
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
    ";
    return $HeaderInfo;
  }

  //メインメニュー画面のボタン作成処理
  function MainMenu_ButtonCreation()
  {
    //クラスファイルの読み込み
    require_once '../dao/dao_Screen_M.php';
    //クラスの生成
    $dao_Screen_M = new dao_Screen_M();

    $Authority = 0;
    if (isset($_SESSION['Authority'])) {
      $Authority = $_SESSION['Authority'];
    }

    $Data_Table = $dao_Screen_M->Get_Screen_M($Authority);

    $ButtonInfo = '';

    foreach ($Data_Table as $val) {
      $ButtonInfo .= "
       <a class = 'btn_MainMenu' href='" . $val['Screen_Path'] . "'>" . $val['Screen_Name'] . "</a>";
    }

    return $ButtonInfo;
  }

  
  //JavaScript関連の管理  ＠追加する場合はInfo内に追記してください
  function Read_JSConnection()
  {
    $Info = '
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/common.js"></script>    
    <script src="../js/bootstrap.js"></script>  
    ';
    return $Info;
  }

  //css関連の管理  ＠追加する場合はInfo内に追記してください
  function Read_CssConnection()
  {
    
    $Info = '            
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/Header.css">        
    <link rel="stylesheet" href="../css/all.css">    
    <link rel="stylesheet" href="../css/Original.css">
    ';
    return $Info;
  }

  //Directory(階層/フォルダ)作成処理
  function CreateDirectory($Directory)
  {
    //存在しない場合のみ作成      
    if (!file_exists($Directory)) {
      //フォルダ作成
      mkdir($Directory, 0777);
    }
  }
  
  
}
