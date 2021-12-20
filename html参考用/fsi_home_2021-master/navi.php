  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container-fluid">

      <div class="row justify-content-center">
        <div class="col-xl-9 d-flex align-items-center">
          <!-- <h1 class="logo mr-auto"><a href="index">有限会社FSI</a></h1> -->
          <!-- Uncomment below if you prefer to use an image logo -->
          <a href="index" class="logo mr-auto"><img src="assets/img/fsi_gazo/fsi_Logo_1.jpg" alt="" class="img-fluid"></a>
          <?php
          $is_index = false;
          $uri = $_SERVER['REQUEST_URI'];
          if($uri == '/index'){
            $is_index = true;
          }
          ?>
          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li class="<?php if($is_index){echo 'active';}?>"><a href="<?php if(!$is_index){echo 'index';}?>#hero">ホーム</a></li>
              <li><a href="<?php if(!$is_index){echo 'index';}?>#services">事業内容</a></li>
              <li><a href="<?php if(!$is_index){echo 'index';}?>#features">業務実績</a></li>
              <li class="<?php if($uri == '/policy'){echo 'active';}?>"><a href="<?php if($uri == '/policy'){echo '#';}?>policy">個人情報保護方針</a></li>
              <li class="drop-down <?php if($uri == '/recruit-new' or $uri == '/recruit-mid' or $uri == '/recruit-part'){echo 'active';}?>"><a href="">採用情報</a>
                <ul>
                  <li class="<?php if($uri == '/recruit-new'){echo 'active';}?>"><a href="recruit-new">新卒採用</a></li>
                  <li class="<?php if($uri == '/recruit-mid'){echo 'active';}?>"><a href="recruit-mid">中途採用</a></li>
                  <li class="<?php if($uri == '/recruit-part'){echo 'active';}?>"><a href="recruit-part">パート採用</a></li>
                </ul>
              </li>
              <li><a href="<?php if(!$is_index){echo 'index';}?>#company">会社情報</a></li>
              <li class="<?php if($uri == '/contact'){echo 'active';}?>"><a href="<?php if($uri == '/contact'){echo '#';}?>contact">お問い合わせ</a></li>

            </ul>
          </nav><!-- .nav-menu -->
          <a href="kintai-pr" class="get-started-btn scrollto px-2"><span class="badge badge-danger small mr-1 flash">new</span>勤怠クラウド</a>
        </div>
      </div>

    </div>
  </header><!-- End Header -->
