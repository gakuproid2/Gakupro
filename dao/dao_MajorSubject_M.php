<?php

class dao_MajorSubject_M {

 
  function GET_Majorsubject_m($School_CD){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    //SQL文の発行
    $SQL = "
    SELECT
    majorsubject_m.school_cd AS School_CD
    ,school_m.school_name AS School_Name
    ,school_m.school_division AS School_Division
    ,majorsubject_m.majorsubject_cd AS MajorSubject_CD
    ,majorsubject_m.majorsubject_name AS MajorSubject_Name
    ,majorsubject_m.studyPeriod AS StudyPeriod    
    ,majorsubject_m.remarks AS Remarks
    ,majorsubject_m.UsageSituation AS UsageSituation
    FROM
    majorsubject_m AS majorsubject_m
    INNER JOIN
    school_m AS school_m
    ON
    majorsubject_m.School_CD = school_m.School_CD";

    if ($School_CD > 0) {
      $SQL .="
        WHERE
        majorsubject_m.School_CD ='$School_CD'";
    }

    $SQL .="
    ORDER BY
    majorsubject_m.school_cd 
    ,majorsubject_m.majorsubject_cd
    ";

    //クラスの中の関数の呼び出し
    $items = $DB_Connection->select($SQL);
    return $items;
  }


  function Get_MaxCD($School_CD){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_sql文の発行
    //SQL文の発行
    $SQL ="
    SELECT
    IFNULL(MAX(MajorSubject_CD),0)+1 AS Max_CD
    FROM
    majorsubject_m
    WHERE
    School_CD = ' $School_CD ';";

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
    $DB_Connection=new connect();

    //1 = 登録、2 = 更新、3 = 利用可能に更新、 4 = 利用不可に更新
    $ProcessingType = $info['ProcessingType'];

    if ($ProcessingType == 4) {
      $UsageSituation = 0;
    } else {
      $UsageSituation = 1;
    }

    $School_CD = $info['School_CD'];
    $MajorSubject_CD = $info['MajorSubject_CD'];
    $MajorSubject_Name = $info['MajorSubject_Name'];
    $StudyPeriod = $info['StudyPeriod'];
    $Remarks = $info['Remarks'];    
    $Changer = $_SESSION["Staff_ID"];
    $UpdateDate = date("Y-m-d H:i:s");  
    
    
    if ($ProcessingType == 1) {

      //新規登録時はMaxID取得      
      $MajorSubject_CD = $this->Get_MaxCD($School_CD);

      $SQL = "
      INSERT INTO
      gakupro.majorsubject_m (
      School_CD
      ,MajorSubject_CD
      ,MajorSubject_Name
      ,StudyPeriod
      ,Remarks
      ,UsageSituation
      ,Changer
      ,UpdateDate
      )VALUES(
      $School_CD
      ,'$MajorSubject_CD'
      ,'$MajorSubject_Name'
      ,'$StudyPeriod'
      ,'$Remarks'
      ,'$UsageSituation'
      ,'$Changer'
      ,'$UpdateDate'); ";
    } else if ($ProcessingType == 2) {
      $SQL = "
      UPDATE
      gakupro.majorsubject_m
      SET
      MajorSubject_Name = '$MajorSubject_Name'
      ,StudyPeriod = '$StudyPeriod'
      ,Remarks = '$Remarks'      
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      School_CD = '$School_CD'
      AND
      MajorSubject_CD = '$MajorSubject_CD';
      ";
    } else if ($ProcessingType == 3 or $ProcessingType == 4) {
      $SQL = "
      UPDATE
      gakupro.majorsubject_m
      SET
      UsageSituation = '$UsageSituation'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      School_CD = '$School_CD'
      AND
      MajorSubject_CD = '$MajorSubject_CD';
      ";
    }
        
    //クラスの中の関数の呼び出し 
    return $DB_Connection->pluralTransaction($SQL);
  }
}
?>