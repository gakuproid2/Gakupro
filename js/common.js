//Headerのプルダウン選択時の画面遷移処理
function screenChange(){
    pullSellect = document.pullForm.pullMenu.selectedIndex ;
    location.href = document.pullForm.pullMenu.options[pullSellect].value ;
}

function originalpost(path, params, method = 'post') {

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

function ConfirmationMessage(TargetName,ProcessingType) {

  var ConfirmationMessage;

  if (ProcessingType == 1) {
    ConfirmationMessage = TargetName + 'を登録しますか？';
  }else if(ProcessingType == 2){
    ConfirmationMessage = TargetName + 'を更新しますか？';
  }else if(ProcessingType == 3){
    ConfirmationMessage = TargetName + 'を利用可能にしますか？';
  }else if(ProcessingType == 4){
    ConfirmationMessage = TargetName + 'を利用不可にしますか？';
  }

  if (window.confirm(ConfirmationMessage)) {
    return true;
  } else {
    return false;
  }

  
}