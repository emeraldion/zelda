<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<title><?php print $this->title; ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_styles.php");
?>
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'diario', 'type' => 'rss')); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. Diario RSS Feed" />
		<link href="<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'diario', 'type' => 'atom')); ?>" rel="alternate" type="application/atom+xml" title="Emeraldion Lodge .o. Diario Atom Feed" />
		<link href="/assets/opensearch/diario.xml" rel="search" type="application/opensearchdescription+xml" title="Emeraldion Lodge - Diario" />
		<style type="text/css">
		/*<![CDATA[*/
			label.left-aligned
			{
				float: left;
				display: block;
				width: 80px;
				text-align:right;
				margin-right: 10px;
			}
			.labeled
			{
				margin-left: 90px;
			}
			.padded-to-label
			{
				padding-left: 90px;
			}
			label.required:after
			{
				content: "*";
			}
			.diario-gravatar
			{
				float: left;
			}
			.diario-comment-text
			{
				margin-left: 50px;
				min-height: 48px;
			}
		/*]]>*/
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script type="text/javascript">
		/*<![CDATA[*/
			$(function(){
				if ($.browser.safari)
				{
					var s_f = document.getElementById('f_term');
					s_f.setAttribute('type', 'search');
					s_f.setAttribute('autosave', 'it_emeraldion_diario');
					s_f.setAttribute('results', '5');
					s_f.setAttribute('autocompletion', 'false');
					s_f.setAttribute('placeholder', '<?php echo s(l('Type some text')); ?>');
				}
			});
		/*]]>*/
		</script>
	</head>
	<body>
		<div id="external">
<?php
	require(dirname(__FILE__) . "/../views/_topbar.php");
?>
			<div id="top"></div>
			<div id="page-bg">
				<div id="brd_s">
					<div id="brd_w">
						<div id="brd_e">
							<div id="crn_sw">
								<div id="crn_se">
									<div id="header"></div>
<?php
	require(dirname(__FILE__) . "/../views/_navbar.php");
?>
									<div id="page">
										<div id="central">
											<div class="clear"></div>
											<div id="right-column">
<?php
	$this->render(array('partial' => 'search'));
	$this->render(array('partial' => 'calendar'));
	$this->render(array('partial' => 'tagcloud'));
	//$this->render(array('partial' => 'twitter_badge'));
	$this->render(array('partial' => 'blogroll'));
	$this->render(array('partial' => 'books'));
?>
											</div><!-- right-column -->
											<div id="center-column">
<?php
	print $this->content_for_layout;
?>
											</div><!-- center-column -->
											<div class="clear"></div>
										</div>
<?php
	require(dirname(__FILE__) . "/../views/_footer.php");
?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
