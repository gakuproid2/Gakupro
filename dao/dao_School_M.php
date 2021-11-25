<?php

class dao_School_M {
  
  function Get_School_M($School_Division, $checkFLG){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();
    
    //SQL文の発行
    $SQL ="
    SELECT
    School_CD
    ,School_Division
    ,School_Name
    ,TEL
    ,URL
    ,UsageSituation
    FROM
    School_m";

    if (!empty($checkFLG)) {
      $SQL .="
      WHERE
      School_Division = '$School_Division'";
    }

    $SQL .="
    ORDER BY
    School_CD
    ,School_Division";
    
    //クラスの中の関数の呼び出し
    $DataTable=$DB_Connection->select($SQL);
    return $DataTable;
  }


  function Get_MaxCD(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_sql文の発行
    $SQL = " SELECT
    IFNULL(MAX(School_CD),0)+1 AS Max_CD
    FROM
    School_m ";

    //クラスの中の関数の呼び出し
    $items=$DB_Connection->select($SQL);

    foreach($items as $item_val){  
      $Max_CD = $item_val['Max_CD'];
    }

    return $Max_CD;
  }



  function DataChange($info,$branch){

    $CD = $info['CD'];
    $Division = $info['Division'];
    $Name = $info['Name'];
    $TEL = $info['TEL'];
    $URL = $info['URL'];
    $UsageSituation = $info['UsageSituation'];
    $Changer = $info['Changer'];
    $UpdateDate = $info['UpdateDate'];

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();
    
    if($branch == 1) {
      $SQL = "
      INSERT INTO
      gakupro.school_m (
      School_CD
      ,School_Division
      ,School_Name
      ,TEL
      ,URL
      ,UsageSituation
      ,Changer
      ,UpdateDate
      )VALUES(
      '$CD'
      ,'$Division'
      ,'$Name'
      ,'$TEL'
      ,'$URL'
      ,'$UsageSituation'
      ,'$Changer'
      ,'$UpdateDate'
    ); ";

    } else if($branch == 2) {
      $SQL = "
      UPDATE 
      gakupro.school_m 
      SET 
      School_Division = '$Division'
      ,School_Name = '$Name'
      ,TEL = '$TEL'
      ,URL = '$URL'
      ,UsageSituation = '$UsageSituation'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      School_CD = $CD;
      ";

    } else if($branch == 3) {
      $SQL = "
      DELETE FROM
      gakupro.school_m
      WHERE
      School_CD = $CD;
      ";

    }
        
    //クラスの中の関数の呼び出し
    $items=$DB_Connection->plural($SQL);
    
    return $items;
  }
}
?>