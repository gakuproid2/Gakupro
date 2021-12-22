<?php
class dao_photoget_t
{

  //登録処理
  function Insert_photoget_t($Key_Code, $Password)
  {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    $SQL = "
    INSERT INTO 
    gakupro.photoget_t (
    Key_Code
    ,Password    
    )VALUES(
    '$Key_Code'
    ,'$Password');
    ";
    //クラスの中の関数の呼び出し
    $items = $DB_Connection->plural($SQL);

    return $items;
  }

  //日付別でキーコード数取得処理
  function Get_Quantity($Date)
  {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    $SQL = "
    SELECT
    日付
    ,作成数
    FROM
    (
    SELECT 
    LEFT(Key_Code,8) 日付
    ,COUNT(LEFT(Key_Code,8))作成数
    FROM
    gakupro.photoget_t 
    GROUP BY
    LEFT(Key_Code,8)
    )AS WORK
    WHERE
    日付 = '$Date';
    ";
    //クラスの中の関数の呼び出し
    $items = $DB_Connection->plural($SQL);
   
    //初期値は0をセット
    $Quantity = 0;
    //値がある場合は作成数をセット
    foreach($items as $item_val){  
      $Quantity = $item_val['作成数'];
    } 
    //作成数を返す
    return $Quantity;
   
  }

  //日付別でパスワード取得処理
  function Get_PassWord($Date)  {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    $SQL = "
    SELECT 
    Key_Code
    ,PassWord
    FROM
    gakupro.photoget_t 
    WHERE
    LEFT(Key_Code,8) = '$Date';
    ";
    //クラスの中の関数の呼び出し
    $items = $DB_Connection->plural($SQL);
    
    return $items;

  }

  //日付別データ取得
  function Get_photoget_t($Date)
  {
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    $SQL = "
    SELECT
    Key_Code
    ,PassWord
    FROM
    gakupro.photoget_t
    WHERE
    LEFT(Key_Code,8) = '$Date'
    ;
    ";
    //クラスの中の関数の呼び出し
    $items = $DB_Connection->plural($SQL);

    return $items;
  }



}
