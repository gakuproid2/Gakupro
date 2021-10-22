<?php

class dao_TemporaryRegistration_Password {

    function Chackdata($ID, $Password) {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();

        //引数をもとに、二つの条件で出力されるデータがあるか確認する。
        $SQL ="
        SELECT
        *
        FROM
        TemporaryMember_M
        WHERE
        ID = $ID
        and
        Password = $Password;
        ";

        //クラスの中の関数の呼び出し
        $items = $obj->select($SQL);
        return $items;
    }
}

?>