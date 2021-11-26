<?php

class dao_SubCategory_M
{

  //メインカテゴリーコードを条件にサブカテゴリーを取得する
  function GET_SubCategory_m($MainCategory_CD)
  {
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


  function Get_MaxCD($MainCategory_CD)
  {

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

  function DataChange($info)
  {
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

    $MainCategory_CD = $info['MainCategory_CD'];
    $SubCategory_CD = $info['SubCategory_CD'];
    $SubCategory_Name = $info['SubCategory_Name'];
    $Changer = $_SESSION["Staff_ID"];
    $UpdateDate = date("Y-m-d H:i:s");


    if ($ProcessingType == 1) {

      //新規登録時はMaxID取得      
      $SubCategory_CD = $this->Get_MaxCD($MainCategory_CD);

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
    } else if ($ProcessingType == 2) {

      $SQL = "
        UPDATE 
        gakupro.SubCategory_m 
        SET 
        SubCategory_Name = '$SubCategory_Name'        
        ,Changer = '$Changer'
        ,UpdateDate = '$UpdateDate'
        WHERE
        MainCategory_CD = '$MainCategory_CD'
        AND
        SubCategory_CD = '$SubCategory_CD';
        ";
    } else if ($ProcessingType == 3 or $ProcessingType == 4) {

      $SQL = "
      UPDATE 
      gakupro.SubCategory_m 
      SET 
      UsageSituation = '$UsageSituation'        
      ,Changer = '$Changer'
      ,UpdateDate = '$UpdateDate'
      WHERE
      MainCategory_CD = '$MainCategory_CD'
      AND
      SubCategory_CD = '$SubCategory_CD';
      ";
    }

    //クラスの中の関数の呼び出し true or false
    return $DB_Connection->pluralTransaction($SQL);
  }
}
