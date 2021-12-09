<?php

class dao_MailAddressAuthenticate_T
{

    function DataInsert($Info)
    {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $DB_Connection = new connect();

        $Key_Code = $Info['Key_Code'];

        $Password = $Info['Password'];
        $MailAddress = $Info['MailAddress'];
        $FullName = $Info['FullName'];
        $CreateDateTime = date("Y-m-d H:i:s");    

        $SQL = "
            INSERT INTO
            gakupro.mailaddressauthenticate_t (
            Key_Code,
            Password,
            MailAddress,
            Name,
            CreateDateTime,
            AuthenticationsCount
            )VALUES(
            '$Key_Code',
            '$Password',
            '$MailAddress',
            '$FullName',
            '$CreateDateTime',
            0
            ); 
        ";

        //クラスの中の関数の呼び出し
        $Judge = $DB_Connection->pluralTransaction($SQL);

        return $Judge;
    }

    function GetMaxKeyCode_OnTheDay()
    {

        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $DB_Connection = new connect();

        $StartDateTime = date("Y-m-d 00:00:01");
        $EndeDateTime = date("Y-m-d 23:59:59");

        $SQL = "
        SELECT
        IFNULL(MAX(RIGHT(Key_Code,3)),0) + 1 AS MaxCD
        FROM
        mailaddressauthenticate_t
        WHERE
        CreateDateTime 
        BETWEEN 
        '$StartDateTime'
        AND 
        '$EndeDateTime'
        ;
        ";
        //クラスの中の関数の呼び出し
        $items = $DB_Connection->plural($SQL);

        $MaxCD = 0;
        foreach ($items as $item_val) {
            $MaxCD = $item_val['MaxCD'];
        }

        //KetCodeは操作日のMaxのkeyCodeをセットする
        //例：操作日2222/12/31の場合
        //2222/12/31のデータのKeyCodeを取得し、MaxのkeyCode + 1したを0埋め3桁にする
        //22221231001、22221231002、22221231003など  
        $KeyCode = date("Ymd") . str_pad($MaxCD, 3, 0, STR_PAD_LEFT);
        return $KeyCode;
    }

    function GetMailAddressAuthenticateInfo($Key_Code)
    {

        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $DB_Connection = new connect();

        $SQL = "
        SELECT
        ID
        ,Key_Code
        ,Password
        ,MailAddress
        ,Name
        ,CreateDateTime            
        FROM
        mailaddressauthenticate_t
        WHERE
        Key_Code = $Key_Code           
        ;
        ";
        //クラスの中の関数の呼び出し
        $items = $DB_Connection->plural($SQL);

        return $items;
    }
}
