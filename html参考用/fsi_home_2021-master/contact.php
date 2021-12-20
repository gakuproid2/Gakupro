<?php
  define("title" ,"お問い合わせ");
  define("pagehead" ,'<script src="https://www.google.com/recaptcha/api.js?render=6LfVZTobAAAAAHgsLP2coMWhdt6dNb2pA51sBpfo"></script>');
require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
?>
<style>
.back-to-top {
  bottom: 100px;
}
</style>

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
          <h2>お問い合わせ</h2>
          <ol>
            <li><a href="index">ホーム</a></li>
            <li>お問い合わせ</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">
        <div class="row">

          <!-- <div class="col-lg-6 ">
            <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
          </div> -->

          <div class="col">
            <form id="contact-form" action="forms/contact.php" method="post" class="php-email-form" data-recaptcha-site-key="6LfVZTobAAAAAHgsLP2coMWhdt6dNb2pA51sBpfo">
            <?php 
              $subject='';
              $body='';
               if(isset($_GET['type'])){
                 $type = $_GET['type'];
                 if($type==1){
                  $subject='新卒採用について';
                 }else if($type==2){
                  $subject='中途採用について';
                 }else if($type==3){
                  $subject='パート採用について';
                 }else if($type==4){
                  $subject='勤怠クラウドについて';
                  $body="会社名：\nTEL：\n住所：\n社員数：\n";
                 }

                } 
            ?>
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="会社名またはお名前" data-rule="minlen:2" data-msg="最低2文字以上入力してください。" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="メールアドレス" data-rule="email" data-msg="有効なメールアドレスを入力してください。" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="件名" data-rule="minlen:4" data-msg="最低4文字以上入力してください。" value="<?php echo $subject; ?>"/>
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="メッセージを入力してください。" placeholder="メッセージ"><?php echo $body; ?></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">ありがとうございます。メッセージを送信しました。</div>
              </div>
              <div class="text-center"><button class="btn btn-info" type="submit" id="send">メッセージ送信</button>
              <!-- <input type="hidden" name="recaptchaToken" id="recaptchaToken" /> -->
            </form>
          </div>

        </div>
      </div>
    </div>
    </section>

    <section id="other" class="other section-bg">
      <div class="container" data-aos="fade-right">

      <div class="section-title">
          <h2>その他のお問い合わせ方法</h2>
          <p>お電話でのお問い合わせ時間：平日9:00 ~ 18:00</p>
          <p>※上記の時間外でもお問い合わせしても構いませんが不在の場合があります。</p>
        </div>

        <div class="row">

        <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email</h3>
              <p>info@fsi-web.com</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3 class="mb-1">TEL</h3>
              <p>098－879－3316</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
            <i class="bx bx-printer"></i>
              <h3 class="mb-1">FAX</h3>
              <p>098－894－3008</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
  ?>
  <script>
  // $(function(){
  //   $('#send').on('click',function(e){
  //     $("input[name=submitBtn]").click();
  //   });

  //   $('input[name=submitBtn]').on('click',function(){
  //     grecaptcha.ready(function() {
  //         grecaptcha.execute('6LfVZTobAAAAAHgsLP2coMWhdt6dNb2pA51sBpfo', {action: 'submit'}).then(function(token) {
  //             // Add your logic to submit to your backend server here.
  //             var recaptchaToken = $('#recaptchaToken');
  //                     recaptchaToken.value = token;
  //                     $('#contact-form').submit();
  //         });
  //     });
  //   });
  // });
// document.getElementById('contact-form').addEventListener('submit', onSubmit);

// function onSubmit(e) {
//     e.preventDefault();
//     grecaptcha.ready(function() {
//         grecaptcha.execute('6LfVZTobAAAAAHgsLP2coMWhdt6dNb2pA51sBpfo', {action: 'submit'}).then(function(token) {
//             // Add your logic to submit to your backend server here.
//             var recaptchaToken = document.getElementById('recaptchaToken');
//                     recaptchaToken.value = token;
//                     document.getElementById('contact-form').submit();
//         });
//     });
// }
</script>
</body>

</html>