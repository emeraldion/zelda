<!DOCTYPE html>
<html>
	<head>
		<title><?php print $this->title; ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'diario', 'type' => 'rss')); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge - Diario RSS Feed" />
		<link href="<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'diario', 'type' => 'atom')); ?>" rel="alternate" type="application/atom+xml" title="Emeraldion Lodge - Diario Atom Feed" />
		<link href="/assets/opensearch/diario.xml" rel="search" type="application/opensearchdescription+xml" title="Emeraldion Lodge - Diario" />
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
//	$this->render(array('partial' => 'search'));
//	$this->render(array('partial' => 'calendar'));
//	$this->render(array('partial' => 'tagcloud'));
//	//$this->render(array('partial' => 'twitter_badge'));
//	$this->render(array('partial' => 'blogroll'));
//	$this->render(array('partial' => 'books'));
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
			$(function(){
					var s_f = document.getElementById('f_term');
					if (s_f) {
						s_f.setAttribute('type', 'search');
						s_f.setAttribute('autosave', 'it_emeraldion_diario');
						s_f.setAttribute('results', '5');
						s_f.setAttribute('autocompletion', 'false');
						s_f.setAttribute('placeholder', '<?php echo s(l('Type some text')); ?>');
					}
			});
		</script>
	</body>
</html>
