
<?php
  define("title" ,"ホーム");
require_once($_SERVER['DOCUMENT_ROOT'] . '/urumasaien_web/head.php');
?>


<body>


  <!-- ======= Header ======= -->


<main id="main">

  <!-- ======= Hero Section ======= -->
  <section id="mainpage" class="mainpage main_imgBox">
   
            
    <div class="main_img" style="background-image: url(assets/img/urumasaien_gazo/001.JPG)"></div>
    <div class="main_img" style="background-image: url(assets/img/urumasaien_gazo/002.JPG)"></div>
    <div class="main_img" style="background-image: url(assets/img/urumasaien_gazo/003.JPG)"></div>
   

    <div class="container mainpage-val">      
      <div class="row justify-content-center">    
        <p class="corporatename">公益財団法人　うるま斎苑</p><br>         
        <p class="corporateinfo"><a href="tel:098-974-6941" class="corporateinfotel"><i class="bx bx-phone-call"></i>098-974-6941</a><a class="corporateinfotime">（受付時間　8：30～17：00）</a></p>
      </div>

      <div class="row justify-content-center">    
        <?php
          $is_index = false;
          $uri = $_SERVER['REQUEST_URI'];
          if($uri == '/index'){
          $is_index = true;
          }
        ?>
        
        <nav class="nav-menu indexpage-nav-menu">
          <ul>            
            <li class="<?php if($uri == '/cremation.php'){echo 'active';}?>"><a href="<?php if($uri == '/cremation.php'){echo '#';}?>cremation.php">火葬について</a></li>
            <li class="<?php if($uri == '/memorialservice.php'){echo 'active';}?>"><a href="<?php if($uri == '/memorialservice.php'){echo '#';}?>memorialservice.php">納骨堂について</a></li>
            <li class="<?php if($uri == '/corporateinfo.php'){echo 'active';}?>"><a href="<?php if($uri == '/corporateinfo.php'){echo '#';}?>corporateinfo.php">法人情報</a></li>
          </ul>
        </nav><!-- .nav-menu -->
      </div>      

      <div class="mainpagemessage row justify-content-center">        
        <h1>ご家族の希望に沿った御供養を<br>提案いたします。</h1>   
      </div>   

    </div>    


  </section><!-- End Hero -->

</main>

</body>

</html>
