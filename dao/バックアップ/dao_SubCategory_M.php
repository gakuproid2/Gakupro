<?php

  class dao_SubCategory_M{

    function GET_Maincategory_m(){

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $obj = new connect();
      //SQL文の発行  
      $SQL = "
      SELECT 
      MainCategory_CD 
      ,MainCategory_Name 
      ,UsageFlag
      FROM
      Maincategory_m
      WHERE UsageFlag = 1;
      ";

      //クラスの中の関数の呼び出し
      $items = $obj->select($SQL);
      return $items;
    }

    //メインカテゴリーコードを条件にサブカテゴリーを取得する
    function GET_Subcategory_m($MainCategory_CD){

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $obj = new connect();
      //SQL文の発行
      $SQL = "
      SELECT 
      sub.maincategory_cd AS maincategory_cd 
      ,main.MainCategory_name AS MainCategory_name 
      ,sub.subcategory_cd AS subcategory_cd
      ,sub.subcategory_name AS subcategory_name
      ,sub.UsageFlag AS UsageFlag
      FROM
      subcategory_m AS sub
      INNER JOIN
      maincategory_m AS main
      ON
      sub.MainCategory_CD = main.MainCategory_CD
      WHERE 1 = 1
      AND
      main.UsageFlag = 1    
      ";

      if ($MainCategory_CD > 0) {
        $SQL .= "
        AND
        sub.MainCategory_CD ='$MainCategory_CD'";
      }

      $SQL .= "
      ORDER BY
      sub.MainCategory_CD 
      ,sub.subcategory_CD
      ";

      $items = $obj->select($SQL);
      return $items;
    }

    
    function Get_MaxCD($MainCategory_CD){

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $obj = new connect();
      //SQL文の発行
      $SQL = " 
      SELECT 
      IFNULL(MAX(SubCategory_CD),0)+1 AS Max_CD 
      FROM
      Subcategory_m
      WHERE
      MainCategory_CD = '$MainCategory_CD';";
    
      $items = $obj->select($SQL);

      foreach ($items as $item_val) {
      $Max_CD = $item_val['Max_CD'];
      }

      return $Max_CD;
    }

    function DataChange($info, $branch){

      $MainCategory_CD = $info['MainCategory_CD'];
      $SubCategory_CD = $info['SubCategory_CD'];
      $SubCategory_Name = $info['SubCategory_Name'];
      $UsageFlag = $info['UsageFlag'];
      $Changer = $info['Changer'];
      $UpdateDate = $info['UpdateDate'];

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $obj = new connect();

      if ($branch == 1) {

        $SQL = " 
        INSERT INTO 
        gakupro.subcategory_m (
        MainCategory_CD
        ,SubCategory_CD
        ,SubCategory_Name
        ,UsageFlag
        ,Changer
        ,UpdateDate
        )VALUES(
        '$MainCategory_CD'
        ,'$SubCategory_CD'
        ,'$SubCategory_Name'
        ,'$UsageFlag'
        ,'$Changer'
        ,'$UpdateDate'); ";
      } else if ($branch == 2) {

        $SQL = "
        UPDATE 
        gakupro.subcategory_m 
        SET 
        SubCategory_Name = '$SubCategory_Name'
        ,UsageFlag = '$UsageFlag'
        ,Changer = '$Changer'
        ,UpdateDate = '$UpdateDate'
        WHERE
        MainCategory_CD = '$MainCategory_CD'
        AND
        SubCategory_CD = '$SubCategory_CD';
        ";
      } else if ($branch == 2) {

        $SQL = "
        DELETE FROM 
        gakupro.subcategory_m 
        WHERE
        MainCategory_CD = '$MainCategory_CD'
        AND
        SubCategory_CD = '$SubCategory_CD' ;
        ";
      }

      //クラスの中の関数の呼び出し
      $items = $obj->plural($SQL);

      return $items;
    }
  }
?>