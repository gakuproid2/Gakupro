<?php

  class dao_Screen_M {

    function Get_Screen_M($Authority){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection=new connect();

    //SELECT_SQL文の発行
    $SQL ="
    SELECT
    Screen_m.Screen_ID 
    ,Screen_m.Screen_Name
    ,Screen_m.Screen_Path
    ,Screen_m.Authority
    ,CONCAT(SubCategory_m.SubCategory_Name,'以上') AS AuthorityInfo
    ,Screen_m.UsageSituation
    ,staff_m.Staff_Name AS ChangerName
    ,Screen_m.UpdateDate
    FROM
    Screen_m
    LEFT JOIN
    	(SELECT 
         MainCategory_CD
         ,SubCategory_CD
         ,SubCategory_Name
         FROM
         SubCategory_m
         WHERE
         MainCategory_CD = 2
        )AS SubCategory_m
     ON
     Screen_m.Authority = SubCategory_m.SubCategory_CD
     LEFT JOIN
    	(SELECT 
          Staff_ID
         ,Staff_Name         
         FROM
         staff_m         
        )AS staff_m
     ON
     Screen_m.Changer = staff_m.Staff_ID
     WHERE 1 = 1     
     ";

    if ($Authority > 0) {      
      $SQL .= "
      AND
      Screen_m.Authority >=$Authority";
    }
   
    $SQL .= "
    ORDER BY
    Screen_m.Screen_ID       
    ";
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
    IFNULL(MAX(Screen_ID),0)+1 AS Max_CD
    FROM
    Screen_m ";

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

    $Screen_ID = $info['Screen_ID'];
    $Screen_Name = $info['Screen_Name'];
    $Screen_Path = $info['Screen_Path'];
    $Authority = $info['Authority'];
    $Changer = $_SESSION["Staff_ID"];
    $UpdateDate = date("Y-m-d H:i:s");

    if ($ProcessingType == 1) {

      //新規登録時はMaxID取得      
      $SubCategory_CD = $this->Get_MaxCD();

      $SQL = "
      INSERT INTO 
      gakupro.Screen_M (
      Screen_ID 
      ,Screen_Name 
      ,Screen_Path 
      ,Authority      
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$Screen_ID'
      ,'$Screen_Name'
      ,'$Screen_Path'
      ,'$Authority'      
      ,'$Changer'
      ,'$UpdateDate'

      ); ";

    } else if ($ProcessingType == 2) {

      $SQL = "
      UPDATE 
      gakupro.Screen_M 
      SET 
      Screen_Name = '$Screen_Name'
      ,Screen_Path = '$Screen_Path'
      ,Authority = '$Authority'      
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      Screen_ID = $Screen_ID;
      ";

    } else if ($ProcessingType == 3 or $ProcessingType == 4) {

      $SQL = "
      UPDATE 
      gakupro.Screen_M 
      SET 
      UsageSituation = '$UsageSituation'      
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      Screen_ID = $Screen_ID;
      ";

    }

    //クラスの中の関数の呼び出し
    return $DB_Connection->pluralTransaction($SQL);
   
    }
  }
?>