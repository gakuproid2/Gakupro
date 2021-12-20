<?php
  define("title" ,"勤怠クラウド");
require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
?>


<body>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/navi.php');
?>
  <!-- ======= Header ======= -->


  <main id="main">

      <!-- ======= Breadcrumbs ======= -->
      <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>勤怠クラウド</h2>
          <ol>
            <li><a href="index">ホーム</a></li>
            <li>勤怠クラウド</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="150">
            <img src="assets/img/kintai/kintai_device.png" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
            <h3>勤怠クラウド</h3>
            <p class="font-italic">
              社員の打刻処理をWEBで行うことでタイムカードが不要になります。
            </p>
            <ul>
              <li><i class="icofont-check-circled"></i> スマホやタブレット、またPCから打刻できます。</li>
              <li><i class="icofont-check-circled"></i> 打刻時に顔写真・位置情報の記録も可能。</li>
              <li><i class="icofont-check-circled"></i> 給与システムにCSV出力することで面倒な手入力を省き効率化を図ることができます。</li>
            </ul>
            <div class="alert alert-success" role="alert">
            <a class="btn btn-success" href="file/勤怠管理システム.pdf" download="勤怠管理システム.pdf">資料のダウンロード<i class="icofont-download ml-2"></i></a>
            </div>
            <p class="alert-info rounded p-2"><strong>1ヶ月間は無料試用できます！</strong>
            <a href="contact?type=4" class="read-more">お問い合わせ <i class="icofont-long-arrow-right"></i></a></p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>主な機能</h2>
          
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
                <img src="assets/img/kintai/dakoku_nippo.png" class="img-fluid" alt="">
              <h4>打刻、日報登録</h4>
              <p>スマホ、タブレット、PCから打刻できます。日報登録では画像も添付も可能です。またカレンダー・一覧で打刻・日報の確認が可能です。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
                <img src="assets/img/kintai/schedule.png" class="img-fluid" alt="">
              <h4>社員スケジュール</h4>
              <p>社員のスケジュールをカレンダー、一覧で表示します。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
                <img src="assets/img/kintai/vital.png" class="img-fluid" alt="">
              <h4>バイタル登録</h4>
              <p>体温、血圧などを登録し、管理者が社員の体調管理をすることができます。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box">
                <img src="assets/img/kintai/kyuka.png" class="img-fluid" alt="">
              <h4>休暇申請</h4>
              <p>社員が休暇申請し、管理者が確認し承認することができます。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
                <img src="assets/img/kintai/zangyo.png" class="img-fluid" alt="">
              <h4>残業申請</h4>
              <p>社員が残業申請し、管理者が確認し承認することができます。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
                <img src="assets/img/kintai/shucho.png" class="img-fluid" alt="">
              <h4>出張申請</h4>
              <p>社員が出張申請し、管理者が確認し承認することができます。</p>
            </div>
          </div>

        </div>
        <p class="alert-info rounded p-2 mt-3 col-lg-6"><strong>1ヶ月間は無料試用できます！</strong>
        <a href="contact?type=4" class="btn btn-primary">お問い合わせ <i class="icofont-long-arrow-right"></i></a>
       </p>

      </div>
    </section><!-- End Services Section -->

        <!-- ======= Options Section ======= -->
        <section id="options" class="options">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>その他の機能</h2>
          
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
                <img src="assets/img/fsi_gazo/d-scopeFC02.png" class="img-fluid" alt="">
              <h4>体温検知顔認証カメラとの連携(オプション)</h4>
              <p>D-Scope社製の<a href="https://www.datascope.co.jp/facefc/" target="_blank">Face FC(体温検知顔認証カメラ)</a>と連携し、スムーズに打刻登録する事が可能です。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
                <img src="assets/img/fsi_gazo/kintaiVB.jpg" class="img-fluid" alt="">
              <h4>Windowsアプリとの連携(オプション)</h4>
              <p>Windowsアプリと連携し、より高機能なシステムを使用する事ができます。</p>
            </div>
          </div>
          
        </div>
        <p class="alert-info rounded p-2 mt-3 col-lg-6"><strong>1ヶ月間は無料試用できます！</strong>
        <a href="contact?type=4" class="btn btn-primary">お問い合わせ <i class="icofont-long-arrow-right"></i></a>
       </p>

      </div>
    </section><!-- End Options Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
  ?>
</body>

</html>