<?php
  class dao_Login {

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
  }
?>