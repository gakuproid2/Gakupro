<?php

  class dao_MainCategory_M {

    function Get_MainCategory_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_SQL文の発行
    $SQL ="
    SELECT
    MainCategory_CD
    ,MainCategory_Name 
    ,UsageSituation 
    FROM
    MainCategory_m; ";

    //クラスの中の関数の呼び出し
    $DataTable=$DB_Connection->select($SQL);
    return $DataTable;
    }


  function Get_MaxCD(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_SQL文の発行
    $SQL =  " 
    SELECT 
    IFNULL(MAX(MainCategory_CD),0)+1 AS Max_CD
    FROM
    MainCategory_m ";

    //クラスの中の関数の呼び出し
    $items=$DB_Connection->select($SQL);

    foreach($items as $item_val){  
      $Max_CD = $item_val['Max_CD'];
    } 
    
    return $Max_CD;
    }

    function DataChange($info){

    //1 = 登録、2 = 更新、3 = 利用可能に更新、 4 = 利用不可に更新
    $ProcessingType = $info['ProcessingType'];

    $MainCategory_CD = $info['MainCategory_CD'];    
    $MainCategory_Name = $info['MainCategory_Name'];    
    $Changer = $_SESSION["Staff_ID"];
    $UpdateDate = date("Y-m-d H:i:s");

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    if($ProcessingType == 1) {

      $UsageSituation = 1;
      $MainCategory_CD = $this->Get_MaxCD();

      $SQL = 
      "
      INSERT INTO 
      gakupro.MainCategory_m (
      MainCategory_CD 
      ,MainCategory_Name 
      ,UsageSituation 
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$MainCategory_CD'
      ,'$MainCategory_Name'
      ,'$UsageSituation'
      ,'$Changer'
      ,'$UpdateDate'
      ); 
      ";

    } else if($ProcessingType == 2) {

      $SQL = "
      UPDATE 
      gakupro.MainCategory_m 
      SET 
      MainCategory_Name = '$MainCategory_Name'      
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      MainCategory_CD = $MainCategory_CD
      ;"
      ;

    } else if($ProcessingType == 3 or $ProcessingType == 4) {

      if($ProcessingType == 3){
        $UsageSituation=1;
      }else{
        $UsageSituation=2;
      }
      $SQL = "
      UPDATE 
      gakupro.MainCategory_m 
      SET     
      UsageSituation = '$UsageSituation'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      MainCategory_CD = $MainCategory_CD;"
      ;
    }

    //クラスの中の関数の呼び出し true or false
    return $DB_Connection->pluralTransaction($SQL);
    }
  }
?>