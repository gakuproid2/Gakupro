<?php

  class dao_Screen_M {

    function Get_Screen_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    //SELECT_SQL文の発行
    $SQL ="
    SELECT
    Screen_ID 
    ,Screen_Name
    ,Screen_Path
    ,Authority
    ,UsageFlag
    ,Changer
    ,UpdateDate
    FROM
    Screen_m; ";

    //クラスの中の関数の呼び出し
    $DataTable=$obj->select($SQL);
    return $DataTable;
    }


  function Get_MaxCD(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    //SELECT_SQL文の発行
    $SQL =  " 
    SELECT 
    IFNULL(MAX(Screen_ID),0)+1 AS Max_CD
    FROM
    Screen_m ";

    //クラスの中の関数の呼び出し
    $items=$obj->select($SQL);

    foreach($items as $item_val){  
      $Max_CD = $item_val['Max_CD'];
    } 
    
    return $Max_CD;
    }

    function Get_Authority(){
       //クラスファイルの読み込み
       require_once '../dao/DB_Connection.php';
       //クラスの生成
       $obj = new connect();
       //SQL文の発行  
       $SQL = "
       SELECT 
       MainCategory_CD 
       ,SubCategory_CD 
       ,SubCategory_Name 
       ,UsageFlag
       FROM
       Subcategory_m
       WHERE UsageFlag = 1
       AND
       MainCategory_CD = 4
       ;
       ";
 
       //クラスの中の関数の呼び出し
       $items = $obj->select($SQL);
       return $items;
      }

    function DataChange($info,$branch){

    $Screen_ID = $info['Screen_ID'];
    $Screen_Name = $info['Screen_Name'];
    $Screen_Path = $info['Screen_Path'];
    $Authority = $info['Authority'];
    $UsageFlag = $info['UsageFlag'];    
    $Changer = $info['Changer'];
    $UpdateDate = $info['UpdateDate'];

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    if($branch == 1) {

      $SQL = "
      INSERT INTO 
      gakupro.maincategory_m (
      MainCategory_CD 
      ,MainCategory_Name 
      ,UsageFlag 
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$CD'
      ,'$Name'
      ,'$UsageFlag'
      ,'$Changer'
      ,'$UpdateDate'

      ); ";

    } else if($branch == 2) {

      $SQL = "
      UPDATE 
      gakupro.maincategory_m 
      SET 
      MainCategory_Name = '$Name'
      ,UsageFlag = '$UsageFlag'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      MainCategory_CD = $CD;
      ";

    } else if($branch == 3) {

      $SQL = "
      DELETE FROM
      gakupro.maincategory_m 
      WHERE
      MainCategory_CD = $CD;
      ";

    }

    //クラスの中の関数の呼び出し
    $items=$obj->plural($SQL);

    return $items;
    }
  }
?>