<!DOCTYPE html>
<html>
	<head>
		<title><?php print h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<style type="text/css">
		</style>
	</head>
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
      <div id="single-central" class="single-central">
        <div id="center-column">
<?php
	print $this->content_for_layout;
?>
        </div><!-- center-column -->
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
		<script>
		</script>
	</body>
</html>
