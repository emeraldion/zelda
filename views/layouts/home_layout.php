<!DOCTYPE html>
<html>
	<head>
		<title><?php print h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_styles.php");
?>
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'software', 'type' => 'rss')); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. <?php print h(l('Software')); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'diario', 'type' => 'rss')); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. <?php print h(l('Diario')); ?>" />
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
      <div id="central" class="central">
        <div id="right-column">
<?php
	// $this->render_component(array('controller' => 'feed', 'action' => 'feeds_list'));
	// $this->render(array('partial' => 'recommended'));
	// $this->render(array('partial' => 'del_icio_us'));
?>
        </div><!-- right-column -->
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
		<script type="text/javascript">
		</script>
	</body>
</html>
