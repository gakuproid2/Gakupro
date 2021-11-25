<?php
class dao_ImageGetResult
{

  function PasswordCheck($info)
  {

    //クラスファイルの読み込み
    require_once '../dao/DB_Connection.php';
    //クラスの生成
    $DB_Connection = new connect();

    $Key_Code = $info['Key_Code'];
    $Password = $info['Password'];


    //SELECT_SQL文の発行
    $SQL = "
      SELECT
      Key_Code
      ,Password      
      FROM
      ImageGet_T
      WHERE
      Key_Code = '$Key_Code'
      AND
      Password = '$Password'
      ; ";

    //クラスの中の関数の呼び出し
    $DataTable = $DB_Connection->select($SQL);
    return $DataTable;
  }
}
