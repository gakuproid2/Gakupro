<?php

class dao_Staff_M {

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

        $ID = $info['ID'];
        $Name = $info['Name'];
        $NameYomi = $info['NameYomi'];
        $NickName = $info['NickName'];
        $LoginID = $info['LoginID'];
        $Password = $info['Password'];
        $Authority = $info['Authority'];
        $UsageSituation = $info['UsageSituation'];
        $Changer = $info['Changer'];
        $UpdateDate = $info['UpdateDate'];
    
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $DB_Connection=new connect();
        
        if($branch == 1) {
          $SQL = "
          INSERT INTO
          gakupro.staff_m (
          Staff_ID
          ,Staff_Name
          ,Staff_NameYomi
          ,NickName
          ,Login_ID
          ,Password
          ,Authority
          ,UsageSituation
          ,Changer
          ,UpdateDate
          )VALUES(
          $ID
          ,'$Name'
          ,'$NameYomi'
          ,'$NickName'
          ,'$LoginID'
          ,'$Password'
          ,'$Authority'
          ,'$UsageSituation'
          ,'$Changer'
          ,'$UpdateDate'
        ); ";
    
        } else if($branch == 2) {
          $SQL = "
          UPDATE 
          gakupro.staff_m 
          SET 
          Staff_Name = '$Name'
          ,Staff_NameYomi = '$NameYomi'
          ,NickName = '$NickName'
          ,Login_ID = '$LoginID'
          ,Password = '$Password'
          ,Authority = '$Authority'
          ,UsageSituation = '$UsageSituation'
          ,Changer = '$Changer'
          ,UpdateDate = '$UpdateDate'
          WHERE
          Staff_ID = $ID;
          ";
    
        } else if($branch == 3) {
          $SQL = "
          DELETE FROM
          gakupro.staff_m
          WHERE
          Staff_ID = $ID;
          ";
    
        }
            
        //クラスの中の関数の呼び出し
        $items=$DB_Connection->plural($SQL);
        
        return $items;
    }
}

?>