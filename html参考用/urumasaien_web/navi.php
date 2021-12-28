  <!-- ======= Header ======= -->
 
  <header id="header" class="fixed-top header-inner-pages"> 

    <div class="container">  
        
      <div id="corporateallinfo" class="corporateallinfo row justify-content-center" >    
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
          <nav class="nav-menu">
            <ul>
              <li class="<?php if($is_index){echo 'active';}?>"><a href="<?php if(!$is_index){echo 'index.php';}?>">ホーム</a></li>
              <li class="<?php if($uri == '/cremation.php'){echo 'active';}?>"><a href="<?php if($uri == '/cremation.php'){echo '#';}?>cremation.php">火葬について</a></li>
              <li class="<?php if($uri == '/memorialservice.php'){echo 'active';}?>"><a href="<?php if($uri == '/memorialservice.php'){echo '#';}?>memorialservice.php">納骨堂について</a></li>
              <li class="<?php if($uri == '/corporateinfo.php'){echo 'active';}?>"><a href="<?php if($uri == '/corporateinfo.php'){echo '#';}?>corporateinfo.php">法人情報</a></li>              
              <li id="displaystate_change"><a><i id="displaystate_change_icon" class="fas fa-sort-up"></i></a></li>              
            </ul>
          </nav><!-- .nav-menu -->

          
        </div>      
        
    </div>
  </header><!-- End Header -->
  