<!DOCTYPE html>
<html>
	<head>
		<title><?php echo h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<link href="<?php print APPLICATION_ROOT; ?>assets/styles/meta/meta.css" rel="stylesheet" type="text/css" />
		<link href="<?php print APPLICATION_ROOT; ?>assets/styles/meta/hits_by_host.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			label.left-aligned
			{
				float: left;
				display: block;
				width: 50px;
				text-align:right;
				margin-right: 10px;
			}
			.labeled
			{
				margin-left: 60px;
			}
			.padded-to-label
			{
				padding-left: 60px;
			}
			label.required:after
			{
				content: "*";
			}
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script>
		</script>
	</head>
	<body>
<?php
	// require(dirname(__FILE__) . "/../views/_topbar.php");
?>

    <header>
<?php
	require(dirname(__FILE__) . "/../views/_navbar.php");
?>
    </header>
    <main>
      <div id="single-central" class="central">
<?php
	$this->render(array('partial' => 'navbar'));
	print $this->content_for_layout;
?>
      </div>
    </main>
    <footer>
<?php
	require(dirname(__FILE__) . "/../views/_footer.php");
?>
    </footer>
	</body>
</html>
