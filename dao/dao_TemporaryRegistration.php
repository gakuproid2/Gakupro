<?php

class dao_TemporaryRegistration {
    
    /*
    function GET_Subcategory_m() {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj = new connect();

        //SQL文の発行  ※メインカテゴリー３は権限区分
        $SQL ="
        SELECT 
        SubCategory_CD 
        ,SubCategory_Name 
        ,UsageFlag
        FROM
        Subcategory_m
        WHERE 
        MainCategory_CD = 3
        and 
        UsageFlag = 1;
        ";

        //クラスの中の関数の呼び出し
        $items = $obj->select($SQL);
        return $items;
    }
    */

    //メール送信時に利用
    function Get_TemporaryMember_M($password) {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();
        
        //SQL文の発行
        $SQL ="
        SELECT
        ID
        ,Password
        ,Mailaddress
        ,Name
        FROM
        TemporaryMember_M
        WHERE
        Password = '$password'; ";
        
        //クラスの中の関数の呼び出し
        $DataTable=$obj->select($SQL);

        foreach($DataTable as $value){ 
            $info = array(
                'ID' => $value['ID'],
                'Password' => $value['Password'],
                'Mailaddress' => $value['Mailaddress']
            );
        }
      
        return $info;
    }

    function Get_Password($password) {
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();
        
        //SQL文の発行
        $SQL ="
        SELECT
        Password
        FROM
        TemporaryMember_M
        WHERE
        Password = $password; ";
        
        //クラスの中の関数の呼び出し
        $DataTable=$obj->select($SQL);
        return $DataTable;
    }

    /*
    function Get_MaxCD(){
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();
    
        //SELECT_sql文の発行
        $SQL = " SELECT
        IFNULL(MAX(Staff_ID),0)+1 AS Max_CD
        FROM
        Staff_m ";
    
        //クラスの中の関数の呼び出し
        $items=$obj->select($SQL);
    
        foreach($items as $item_val){  
          $Max_CD = $item_val['Max_CD'];
        }
    
        return $Max_CD;
    }
    */

    function DataChange($info,$branch){

        $Password = $info['Password'];
        $Mailaddress = $info['Mailaddress'];
    
        //クラスファイルの読み込み
        require_once '../dao/DB_Connection.php';
        //クラスの生成
        $obj=new connect();
        
        if($branch == 1) {
          $SQL = "
          INSERT INTO
          gakupro.TemporaryMember_M (
          Password,
          Mailaddress
          )VALUES(
          '$Password',
          '$Mailaddress'
          ); ";
        } 
            
        //クラスの中の関数の呼び出し
        $items=$obj->plural($SQL);
        //$obj->pluralTransaction($SQL);
        
        return $items;
    }

    function CreatePassword() {

        while (true) {
            $password = rand(1000,9999);
            $DataTable = $this->Get_Password($password);

            if (empty($DataTable)) {
                break;
            }
        }

        return $password;
    }

    //登録チェック処理。チェック後メールを送信する。
    function ChackPassword($info) {

        $password = $info['Password'];
        $DataTable = $this->Get_Password($password);
        if (!empty($DataTable)) {
            //登録成功
            $result = $this->Sendmail($password);
        } else {
            //登録失敗
            $result = 0;
        }

        return $result;
    }

    function Sendmail($password) {
        //データベースからID、パスワード、メールアドレスを取得
        $info = $this->Get_TemporaryMember_M($password);

        $ID = $info['ID'];
        $Password = $info['Password'];
        $Mailaddress = $info['Mailaddress'];
        // IDの隠し方がわからないので一時的この方法で実装中
        $parameter = $ID * $password;
        $URL = "http://localhost/Gakupro/form/frm_TemporaryRegistration_Password.php" . "?ID=$parameter";
        //$URL = $_SERVER;


        // 変数の設定
        $to = $Mailaddress;
        $subject = "学プロ仮登録";
        $text = "
        この度は学プロにご登録いただき誠にありがとうございます。
        ご登録者様のメールアドレスが正しく送受信できることが確認できました。

        以下のURLから登録の続きをよろしくお願いします。
        URLをクリックするとパスワードの入力画面が表示されますので、メール内記載の4桁の数字を入力してください。

        パスワード：$Password
        URL：$URL
        ";

        // メール送信
        if (mb_send_mail($to, $subject, $text)) {
            //送信成功
            return 1;
        } else {
            //送信失敗
            return 0;
        }
    }
}

?>