<?php

  class dao_MainCategory_M {

    function Get_MainCategory_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    //SELECT_SQL文の発行
    $SQL ="
    SELECT
    MainCategory_CD
    ,MainCategory_Name 
    ,UsageFlag 
    FROM
    MainCategory_m; ";

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
    IFNULL(MAX(MainCategory_CD),0)+1 AS Max_CD
    FROM
    MainCategory_m ";

    //クラスの中の関数の呼び出し
    $items=$obj->select($SQL);

    foreach($items as $item_val){  
      $Max_CD = $item_val['Max_CD'];
    } 
    
    return $Max_CD;
    }

    function DataChange($info,$branch){

    $MainCategory_CD = $info['MainCategory_CD'];
    $MainCategory_Name = $info['MainCategory_Name'];
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
      gakupro.MainCategory_m (
      MainCategory_CD 
      ,MainCategory_Name 
      ,UsageFlag 
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$MainCategory_CD'
      ,'$MainCategory_Name'
      ,'$UsageFlag'
      ,'$Changer'
      ,'$UpdateDate'

      ); ";

    } else if($branch == 2) {

      $SQL = "
      UPDATE 
      gakupro.MainCategory_m 
      SET 
      MainCategory_Name = '$MainCategory_Name'
      ,UsageFlag = '$UsageFlag'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      MainCategory_CD = $MainCategory_CD;
      ";

    } else if($branch == 3) {

      $SQL = "
      DELETE FROM
      gakupro.MainCategory_m 
      WHERE
      MainCategory_CD = $MainCategory_CD;
      ";

    }

    //クラスの中の関数の呼び出し
    $items=$obj->plural($SQL);

    return $items;
    }
  }
?>