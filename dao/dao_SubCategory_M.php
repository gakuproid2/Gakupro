<?php

  class dao_SubCategory_M{

    //メインカテゴリーコードを条件にサブカテゴリーを取得する
    function GET_SubCategory_m($MainCategory_CD){

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $DB_Connection = new connect();
      //SQL文の発行
      $SQL = "
      SELECT 
      sub.MainCategory_CD AS MainCategory_CD 
      ,main.MainCategory_Name AS MainCategory_Name 
      ,sub.SubCategory_CD AS SubCategory_CD
      ,sub.SubCategory_Name AS SubCategory_Name
      ,sub.UsageSituation AS UsageSituation
      FROM
      SubCategory_m AS sub
      INNER JOIN
      MainCategory_m AS main
      ON
      sub.MainCategory_CD = main.MainCategory_CD
      WHERE 1 = 1
      AND
      main.UsageSituation = 1    
      ";

      if ($MainCategory_CD > 0) {
        $SQL .= "
        AND
        sub.MainCategory_CD ='$MainCategory_CD'";
      }

      $SQL .= "
      ORDER BY
      sub.MainCategory_CD 
      ,sub.SubCategory_CD
      ";

      $items = $DB_Connection->select($SQL);
      return $items;
    }

    
    function Get_MaxCD($MainCategory_CD){

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $DB_Connection = new connect();
      //SQL文の発行
      $SQL = " 
      SELECT 
      IFNULL(MAX(SubCategory_CD),0)+1 AS Max_CD 
      FROM
      SubCategory_m
      WHERE
      MainCategory_CD = '$MainCategory_CD';";
    
      $items = $DB_Connection->select($SQL);

      foreach ($items as $item_val) {
      $Max_CD = $item_val['Max_CD'];
      }

      return $Max_CD;
    }

    function DataChange($info){

      $MainCategory_CD = $info['MainCategory_CD'];
      $SubCategory_CD = $info['SubCategory_CD'];
      $SubCategory_Name = $info['SubCategory_Name'];
      $UsageSituation = $info['UsageSituation'];
      $Changer = $info['Changer'];
      $UpdateDate = $info['UpdateDate'];

      //クラスファイルの読み込み
      require_once '../dao/DB_Connection.php';
      //クラスの生成
      $DB_Connection = new connect();

      if ($branch == 1) {

        $SQL = " 
        INSERT INTO 
        gakupro.SubCategory_m (
        MainCategory_CD
        ,SubCategory_CD
        ,SubCategory_Name
        ,UsageSituation
        ,Changer
        ,UpdateDate
        )VALUES(
        '$MainCategory_CD'
        ,'$SubCategory_CD'
        ,'$SubCategory_Name'
        ,'$UsageSituation'
        ,'$Changer'
        ,'$UpdateDate'); ";
      } else if ($branch == 2) {

        $SQL = "
        UPDATE 
        gakupro.SubCategory_m 
        SET 
        SubCategory_Name = '$SubCategory_Name'
        ,UsageSituation = '$UsageSituation'
        ,Changer = '$Changer'
        ,UpdateDate = '$UpdateDate'
        WHERE
        MainCategory_CD = '$MainCategory_CD'
        AND
        SubCategory_CD = '$SubCategory_CD';
        ";
      } else if ($branch == 3) {

        $SQL = "
        DELETE FROM 
        gakupro.SubCategory_m 
        WHERE
        MainCategory_CD = '$MainCategory_CD'
        AND
        SubCategory_CD = '$SubCategory_CD' ;
        ";
      }

      //クラスの中の関数の呼び出し
      $Result = $DB_Connection->pluralTransaction($SQL);

      return $Result;
    }
  }
?>