<?php

class dao_School_M {
  
  function Get_School_M($School_Division){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();
    
    //SQL文の発行
    $SQL ="
    SELECT
    School_m.School_CD
    ,School_m.School_Division
    ,Subcategory_m.SubCategory_Name AS DivisionInfo
    ,School_m.School_Name
    ,School_m.TEL
    ,School_m.URL
    ,School_m.UsageSituation
    FROM
    School_m
    INNER JOIN
    Subcategory_m
    ON
    Subcategory_m.MainCategory_CD = 3
    AND
    Subcategory_m.SubCategory_CD = School_m.School_Division    
    " 
    ;

    if ($School_Division > 0) {
      $SQL .="
      WHERE
      School_m.School_Division = '$School_Division'";
    }

    $SQL .="
    ORDER BY
    School_m.School_CD
    ,School_m.School_Division";
    
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



  function DataChange($info){

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    //1 = 登録、2 = 更新、3 = 利用可能に更新、 4 = 利用不可に更新
    $ProcessingType = $info['ProcessingType'];

    if ($ProcessingType == 4) {
      $UsageSituation = 0;
    } else {
      $UsageSituation = 1;
    }

    $School_CD = $info['School_CD'];
    $School_Division = $info['School_Division'];
    $School_Name = $info['School_Name'];
    $TEL = $info['TEL'];
    $URL = $info['URL'];    
    $Changer = $_SESSION["Staff_ID"];
    $UpdateDate = date("Y-m-d H:i:s");  
    
    if ($ProcessingType == 1) {

      //新規登録時はMaxID取得      
      $School_CD = $this->Get_MaxCD();

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
      '$School_CD'
      ,'$School_Division'
      ,'$School_Name'
      ,'$TEL'
      ,'$URL'
      ,'$UsageSituation'
      ,'$Changer'
      ,'$UpdateDate'
    ); ";

    } else if ($ProcessingType == 2) {
      $SQL = "
      UPDATE 
      gakupro.school_m 
      SET 
      School_Division = '$School_Division'
      ,School_Name = '$School_Name'
      ,TEL = '$TEL'
      ,URL = '$URL'      
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      School_CD = $School_CD;
      ";

    } else if ($ProcessingType == 3 or $ProcessingType == 4) {
      $SQL = "
      UPDATE 
      gakupro.school_m 
      SET 
      UsageSituation = '$UsageSituation'  
      ,Changer = '$Changer' 
      ,UpdateDate = '$UpdateDate'
      WHERE
      School_CD = $School_CD;
      ";
    }
        
    //クラスの中の関数の呼び出し
    return $DB_Connection->pluralTransaction($SQL);    
  }
}
?>