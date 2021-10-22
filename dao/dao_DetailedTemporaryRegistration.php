<?php

class dao_DetailedTemporaryRegistration {

    function Get_TemporaryMember_M($ID) {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();

        $SQL ="
        SELECT
        *
        FROM
        TemporaryMember_M
        WHERE
        ID = $ID
        ";

        //クラスの中の関数の呼び出し
        $items = $obj->select($SQL);
        return $items;
    }

    
}

?>