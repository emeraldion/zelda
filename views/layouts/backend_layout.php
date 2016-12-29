<!DOCTYPE html>
<html>
	<head>
		<title><?php print h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<link href="/assets/styles/backend/backend.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		</style>
		<?php
			require(dirname(__FILE__) . "/../views/_scripts.php");
		?>
		<script src="/assets/javascript/backend/backend.js"></script>
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
      <div id="central" class="central">

				<div id="center-column">
<?php
	include(dirname(__FILE__) . "/../views/backend/_navbar.php");

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
	</body>
</html>
