
<?php
  define("title" ,"ホーム");
require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
?>

<body>


  <!-- ======= Header ======= -->
  <?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/navi.php');
?>


  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container-fluid" data-aos="fade-up">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>有限会社エフ・エス・アイ</h1>
          <h2>Future（未来）System（機構）Integrate（統合）</h2>
        </div>
        <div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
          <!-- <img src="assets/img/hero-img.png" class="img-fluid animated" alt=""> -->
          <img src="assets/img/fsi_gazo/fsi_Logo_2.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="150">
            <img src="assets/img/fsi_gazo/IMG_2021.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
            <h3>システム開発・運用効率化のことならお任せください。</h3>
            <p class="font-italic">
            お客様のさまざまなニーズに対応したシステムの企画・立案から、システムの稼働・運用・保守までしっかりとサポートします。社内業務システムの開発・運用やネットワーク環境の構築、業務戦略に沿った各種システムの 設計・開発・運用・保守など細やかに対応。豊富なキャリアと技術を駆使して、最適なサービスをカタチにして提供しています。
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>事業内容</h2>
          <p>お客様の業務の効率化や合理化など、最適な企画提案を行います。</p>
          <p>また、お客様の業務内容にあったシステムを提供することで、コスト削減・生産性向上を実現します。</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue bg-light">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174"></path>
                </svg>
                <i class="bx bx-code-block"></i>
              </div>
              <h4>コンピュータ関連のソフトウェア設計・開発・保守</h4>
              <p>業務に合ったシステム設計、開発を行います。
                        システムは業務を行く上で不明な点等も出てくる場合がありますので、そこで
                        システムについての相談（保守）を行います。
                        開発内容は業務に合わせて、Webアプリ、Windowsアプリ、スマホアプリ等があります。
                        顧客管理システム、販売管理システム、会員管理システム、分析業務システム等。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-orange bg-light">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,582.0697525312426C382.5290701553225,586.8405444964366,449.9789794690241,525.3245884688669,502.5850820975895,461.55621195738473C556.606425686781,396.0723002908107,615.8543463187945,314.28637112970534,586.6730223649479,234.56875336149918C558.9533121215079,158.8439757836574,454.9685369536778,164.00468322053177,381.49747125262974,130.76875717737553C312.15926192815925,99.40240125094834,248.97055460311594,18.661163978235184,179.8680185752513,50.54337015887873C110.5421016452524,82.52863877960104,119.82277516462835,180.83849132639028,109.12597500060166,256.43424936330496C100.08760227029461,320.3096726198365,92.17705696193138,384.0621239912766,124.79988738764834,439.7174275375508C164.83382741302287,508.01625554203684,220.96474134820875,577.5009287672846,300,582.0697525312426"></path>
                </svg>
                <i class="bx bx-file"></i>
              </div>
              <h4>コンピュータシステム導入に関するコンサルタント</h4>
              <p>業務を行っている内容を確認し、現行のメリット、デメリットを判断します。
                        判断したデメリットの改善をどのように行っていったらよいか、提案し、
                        業務に合ったシステムを導入することでのメリットをお話しします。
                        また、既にシステムを導入していても、会社が拡大していくと運用が
                        変わってきたりしますので、システムの機能追加（カスタマイズ）の提案も
                        必要となってまいります。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-pink bg-light">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-planet"></i>
              </div>
              <h4>ネットワーク（LAN）構築及び保守</h4>
              <p>ネットワーク（LAN、WAN）に関する構築、工事、保守を行います。
                        Windows、Linux等の各種サーバ構築。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-yellow bg-light">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,503.46388370962813C374.79870501325706,506.71871716319447,464.8034551963731,527.1746412648533,510.4981551193396,467.86667711651364C555.9287308511215,408.9015244558933,512.6030010748507,327.5744911775523,490.211057578863,256.5855673507754C471.097692560561,195.9906835881958,447.69079081568157,138.11976852964426,395.19560036434837,102.3242989838813C329.3053358748298,57.3949838291264,248.02791733380457,8.279543830951368,175.87071277845988,42.242879143198664C103.41431057327972,76.34704239035025,93.79494320519305,170.9812938413882,81.28167332365135,250.07896920659033C70.17666984294237,320.27484674793965,64.84698225790005,396.69656628748305,111.28512138212992,450.4950937839243C156.20124167950087,502.5303643271138,231.32542653798444,500.4755392045468,300,503.46388370962813"></path>
                </svg>
                <i class="bx bx-layer"></i>
              </div>
              <h4>パソコン関連機器の販売・開発</h4>
              <p>パソコン本体、周辺機器の設定、販売、故障修理を行っております。
                        要望があれば、廃棄処分も行います。</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-red bg-light">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,532.3542879108572C369.38199826031484,532.3153073249985,429.10787420159085,491.63046689027357,474.5244479745417,439.17860296908856C522.8885846962883,383.3225815378663,569.1668002868075,314.3205725914397,550.7432151929288,242.7694973846089C532.6665558377875,172.5657663291529,456.2379748765914,142.6223662098291,390.3689995646985,112.34683881706744C326.66090330228417,83.06452184765237,258.84405631176094,53.51806209861945,193.32584062364296,78.48882559362697C121.61183558270385,105.82097193414197,62.805066853699245,167.19869350419734,48.57481801355237,242.6138429142374C34.843463184063346,315.3850353017275,76.69343916112496,383.4422959591041,125.22947124332185,439.3748458443577C170.7312796277747,491.8107796887764,230.57421082200815,532.3932930995766,300,532.3542879108572"></path>
                </svg>
                <i class="bx bx-slideshow"></i>
              </div>
              <h4>ホームページ作成</h4>
              <p>企業の要望に合ったホームページの制作を行います。
                        企業の案内、集客を求めて等の要望により制作致します。</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>業務実績</h2>
        </div>

        <div class="icon-box">
        <ul>
          <li class="h5">某銀行様分析システム構築及び保守</li>
          <li class="h5">某銀行様損益管理システム構築及び保守</li>
          <li class="h5">某銀行様文章管理システム構築及び保守</li>
          <li class="h5">某保証会社様顧客管理システム構築</li>
          <li class="h5">某弁護士事務所様書類作成システム構築</li>
          <li class="h5">某陶器会社ホームページ作成</li>
          <li class="h5">某食品加工会社ホームページ作成</li>
          <li class="h5">某花屋ホームページ作成</li>
          </ul>
      </div>
      </div>
    </section><!-- End Features Section -->
    
    <!-- ======= greeting ======= -->
        <section id="greeting" class="greeting">
      <div class="container">

      <div class="section-title">
          <h2>代表挨拶</h2>
        </div>

        <div class="row ">

          <div class="col pt-4 pt-lg-0 " data-aos="fade-right">
            
          <p>弊社は、コンピュータによるシステム開発、支援を主とするソフトウェア企業の会社です。</p>
          <p>これまでに多くの企業のソフトウェア開発拠点がオフショアとして海外へ広がり始めたころ、 私たちは、「自社でもできる」という強い気持ちを持ち、技術を追求して参りました。</p>
          <p>社名にもあります、Future（未来）、System（機構）、Integrate（統合）・・・</p>
          <p>「情報システムの企画、業務分析、設計、開発、構築、導入、保守、運用」を念頭に置き、 お客様に毎日進化し続ける情報サービス技術を「安全・安心・高品質なシステム」をご提供させていただき 技術・時代の最先端、未来を見つめながら、皆様とともに学び、成長し、貢献してまいります。</p>
            
          </div>

        </div>
        <div class="row">
        <div class="col text-right" data-aos="zoom-in" data-aos-delay="150">
            <img src="assets/img/fsi_gazo/ceo_text.png" class="img-fluid" alt="">
          </div>
          </div>

      </div>
    </section><!-- End greeting -->

    <!-- ======= Company Section ======= -->
    <section id="company" class="company section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>会社情報</h2>          
        </div>

        <div class="row">
         <div class="col-md-6">
            <div class="info-box  mb-4">
            <i class="bx bx-buildings"></i>
              <h3>社名</h3>
              <h4>有限会社エフ・エス・アイ</h4>
            </div>
          </div>
        <!-- </div>

        <div class="row"> -->
          <div class="col-md-6">
            <div class="info-box mb-4">
              <i class="bx bx-map"></i>
              <h3>住所</h3>
              <p>沖縄県浦添市勢理客1－24－10</p><p>シャトレー立山202</p>
            </div>
          </div>

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
              <h3 class="">TEL</h3>
              <p>098－879－3316</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-printer"></i>
              <h3 class="">FAX</h3>
              <p>098－894－3008</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-comment-detail"></i>
              <h3 class="">お問い合わせ</h3>
              <p><a href="contact">お問い合わせフォーム</a></p>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-lg-6 ">
            <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3578.5969666701467!2d127.6953176150308!3d26.242282083420914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34e56bb14a60d253%3A0x8caff6e364bf28d3!2z5pyJ6ZmQ5Lya56S-44Ko44OV44O744Ko44K544O744Ki44Kk!5e0!3m2!1sja!2sjp!4v1556245746321!5m2!1sja!2sjp" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
          </div>

          <div class="col-lg-6">
          <div class="info-box mb-4 px-2">
          <table class="table">
                <tr>
                    <th class="">設立年月日</th>
                    <td class="">平成18年4月26日</td>
                </tr>
                <tr>
                    <th class="">資本金</th>
                    <td class="">300万円</td>
                </tr>
                <tr>
                    <th class="">従業員数</th>
                    <td class="">10名（令和3年5月1日現在）</td>
                </tr>
                <tr>
                    <th class="">営業時間</th>
                    <td class="">平日9:00 ~ 18:00</td>
                </tr>
                <tr>
                    <th class="">事業内容</th>
                    <td class="text-left">
                        <p>・コンピュータ関連のソフトウェア設計・開発・保守</p>
                        <p>・コンピュータシステム導入に関するコンサルタント</p>
                        <p>・コンピュータ機器及び関連用品の販売</p>
                        <p>・ネットワーク（LAN）構築及び保守</p>
                        <p>・インターネット関連機器の販売・開発</p>
                        <p>・ホームページ作成</p>
                    </td>
                </tr>
            </table>
            </div>
          </div>

          <div class="col">
          <div class="info-box mb-4 px-2">
          <h3>沿革</h3>
          <table class="table">
                <tr>
                    <th class="">2004（平成16）年 6月</th>
                    <td class="">沖縄県那覇市松川で創業</td>
                </tr>
                <tr>
                    <th class="">2006（平成18）年 4月</th>
                    <td class="">沖縄県浦添市宮城に会社設立</td>
                </tr>
                <tr>
                    <th class="">2016（平成28）年 3月</th>
                    <td class="">沖縄県浦添市勢理客へ移転</td>
                </tr>
                <tr>
                    <th class="">2016（平成28）年 4月</th>
                    <td class="">創立10周年を迎える</td>
                </tr>
            </table>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Company Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
  ?>


</body>

</html>