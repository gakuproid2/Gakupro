<?php
  define("title" ,"法人情報");
require_once($_SERVER['DOCUMENT_ROOT'] . '/urumasaien_web/head.php');
?>



<body>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/urumasaien_web/navi.php');
?>
  <!-- ======= Header ======= -->


  <main id="main">

  <!-- ======= corporateinfo Section ======= -->
  <section id="corporateinfo" class="corporateinfo section-bg">
      <div class="container">

      
        <p><h4 class="alert-primary p-3">法人情報</h4></p>
        <div class="row">              
          <div class="col-lg-6">
            <div id="corporateinfotable" class="info-box mb-4 px-2">
              <table class="table">

                <tr>
                  <th class="">名称</th>
                  <td class="text-left">公益財団法人　うるま斎苑</td>
                </tr>
                <tr>
                  <th class="">理事長</th>
                  <td class="text-left"><ruby><rb>中村 正人</rb><rp>（</rp><rt>ナカムラ マサト</rt><rp>）</rp></ruby></td>
                </tr>              
                <tr>
                  <th class="">設立年月日</th>
                  <td class="text-left">昭和〇〇年〇〇月〇〇日</td>
                </tr>
                <tr>
                  <th class="">公益法人移行登記</th>
                  <td class="text-left">平成〇〇年〇〇月〇〇日</td>
                </tr>
                <tr>
                  <th class="">所管官庁</th>
                  <td class="text-left">沖縄県 保健医療部 衛生薬務課</td>
                </tr>
                <tr>
                  <th class="">基本財産</th>
                  <td class="text-left">12,345,678円（2021年3月31日現在）</td>
                </tr>
                <tr>
                  <th class="">正味財産</th>
                  <td class="text-left">12,345,678円（2021年3月31日現在）</td>
                </tr>
                <tr>
                  <th class="">住所</th>
                  <td class="text-left">沖縄県うるま市具志川1508</td>
                </tr>
                <tr>
                  <th class="">電話番号</th>
                  <td class="text-left">098-974-6941</td>
                </tr>
                <tr>
                  <th class="">受付時間</th>
                  <td class="text-left">8:30 ~ 17:00</td>
                </tr>
                <tr>
                <th class="">事業内容</th>
                <td class="text-left">
                <p>・火葬上の経営に関する事業</p>
                <p>・納骨堂の経営に関する事業</p>             
                <p>・その他この法人の目的を達成する為に必要な事業</p>             
                </td>
                </tr>              
              </table>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="info-box mb-4 px-2">          
              <div   id="urumasaiengazo" class="urumasaiengazo">                      
              </div>          
            </div>       
          </div>

        </div>

        <div class="row"> 
          <div class="col">
            <div class="info-box mb-4 px-2">
              <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3575.283833495664!2d127.86920641546737!3d26.349680183373323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34e50eeab49521f9%3A0xfb6e32987ad07e5d!2z44GG44KL44G-5paO6IuR77yI5YWs55uK77yI6LKh77yJ77yJ!5e0!3m2!1sja!2sjp!4v1639461862642!5m2!1sja!2sjp" frameborder="0" style="border:0; width: 100%; height: 500px;" allowfullscreen></iframe>           
            </div>
          </div>
        </div>

        <div class="row">       
          <div class="col">
            <div class="info-box mb-4 px-2">
              <h3>沿革</h3>
              <table class="table">

                <tr>
                    <th class="">1994（平成6）年 11月</th>
                    <td class="">財団法人うるま斎苑設立</td>
                </tr>
                <tr>
                    <th class="">1995（平成7）年 11月</th>
                    <td class="">財団法人うるま斎苑設立</td>
                </tr>
                <tr>
                    <th class="">1996（平成8）年 11月</th>
                    <td class="">財団法人うるま斎苑設立</td>
                </tr>
                <tr>
                    <th class="">1997（平成9）年 11月</th>
                    <td class="">財団法人うるま斎苑設立</td>
                </tr>

              </table>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End corporateinfo Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/urumasaien_web/footer.php');
  ?>
</body>
<script>
 // Preloader
 $(window).on('load', function() {

  var height=$("#corporateinfotable").height();
  $("#urumasaiengazo").css("height", height);


});

$(window).on('resize', function() {

  var height=$("#corporateinfotable").height();
  $("#urumasaiengazo").css("height", height);


});
</script>

</html>