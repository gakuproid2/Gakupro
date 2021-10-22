<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>メインメニュー</title>
</head>

<?php

?>

<body>



    <form name="pullForm">

    <select name="pullMenu">
        <option value="frm_MainCategory_M.php">aへ遷移</option>
        <option value="b.html">bへ遷移</option>
        <option value="c.html">cへ遷移</option>
    </select>

    <input type="button" value="クリック" onclick="screenChange()"> 
</form>

</body>

<script>

function screenChange(){
    pullSellect = document.pullForm.pullMenu.selectedIndex ;
    location.href = document.pullForm.pullMenu.options[pullSellect].value ;
}

</script>

</html>