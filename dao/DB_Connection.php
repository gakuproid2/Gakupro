<?php
  class connect {
    //定数の宣言
    const DB_NAME='gakupro';
    const HOST='localhost';
    const UTF='utf8';
    const USER='root';
    const PASS='root';
    //データベースに接続する関数
    function pdo(){
      /*phpのバージョンが5.3.6よりも古い場合はcharset=".self::UTFが必要無くなり、array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF')が必要になり、5.3.6以上の場合は必要ないがcharset=".self::UTFは必要になる。*/
      $dsn="mysql:dbname=".self::DB_NAME.";host=".self::HOST.";charset=".self::UTF;
      $user=self::USER;
      $pass=self::PASS;
      try{
      $pdo=new PDO($dsn,$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF));
      }catch(Exception $e){
      echo 'error' .$e->getMesseage;
      die();
      }
      //エラーを表示してくれる。
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
      return $pdo;
    }

    //SELECT文のときに使用する関数。
    function select($sql){
      $Connection_Info=$this->pdo();
      $stmt=$Connection_Info->query($sql);
      $items=$stmt->fetchAll(PDO::FETCH_ASSOC);
      return $items;
    }

    //INSERT,UPDATE,DELETE文の時に使用する関数。
    function plural($sql){
      $Connection_Info=$this->pdo();
      $stmt=$Connection_Info->prepare($sql);
      $stmt->execute();
      return $stmt;
    }

    //トランザクションありのINSERT,UPDATE,DELETE文の時に使用する関数。
    function pluralTransaction($sql){
      $Connection_Info=$this->pdo();
      
      try {
        $Connection_Info->beginTransaction();
        $Connection_Info->exec($sql);
        $Connection_Info->commit();
      } catch (Exception $e) {
        $Connection_Info->rollBack();
        echo "失敗しました。" . $e->getMessage();
      }
      
    }
  }
?>