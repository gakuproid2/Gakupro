<?php

  class dao_Screen_M {

    function Get_Screen_M(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

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

    ;
    ";

    //クラスの中の関数の呼び出し
    $DataTable=$obj->select($SQL);
    return $DataTable;
    }


  function Get_MaxCD(){
    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    //SELECT_SQL文の発行
    $SQL =  " 
    SELECT 
    IFNULL(MAX(Screen_ID),0)+1 AS Max_CD
    FROM
    Screen_m ";

    //クラスの中の関数の呼び出し
    $items=$obj->select($SQL);

    foreach($items as $item_val){  
      $Max_CD = $item_val['Max_CD'];
    } 
    
    return $Max_CD;
    }

    function Get_Authority(){
       //クラスファイルの読み込み
       require_once '../dao/DB_Connection.php';
       //クラスの生成
       $obj = new connect();
       //SQL文の発行  
       $SQL = "
       SELECT 
       MainCategory_CD 
       ,SubCategory_CD 
       ,SubCategory_Name 
       ,UsageSituation
       FROM
       SubCategory_m
       WHERE UsageSituation = 1
       AND
       MainCategory_CD = 2
       ;
       ";
 
       //クラスの中の関数の呼び出し
       $items = $obj->select($SQL);
       return $items;
      }

    function DataChange($info,$branch){

    $Screen_ID = $info['Screen_ID'];
    $Screen_Name = $info['Screen_Name'];
    $Screen_Path = $info['Screen_Path'];
    $Authority = $info['Authority'];
    $UsageSituation = $info['UsageSituation'];    
    $Changer = $info['Changer'];
    $UpdateDate = $info['UpdateDate'];

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $obj=new connect();

    if($branch == 1) {

      $SQL = "
      INSERT INTO 
      gakupro.Screen_M (
      Screen_ID 
      ,Screen_Name 
      ,Screen_Path 
      ,Authority
      ,UsageSituation
      ,Changer
      ,UpdateDate
      )VALUES( 
      '$Screen_ID'
      ,'$Screen_Name'
      ,'$Screen_Path'
      ,'$Authority'
      ,'$UsageSituation'
      ,'$Changer'
      ,'$UpdateDate'

      ); ";

    } else if($branch == 2) {

      $SQL = "
      UPDATE 
      gakupro.Screen_M 
      SET 
      Screen_Name = '$Screen_Name'
      ,Screen_Path = '$Screen_Path'
      ,Authority = '$Authority'
      ,UsageSituation = '$UsageSituation'
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      Screen_ID = $Screen_ID;
      ";

    } else if($branch == 3) {

      $SQL = "
      DELETE FROM
      gakupro.Screen_M 
      WHERE
      Screen_ID = $Screen_ID;
      ";

    }

    //クラスの中の関数の呼び出し
    $items=$obj->plural($SQL);

    return $items;
    }
  }
?>