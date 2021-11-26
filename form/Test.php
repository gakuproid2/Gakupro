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

<select class="parent" name="foo">
  <option value="" selected="selected">地方を選択</option>
  <option value="北海道・東北">北海道・東北</option>
  <option value="関東">関東</option>
  <option value="甲信越・北陸">甲信越・北陸</option>
  <option value="東海">東海</option>
  <option value="関西">関西</option>
  <option value="中国">中国</option>
  <option value="四国">四国</option>
  <option value="九州・沖縄">九州・沖縄</option>
</select>
 
<select class="children" name="bar" disabled>
  <option value="" selected="selected">都道府県を選択</option>
  <option value="北海道" data-val="北海道・東北">北海道</option>
  <option value="青森県" data-val="北海道・東北">青森県</option>
  <option value="岩手県" data-val="北海道・東北">岩手県</option>
  <option value="宮城県" data-val="北海道・東北">宮城県</option>
  <option value="秋田県" data-val="北海道・東北">秋田県</option>
  <option value="山形県" data-val="北海道・東北">山形県</option>
  <option value="福島県" data-val="北海道・東北">福島県</option>
  <option value="茨城県" data-val="関東">茨城県</option>
  <option value="栃木県" data-val="関東">栃木県</option>
  <option value="群馬県" data-val="関東">群馬県</option>
  <option value="埼玉県" data-val="関東">埼玉県</option>
  <option value="千葉県" data-val="関東">千葉県</option>
  <option value="東京都" data-val="関東">東京都</option>
  <option value="神奈川県" data-val="関東">神奈川県</option>
  <option value="新潟県" data-val="甲信越・北陸">新潟県</option>
  <option value="富山県" data-val="甲信越・北陸">富山県</option>
  <option value="石川県" data-val="甲信越・北陸">石川県</option>
  <option value="福井県" data-val="甲信越・北陸">福井県</option>
  <option value="山梨県" data-val="甲信越・北陸">山梨県</option>
  <option value="長野県" data-val="甲信越・北陸">長野県</option>
  <option value="岐阜県" data-val="東海">岐阜県</option>
  <option value="静岡県" data-val="東海">静岡県</option>
  <option value="愛知県" data-val="東海">愛知県</option>
  <option value="三重県" data-val="東海">三重県</option>
  <option value="滋賀県" data-val="関西">滋賀県</option>
  <option value="京都府" data-val="関西">京都府</option>
  <option value="大阪府" data-val="関西">大阪府</option>
  <option value="兵庫県" data-val="関西">兵庫県</option>
  <option value="奈良県" data-val="関西">奈良県</option>
  <option value="和歌山県" data-val="関西">和歌山県</option>
  <option value="鳥取県" data-val="中国">鳥取県</option>
  <option value="島根県" data-val="中国">島根県</option>
  <option value="岡山県" data-val="中国">岡山県</option>
  <option value="広島県" data-val="中国">広島県</option>
  <option value="山口県" data-val="中国">山口県</option>
  <option value="徳島県" data-val="四国">徳島県</option>
  <option value="香川県" data-val="四国">香川県</option>
  <option value="愛媛県" data-val="四国">愛媛県</option>
  <option value="高知県" data-val="四国">高知県</option>
  <option value="福岡県" data-val="九州・沖縄">福岡県</option>
  <option value="佐賀県" data-val="九州・沖縄">佐賀県</option>
  <option value="長崎県" data-val="九州・沖縄">長崎県</option>
  <option value="熊本県" data-val="九州・沖縄">熊本県</option>
  <option value="大分県" data-val="九州・沖縄">大分県</option>
  <option value="宮崎県" data-val="九州・沖縄">宮崎県</option>
  <option value="鹿児島県" data-val="九州・沖縄">鹿児島県</option>
  <option value="沖縄県" data-val="九州・沖縄">沖縄県</option>
</select>

    <?php echo $JS_Info ?>
</body>

<script>
var $children = $('.children'); //都道府県の要素を変数に入れます。
var original = $children.html(); //後のイベントで、不要なoption要素を削除するため、オリジナルをとっておく
 
//地方側のselect要素が変更になるとイベントが発生
$('.parent').change(function() {
 
  //選択された地方のvalueを取得し変数に入れる
  var val1 = $(this).val();
 
  //削除された要素をもとに戻すため.html(original)を入れておく
  $children.html(original).find('option').each(function() {
    var val2 = $(this).data('val'); //data-valの値を取得
 
    //valueと異なるdata-valを持つ要素を削除
    if (val1 != val2) {
      $(this).not(':first-child').remove();
    }
 
  });
 
  //地方側のselect要素が未選択の場合、都道府県をdisabledにする
  if ($(this).val() == "") {
    $children.attr('disabled', 'disabled');
  } else {
    $children.removeAttr('disabled');
  }
 
});
</script>


</html>