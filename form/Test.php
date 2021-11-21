<!doctype html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>テスト画面</title>
</head>

<?php
session_start(); //セッションスタート

//クラスファイルの読み込み
require_once '../php/common.php';
//クラスの生成
$common = new common();

//クラスファイルの読み込み
require_once '../dao/dao_Staff_M.php';
//クラスの生成
$dao_Staff_M = new dao_Staff_M();

//クラスファイルの読み込み
require_once '../dao/dao_SubCategory_M.php';
//クラスの生成
$dao_SubCategory_M = new dao_SubCategory_M();

$HeaderInfo = $common->HeaderCreation('テスト画面');

$JS_Info = $common->Read_JSconnection();
?>

<?php echo $HeaderInfo; ?>

<style>

</style>

<body>


  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="7777">
    モーダルテスト
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label for="place_id" class="col-md-3 col-form-label">A:</label>
            <input type="text" name="place_id" id="place_id" value="" class="form-control col-md-3" readonly>
          </div>

          <div class="form-group row">
            <label for="place_id" class="col-md-3 col-form-label">B:</label>
            <input type="text" name="place_id" id="place_id" value="" class="form-control col-md-3" readonly>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>




    <?php echo $JS_Info ?>
</body>

<script>
  $('#exampleModal').on('show.bs.modal', function(e) {


    $('#place_id').val(1324);

    // イベント発生元
    let evCon = $(e.relatedTarget);
    $('#place_id').val(evCon.data('id'));

  });
</script>


</html>