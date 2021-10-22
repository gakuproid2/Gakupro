//Headerのプルダウン選択時の画面遷移処理
function screenChange(){
    pullSellect = document.pullForm.pullMenu.selectedIndex ;
    location.href = document.pullForm.pullMenu.options[pullSellect].value ;
}