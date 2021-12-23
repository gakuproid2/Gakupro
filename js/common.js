//Headerのプルダウン選択時の画面遷移処理
function screenChange(){

  
    var pullSellect = document.pullForm.pullMenu.selectedIndex ;
    var NextUrl= document.pullForm.pullMenu.options[pullSellect].value ;

    location.href = NextUrl;
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

//データ更新時のメッセージ
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


//Listの表示状態変更
function StateChangeList(targetlist,displaystate) {

  targetlist.value = 0;

  if(displaystate==0){
    targetlist.style='display:none';   
  }else{
    targetlist.style='display:select'; 
  }

  return targetlist;

}

//Listの内容絞り込み
function NarrowDownList(targetlist,listtagetname,targetdata) {

  for(var i= 0;i<targetlist.length;i++){

    ListTagetValue = (targetlist[i].dataset[listtagetname]);

    if(ListTagetValue == '' || targetdata == ListTagetValue || targetdata == 0){
      targetlist[i].style='display:option';        
    }else{
      targetlist[i].style='display:none';          
    }   

  }

  return targetlist;

}

//tableの表示内容絞り込み
function NarrowDownDataTable(targettable,tagetcolumnname,targetdata) {    
  
  
  for(i = 0, len = targettable.rows.length; i < len; i++) {      

    var ColumnTargetValue = targettable.rows[i].dataset[tagetcolumnname];                

    if(ColumnTargetValue == '' || ColumnTargetValue == targetdata || targetdata == 0){        
      targettable.rows[i].style='display:table-row';                  
    }else{
      targettable.rows[i].style='display:none';   
      
    }    

  }

  return targettable;
  
}

//Table表示件数検索
function SearchDataTableValidCases(targettable) {    

  var ValidCases = 0;
  for(i = 0, len = targettable.rows.length; i < len; i++) {  
    
    if(targettable.rows[i].style.display == 'table-row'){      
      ValidCases += 1;            
    }    
  }

  //Header部分が加算されるため、-1
  return ValidCases - 1;

}
    