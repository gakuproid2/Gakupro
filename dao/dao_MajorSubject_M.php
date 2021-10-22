<?php

class dao_MajorSubject_M {

  function Get_School_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();
    
    //SQL文の発行
    $SQL ="
    SELECT
    School_CD
    ,School_Name
    ,UsageFlag
    FROM
    School_m
    WHERE
    UsageFlag = 1;
    ";
    
    //クラスの中の関数の呼び出し
    $items = $obj->select($SQL);
    return $items;
  }

  function GET_Majorsubject_m($School_CD){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj = new connect();

    //SQL文の発行
    $SQL = "
    SELECT
    majorsub.school_cd AS school_cd
    ,school.school_name AS school_name
    ,majorsub.majorsubject_cd AS majorsubject_cd
    ,majorsub.majorsubject_name AS majorsubject_name
    ,majorsub.studyPeriod AS studyPeriod
    ,majorsub.remarks AS remarks
    ,majorsub.UsageFlag AS UsageFlag
    FROM
    majorsubject_m AS majorsub
    INNER JOIN
    school_m AS school
    ON
    majorsub.School_CD = school.School_CD";

    if ($School_CD > 0) {
      $SQL .="
        WHERE
        majorsub.School_CD ='$School_CD'";
    }

    $SQL .="
    ORDER BY
    majorsub.school_cd 
    ,majorsub.majorsubject_cd
    ";

    //クラスの中の関数の呼び出し
    $items = $obj->select($SQL);
    return $items;
  }


  function Get_MaxCD($School_CD){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

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
    $items=$obj->select($SQL);

    foreach($items as $item_val){  
      $Max_CD = $item_val['Max_CD'];
    }

    return $Max_CD;
  }


  function DataChange($info,$branch){

    $School_CD = $info['School_CD'];
    $MajorSubject_CD = $info['MajorSubject_CD'];
    $MajorSubject_Name = $info['MajorSubject_Name'];
    $StudyPeriod = $info['StudyPeriod'];
    $Remarks = $info['Remarks'];
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
      gakupro.majorsubject_m (
      School_CD
      ,MajorSubject_CD
      ,MajorSubject_Name
      ,StudyPeriod
      ,Remarks
      ,UsageFlag
      ,Changer
      ,UpdateDate
      )VALUES(
      $School_CD
      ,'$MajorSubject_CD'
      ,'$MajorSubject_Name'
      ,'$StudyPeriod'
      ,'$Remarks'
      ,'$UsageFlag'
      ,'$Changer'
      ,'$UpdateDate'); ";
    } else if($branch == 2) {    
      $SQL = "
      UPDATE
      gakupro.majorsubject_m
      SET
      MajorSubject_Name = '$MajorSubject_Name'
      ,StudyPeriod = '$StudyPeriod'
      ,Remarks = '$Remarks'
      ,UsageFlag = '$UsageFlag'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      School_CD = '$School_CD'
      AND
      MajorSubject_CD = '$MajorSubject_CD';
      ";
    } else if($branch == 3) {
      $SQL = "
      DELETE FROM 
      gakupro.majorsubject_m 
      WHERE
      School_CD = '$School_CD'
      AND
      MajorSubject_CD = '$MajorSubject_CD';
      ";
    }
        
    //クラスの中の関数の呼び出し
    $items=$obj->plural($SQL);
    
    return $items;
  }
}
?>