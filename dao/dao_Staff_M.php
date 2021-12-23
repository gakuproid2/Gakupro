<?php

class dao_Staff_M {

  //ログイン時の認証
  function MatchConfirmation($info){

    $Login_ID = $info['Login_ID'];
    $Password = $info['Password'];

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    $SQL = "
    SELECT 
    Staff_ID
    ,Staff_Name
    ,Staff_NameYomi
    ,NickName
    ,Login_ID
    ,Password
    ,Authority
    ,UsageSituation
    FROM
    Staff_M
    WHERE
    Login_ID = $Login_ID
    AND
    Password = $Password ;
    ";
    //クラスの中の関数の呼び出し
    $items = $DB_Connection->plural($SQL);

    return $items;
  }

  function Get_Staff_M($Authority) {
  //クラスファイルの読み込み
  require_once '../dao/DB_Connection.php';
  //クラスの生成
  $DB_Connection=new connect();

  //SQL文の発行
  $SQL ="
    SELECT
    Staff_m.Staff_ID
    ,Staff_m.Staff_Name
    ,Staff_m.Staff_NameYomi
    ,Staff_m.NickName
    ,Staff_m.Login_ID
    ,Staff_m.Password
    ,Staff_m.TEL
    ,Staff_m.MailAddress
    ,Staff_m.Authority
    ,SubCategory_m.SubCategory_Name AS AuthorityInfo
    ,Staff_m.UsageSituation
    FROM
    Staff_m        
    INNER JOIN
    SubCategory_m
    ON
    SubCategory_m.MainCategory_CD = 2
    AND
    SubCategory_m.SubCategory_CD = Staff_m.Authority
    WHERE 1 = 1
  ";

  if ($Authority > 0) {
     $SQL .= "
     AND 
     Staff_m.Authority ='$Authority'";
  }

  $SQL .= "
  ORDER BY 
  Staff_m.Staff_ID;";

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
  IFNULL(MAX(Staff_ID),0)+1 AS Max_CD
  FROM
  Staff_m ";

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

  $Staff_ID = $info['Staff_ID'];
  $Staff_Name = $info['Staff_Name'];
  $Staff_NameYomi = $info['Staff_NameYomi'];
  $NickName = $info['NickName'];
  $Login_ID = $info['Login_ID'];
  $Password = $info['Password'];
  $TEL = $info['TEL'];
  $MailAddress = $info['MailAddress'];
  $Authority = $info['Authority'];
  $Changer = $_SESSION["Staff_ID"];
  $UpdateDate = date("Y-m-d H:i:s");



  if ($ProcessingType == 1) {

    //新規登録時はMaxID取得      
    $Staff_ID = $this->Get_MaxCD();
    
    $SQL = "
    INSERT INTO
    gakupro.staff_m (
    Staff_ID
    ,Staff_Name
    ,Staff_NameYomi
    ,NickName
    ,Login_ID
    ,Password
    ,TEL
    ,MailAddress
    ,Authority
    ,UsageSituation
    ,Changer
    ,UpdateDate
    )VALUES(
    $Staff_ID
    ,'$Staff_Name'
    ,'$Staff_NameYomi'
    ,'$NickName'
    ,'$Login_ID'
    ,'$Password'
    ,'$TEL'
    ,'$MailAddress'
    ,'$Authority'
    ,'$UsageSituation'
    ,'$Changer'
    ,'$UpdateDate'
    ); ";

  } else if ($ProcessingType == 2) {

    $SQL = "
    UPDATE 
    gakupro.staff_m 
    SET 
    Staff_Name = '$Staff_Name'
    ,Staff_NameYomi = '$Staff_NameYomi'
    ,NickName = '$NickName'
    ,Login_ID = '$Login_ID'
    ,Password = '$Password'
    ,TEL = '$TEL'
    ,MailAddress = '$MailAddress'
    ,Authority = '$Authority'  
    ,Changer = '$Changer'
    ,UpdateDate = '$UpdateDate'
    WHERE
    Staff_ID = $Staff_ID;
    ";

  } else if ($ProcessingType == 3 or $ProcessingType == 4) {
  
    $SQL = "
    UPDATE 
    gakupro.staff_m 
    SET 
    UsageSituation = '$UsageSituation'  
    ,Changer = '$Changer'
    ,UpdateDate = '$UpdateDate'
    WHERE
    Staff_ID = $Staff_ID;
    ";

  }

  //クラスの中の関数の呼び出し
  $items=$DB_Connection->plural($SQL);

  return $items;
  }
  }

?>