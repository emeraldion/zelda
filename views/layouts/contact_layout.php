<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->title; ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<style type="text/css">
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script type="text/javascript">
		</script>
	</head>
	<body>
    <body>
  <?php
  //	require(dirname(__FILE__) . "/../views/_topbar.php");
  ?>
      <header>
  <?php
  	require(dirname(__FILE__) . "/../views/_navbar.php");
  ?>
      </header>
      <main>
        <div id="single-central" class="single-central page-tight">
          <div class="center-column">
<?php
	// $this->render(array('partial' => 'navbar'));

	print $this->content_for_layout;
?>
          </div>
        </div>
      </div>
    </main>
    <footer>
<?php
	require(dirname(__FILE__) . "/../views/_footer.php");
?>
		</footer>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script type="text/javascript">
		</script>
	</body>
