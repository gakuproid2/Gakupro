<?php

class dao_DetailedTemporaryRegistration {

    function Get_TemporaryMember_M($ID) {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $DB_Connection=new connect();

        $SQL ="
        SELECT
        *
        FROM
        TemporaryMember_M
        WHERE
        ID = $ID
        ";

        //クラスの中の関数の呼び出し
        $items = $DB_Connection->select($SQL);
        return $items;
    }

    
}

?>