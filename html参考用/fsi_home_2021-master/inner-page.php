<?php
  define("title" ,"inner-page");
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
          <h2>Inner Page</h2>
          <ol>
            <li><a href="index">ホーム</a></li>
            <li>Inner Page</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <p>
          Example inner page template
        </p>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
  ?>
</body>

</html>