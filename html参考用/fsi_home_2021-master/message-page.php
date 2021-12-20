<?php
  define("title" ,"message-page");
require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
?>


<body>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/navi.php');
?>
  <!-- ======= Header ======= -->


  <main id="main">
  <section class="col-10">
  <div class="alert alert-<?php echo $_GET['type']; ?>" role="alert">
  <?php echo $_GET['message']; ?>
</div>
  
</section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
  ?>
</body>

</html>