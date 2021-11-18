//Headerのプルダウン選択時の画面遷移処理
function screenChange(){
    pullSellect = document.pullForm.pullMenu.selectedIndex ;
    location.href = document.pullForm.pullMenu.options[pullSellect].value ;
}

function post(path, params, method = 'post') {

    const form = document.createElement('form');
    form.method = method;
    form.action = path;
    
    for (const key in params) {
      if (params.hasOwnProperty(key)) {
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = key;
        hiddenField.value = params[key];
    
        form.appendChild(hiddenField);
      }
    }
    
    document.body.appendChild(form);
    form.submit();
}