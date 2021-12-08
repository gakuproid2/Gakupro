<?php

  class dao_Member_M {

    function Get_Member_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_SQL文の発行
    $SQL ="
    SELECT
    Member_m.Member_ID 
    ,Member_m.Member_Name 
    ,Member_m.Member_NameYomi 
    ,Member_m.Birthday 
    ,Member_m.TEL
    ,Member_m.MailAddress
    ,Member_m.School_CD 
    ,School_m.School_Division AS School_Division
    ,School_m.School_Name AS School_Name
    ,Member_m.MajorSubject_CD 
    ,majorsubject_m.MajorSubject_Name AS MajorSubject_Name     
    ,Member_m.EmergencyContactRelations 
    ,Member_m.EmergencyContactTEL
    ,Member_m.AdmissionYearMonth 
    ,Member_m.GraduationYearMonth 
    ,Member_m.Login_ID 
    ,Member_m.Password 
    ,Member_m.Remarks 
    ,Member_m.RegistrationStatus 
    ,SubCategory_m.SubCategory_Name AS RegistrationStatusName
    ,Member_m.RegisteredPerson 
    ,Member_m.RegisteredDate 
    ,Member_m.Changer 
    ,staff_m.Staff_Name AS ChangerName
    ,Member_m.UpdateDate 
    FROM
    Member_m

    LEFT JOIN
    	(SELECT 
        School_CD
        ,School_Name
        ,School_Division        
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

    LEFT JOIN
    	(SELECT 
        MainCategory_CD
        ,SubCategory_CD
        ,SubCategory_Name
        FROM
        SubCategory_m
        WHERE
        MainCategory_CD = 4
      )AS SubCategory_m
    ON
    Member_m.RegistrationStatus = SubCategory_m.SubCategory_CD

    ;
    ";

    //クラスの中の関数の呼び出し
    $DataTable=$DB_Connection->select($SQL);
    return $DataTable;
    }


  function Get_MaxID(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_SQL文の発行
    $SQL =  " 
    SELECT 
    IFNULL(MAX(Member_ID),0)+1 AS Max_ID
    FROM
    Member_m ";

    //クラスの中の関数の呼び出し
    $items=$DB_Connection->select($SQL);

    foreach($items as $item_val){  
      $Max_ID = $item_val['Max_ID'];
    } 
    
    return $Max_ID;
    }   

    function DataChange($info){
    
      
      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $DB_Connection=new connect();

      $Member_ID = $this->Get_MaxID();
      $Member_Name = $info['Member_Name'];
      $Member_NameYomi = $info['Member_NameYomi'];
      $Birthday = $info['Birthday'];     
      $TEL = $info['TEL'];  
      $MailAddress = $info['MailAddress'];  
      $School_CD = $info['School_CD'];  
      $MajorSubject_CD = $info['MajorSubject_CD'];  
      $AdmissionYearMonth = $info['AdmissionYearMonth'];  
      $GraduationYearMonth = $info['GraduationYearMonth'];     
      $Login_ID = $info['Login_ID'];  
      $Password = $info['Password'];  
      $EmergencyContactRelations = $info['EmergencyContactRelations'];  
      $EmergencyContactTEL = $info['EmergencyContactTEL'];  
      $Remarks = $info['Remarks'];  
      $RegistrationStatus = $info['RegistrationStatus'];  
     
      
      //操作者(社員ID)
      $Operator = $info['Operator'];  

      $RegisteredPerson = $Operator;  
      $RegisteredDate = $Now;
      $Changer = $Operator;  
      $UpdateDate = $Now;


    if($branch == 1) {

      $SQL = "
      INSERT INTO 
      gakupro.Member_M (
      Member_ID 
      ,Member_Name 
      ,Member_NameYomi 
      ,Birthday
      ,TEL
      ,MailAddress
      ,School_CD
      ,MajorSubject_CD     
      ,AdmissionYearMonth
      ,GraduationYearMonth
      ,Login_ID
      ,Password
      ,EmergencyContactRelations
      ,EmergencyContactTEL
      ,Remarks
      ,RegistrationStatus
      ,RegisteredPerson
      ,RegisteredDate
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$Member_ID'
      ,'$Member_Name'
      ,'$Member_NameYomi'
      ,'$Birthday'
      ,'$TEL'
      ,'$MailAddress'
      ,'$School_CD'      
      ,'$MajorSubject_CD'     
      ,'$AdmissionYearMonth'
      ,'$GraduationYearMonth'
      ,'$Login_ID'
      ,'$Password'
      ,'$EmergencyContactRelations'
      ,'$EmergencyContactTEL'
      ,'$Remarks'
      ,'$RegistrationStatus'
      ,'$RegisteredPerson'
      ,'$RegisteredDate'
      ,'$Changer'
      ,'$UpdateDate'

      ); ";

    } else if($branch == 2) {

      $Member_ID = $info['Member_ID'];

      $SQL = "
      UPDATE 
      gakupro.Member_M 
      SET 
      Member_Name = '$Member_Name'
      ,Member_NameYomi = '$Member_NameYomi'
      ,Birthday = '$Birthday'
      ,TEL = '$TEL'
      ,MailAddress = '$MailAddress'
      ,School_CD = '$School_CD'
      ,MajorSubject_CD = '$MajorSubject_CD'
      ,AdmissionYearMonth = '$AdmissionYearMonth'
      ,GraduationYearMonth = '$GraduationYearMonth'
      ,Login_ID = '$Login_ID'
      ,Password = '$Password'
      ,EmergencyContactRelations = '$EmergencyContactRelations'
      ,Remarks = '$Remarks'
      ,RegistrationStatus = '$RegistrationStatus'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      Member_ID = $Member_ID;
      ";
    }

    //クラスの中の関数の呼び出し
    $Result=$DB_Connection->pluralTransaction($SQL);

    return $items;
    }

    //仮登録処理
    function TemporaryRegistration($info){
      
      $Now = date("Y-m-d H:i:s");  
      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $DB_Connection=new connect();

      $Member_ID = $this->Get_MaxID();
      $Member_Name = $info['Member_Name'];
      $Member_NameYomi = $info['Member_NameYomi'];
      $Birthday = $info['Birthday'];
      $School_CD = $info['School_CD'];  
      $MajorSubject_CD = $info['MajorSubject_CD'];  
      $TEL = $info['TEL'];  
      $MailAddress = $info['MailAddress'];  
      $AdmissionYearMonth = $info['AdmissionYearMonth'];  
      $GraduationYearMonth = $info['GraduationYearMonth'];  

      //仮登録時はステータスは1(1=仮登録)固定
      $RegistrationStatus = 1;  
      $RegisteredPerson = 99;  
      $RegisteredDate = $Now;
      $Changer = 99;  
      $UpdateDate = $Now;

      $SQL = "
      INSERT INTO 
      gakupro.Member_M (
      Member_ID 
      ,Member_Name 
      ,Member_NameYomi 
      ,Birthday
      ,School_CD
      ,MajorSubject_CD
      ,TEL
      ,MailAddress
      ,AdmissionYearMonth
      ,GraduationYearMonth
      ,RegistrationStatus
      ,RegisteredPerson
      ,RegisteredDate
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$Member_ID'
      ,'$Member_Name'
      ,'$Member_NameYomi'
      ,'$Birthday'
      ,'$School_CD'      
      ,'$MajorSubject_CD'
      ,'$TEL'
      ,'$MailAddress'
      ,'$AdmissionYearMonth'
      ,'$GraduationYearMonth'
      ,'$RegistrationStatus'
      ,'$RegisteredPerson'
      ,'$RegisteredDate'
      ,'$Changer'
      ,'$UpdateDate'
      );"
      ;
       //クラスの中の関数の呼び出し
      $Result=$DB_Connection->pluralTransaction($SQL);

      //返却用変数
      $items = '';
      if($Result == true) {
        $items = $Member_ID;
      } else{
        $items = false;
      }
      return $items;

    }
  }
?>