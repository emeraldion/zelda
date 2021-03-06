<!DOCTYPE html>
<html>
	<head>
		<title><?php print h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'software', 'type' => 'rss')); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge - <?php print h(l('Software')); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'software', 'type' => 'atom')); ?>" rel="alternate" type="application/atom+xml" title="Emeraldion Lodge - <?php print h(l('Software')); ?>" />
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
			<div id="single-central" class="single-central page-tight">
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
