<?php

class dao_Company_M{
  
  function Get_Company_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();
    
    //SQL文の発行
    $SQL ="
    SELECT
    Company_ID
    ,Company_Name
    ,TEL1
    ,TEL2
    ,Address1
    ,Address2
    ,URL
    ,MailAddress
    ,Login_ID
    ,Password
    ,RegisteredPerson
    ,RegisteredDate
    ,Changer
    ,UpdateDate  
    FROM
    Company_M    
    ORDER BY
    Company_M.Company_ID;
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

    //SELECT_sql文の発行
    $SQL = " SELECT
    IFNULL(MAX(Company_ID),0)+1 AS Max_ID
    FROM
    Company_M ";

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

    $Company_ID = $info['Company_ID'];    
    $Company_Name = $info['Company_Name'];
    $TEL1 = $info['TEL1'];
    $TEL2 = $info['TEL2'];
    $Address1 = $info['Address1']; 
    $Address2 = $info['Address2']; 
    $URL = $info['URL']; 
    $MailAddress = $info['MailAddress']; 
    $Login_ID = $info['Login_ID']; 
    $Password = $info['Password']; 
    $RegisteredPerson = 99; 
    $RegisteredDate = date("Y-m-d H:i:s");    

    $Changer = $_SESSION["Staff_ID"];
    $UpdateDate = date("Y-m-d H:i:s");  
    
    if ($ProcessingType == 1) {

      //新規登録時はMaxID取得      
      $Company_ID = $this->Get_MaxID();

      $SQL = "
      INSERT INTO
      gakupro.Company_M (
      Company_ID
      ,Company_Name
      ,TEL1
      ,TEL2
      ,Address1
      ,Address2
      ,URL
      ,MailAddress
      ,Login_ID
      ,Password
      ,RegisteredPerson
      ,RegisteredDate    
      )VALUES(
      '$Company_ID'
      ,'$Company_Name'
      ,'$TEL1'
      ,'$TEL2'
      ,'$Address1'
      ,'$Address2'
      ,'$URL'
      ,'$MailAddress'
      ,'$Login_ID'
      ,'$Password'
      ,'$RegisteredPerson'
      ,'$RegisteredDate'     
    ); ";

    } else if ($ProcessingType == 2) {
      $SQL = "
      UPDATE 
      gakupro.Company_M 
      SET      
       Company_Name = '$Company_Name'
      ,TEL1 = '$TEL1'
      ,TEL2 = '$TEL2'      
      ,Address = '$Address1'
      ,Address = '$Address2'
      ,URL = '$URL'
      ,MailAddress = '$MailAddress'
      ,Login_ID = '$Login_ID'
      ,Password = '$Password'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      Company_ID = $Company_ID;
      ";

    } else if ($ProcessingType == 3 or $ProcessingType == 4) {
      $SQL = "
      UPDATE 
      gakupro.Company_M 
      SET 
      UsageSituation = '$UsageSituation'  
      ,Changer = '$Changer' 
      ,UpdateDate = '$UpdateDate'
      WHERE
      Company_ID = $Company_ID;
      ";
    }
        
    //クラスの中の関数の呼び出し
    return $DB_Connection->pluralTransaction($SQL);    
  }
}
?>