<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">  
  <title>テスト画面</title>
</head>

<style>

* {
  box-sizing: border-box;
}
body {
  font-family:'Avenir','Helvetica, Neue','Helvetica','Arial';
}


/* モーダルCSS */
.modalArea {
  display: none;
  position: fixed;
  z-index: 10; /*サイトによってここの数値は調整 */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.modalBg {
  width: 100%;
  height: 100%;
  background-color: rgba(30,30,30,0.9);
}

.modalWrapper {
  position: absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%,-50%);
  width: 70%;
  max-width: 500px;
  padding: 10px 30px;
  background-color: #fff;
}

.closeModal {
  position: absolute;
  top: 0.5rem;
  right: 1rem;
  cursor: pointer;
}


/* 以下ボタンスタイル */
button {
  padding: 10px;
  background-color: #fff;
  border: 1px solid #282828;
  border-radius: 2px;
  cursor: pointer;
}

#openModal {
  position: absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%,-50%);
}
</style>

<body>


<button id="openModal">Open modal</button>

<!-- モーダルエリアここから -->
<section id="modalArea" class="modalArea">
  <div id="modalBg" class="modalBg"></div>
  <div class="modalWrapper">    
    <div class="form-group row">
            <label for="place_id" class="">現場ID:</label>
            <input type="text" name="place_id" id="place_id" value="" class="">
    </div>
    <div class="form-group row">
            <label for="place_id" class="">現場ID:</label>
            <input type="text" name="place_id" id="place_id" value="" class="">
    </div>
    
    <div class="form-group row">
            <label for="place_id" class="">現場ID:</label>
            <input type="text" name="place_id" id="place_id" value="" class="">
    </div>

    <div class="form-group row">
            <label for="place_id" class="">現場ID:</label>
            <input type="text" name="place_id" id="place_id" value="" class="">
    </div>


    <div id="closeModal" class="closeModal">×</div>
  </div>
</section>
<!-- モーダルエリアここまで -->







<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#sampleModal" data-recipient="受信者名">
	モーダル・ダイアログ 呼び出し
</button>

<!-- モーダル・ダイアログ -->
<div class="modal" id="sampleModal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>×</span></button>
				<h4 class="modal-title">タイトル</h4>
			</div>
			<div class="modal-body">
				メッセーシ：<input type="text">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-primary">ボタン</button>
			</div>
		</div>
	</div>
</div>


<script src="../js/jquery-3.6.0.min.js"></script>
</body>

<script>

  $(function () {

    $('#openModal').click(function(){
        $('#modalArea').fadeIn();
    });

    $('#closeModal , #modalBg').click(function(){
      $('#modalArea').fadeOut();
    });
    
  });


  $('#sampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var recipient = button.data('recipient');
		var modal = $(this);
		modal.find('.modal-title').text(recipient + 'へのメッセージ');
	});


</script>


</html>