<?php

  class dao_Member_M {

    function Get_Member_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    //SELECT_SQL文の発行
    $SQL ="
    SELECT
    Member_m.Member_ID 
    ,Member_m.Name 
    ,Member_m.Furigana 
    ,Member_m.Birthday 
    ,Member_m.School_CD 
    ,School_m.School_Name AS School_Name
    ,Member_m.MajorSubject_CD 
    ,majorsubject_m.MajorSubject_Name AS MajorSubject_Name
    ,Member_m.TEL 
    ,Member_m.EmergencyContact 
    ,Member_m.Remarks 
    ,Member_m.Changer 
    ,staff_m.Staff_Name AS ChangerName
    ,Member_m.UpdateDate 
    FROM
    Member_m
    LEFT JOIN
    	(SELECT 
          School_CD
         ,School_Name         
         FROM
         School_m         
        )AS School_m
    ON
    Member_m.School_CD = School_m.School_CD
    LEFT JOIN
    	(SELECT 
          School_CD
         ,MajorSubject_CD         
         ,MajorSubject_Name
         FROM
         majorsubject_m         
        )AS majorsubject_m
    ON
    Member_m.School_CD = majorsubject_m.School_CD
    AND
    Member_m.MajorSubject_CD = majorsubject_m.MajorSubject_CD
    LEFT JOIN
    	(SELECT 
          Staff_ID
         ,Staff_Name         
         FROM
         staff_m         
        )AS staff_m
    ON
    Member_m.Changer = staff_m.Staff_ID
    ;
    ";

    //クラスの中の関数の呼び出し
    $DataTable=$obj->select($SQL);
    return $DataTable;
    }


  function Get_MaxID(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    //SELECT_SQL文の発行
    $SQL =  " 
    SELECT 
    IFNULL(MAX(Member_ID),0)+1 AS Max_ID
    FROM
    Member_m ";

    //クラスの中の関数の呼び出し
    $items=$obj->select($SQL);

    foreach($items as $item_val){  
      $Max_ID = $item_val['Max_ID'];
    } 
    
    return $Max_ID;
    }

    

    function DataChange($info,$branch){

    $Member_ID = $info['Member_ID'];
    $Name = $info['Name'];
    $Furigana = $info['Furigana'];
    $Birthday = $info['Birthday'];
    $School_CD = $info['School_CD'];  
    $MajorSubject_CD = $info['MajorSubject_CD'];  
    $TEL = $info['TEL'];  
    $EmergencyContact = $info['EmergencyContact'];  
    $Remarks = $info['Remarks'];  
    $Changer = $info['Changer'];
    $UpdateDate = $info['UpdateDate'];

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    if($branch == 1) {

      $SQL = "
      INSERT INTO 
      gakupro.Member_M (
      Member_ID 
      ,Name 
      ,Furigana 
      ,Birthday
      ,School_CD
      ,MajorSubject_CD
      ,TEL
      ,EmergencyContact
      ,Remarks
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$Member_ID'
      ,'$Name'
      ,'$Furigana'
      ,'$Birthday'
      ,'$School_CD'      
      ,'$MajorSubject_CD'
      ,'$TEL'
      ,'$EmergencyContact'
      ,'$Remarks'
      ,'$Changer'
      ,'$UpdateDate'

      ); ";

    } else if($branch == 2) {

      $SQL = "
      UPDATE 
      gakupro.Member_M 
      SET 
      Member_ID = '$Member_ID'
      ,Name = '$Name'
      ,Furigana = '$Furigana'
      ,Birthday = '$Birthday'
      ,School_CD = '$School_CD'
      ,MajorSubject_CD = '$MajorSubject_CD'
      ,TEL = '$TEL'
      ,EmergencyContact = '$EmergencyContact'
      ,Remarks = '$Remarks'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      Member_ID = $Member_ID;
      ";

    } else if($branch == 3) {

      $SQL = "
      DELETE FROM
      gakupro.Member_M 
      WHERE
      Member_ID = $Member_ID;
      ";

    }

    //クラスの中の関数の呼び出し
    $items=$obj->plural($SQL);

    return $items;
    }
  }
?>