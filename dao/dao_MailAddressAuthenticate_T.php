<?php

class dao_MailAddressAuthenticate_T{

    function DataInsert($Info){            

        //KetCodeは操作日のMaxのkeyCodeをセットする
        //例：操作日2222/12/31の場合
        //2222/12/31のデータのKeyCodeを取得し、MaxのkeyCode + 1したを0埋め3桁にする
        //22221231001、22221231002、22221231003など            
        $MaxKeyCode = $this->GetMaxKeyCode_OnTheDay();
        $Key_Code = date("Ymd") . str_pad($MaxKeyCode, 3, 0, STR_PAD_LEFT);

        $Password = $Info['Password'];
        $MailAddress = $Info['MailAddress'];
        $FullName = $Info['LastName'].'　'.$Info['Name'];  
        
        
        
        $CreateDateTime = date("Y-m-d H:i:s");
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();
                    
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
        $Judge=$obj->pluralTransaction($SQL);   
        
        if ($Judge) {
            return $Key_Code;
        } else {
            return false;
        }           
    }
            
    function GetMaxKeyCode_OnTheDay(){
        
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();
                    
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
        $items=$obj->plural($SQL);   
        
        $MaxCD = 0;
        foreach($items as $item_val){  
            $MaxCD = $item_val['MaxCD'];
        }               
        return $MaxCD;
    }        
            
    function GetMailAddressAuthenticateInfo($Key_Code){
        
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();                        
        
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
        $items=$obj->plural($SQL); 
                
        return $items;
    }   
    
}
