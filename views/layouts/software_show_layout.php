<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<title><?php print h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_styles.php");
?>
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'software', 'type' => 'rss')); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. <?php print h(l('Software')); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'software', 'id' => $this->software->id)); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. <?php print h(l('Software')); ?> .o. <?php print h($this->software->title); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'feed', 'action' => 'software_comments', 'id' => $this->software->id)); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. <?php print h(sprintf(l('Comments on %s'), $this->software->title)); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'software', 'type' => 'atom')); ?>" rel="alternate" type="application/atom+xml" title="Emeraldion Lodge .o. <?php print h(l('Software')); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'software', 'id' => $this->software->id, 'type' => 'atom')); ?>" rel="alternate" type="application/atom+xml" title="Emeraldion Lodge .o. <?php print h(l('Software')); ?> .o. <?php print h($this->software->title); ?>" />
		<link href="<?php echo $this->url_to(array('controller' => 'sparkle', 'action' => 'index', 'id' => $this->software->id)); ?>" rel="alternate" type="application/rss+xml" title="Emeraldion Lodge .o. <?php print h(sprintf(l('Sparkle appcast for %s'), $this->software->title)); ?>" />
		<link href="/assets/styles/software/<?php echo $this->software->type; ?>/<?php echo $this->software->name; ?>.css" type="text/css" rel="stylesheet" />
		<style type="text/css">
		/*<![CDATA[*/
			html .fb_share_link
			{
				padding:2px 0 0 20px;
				height:16px;
				background:url(http://static.ak.fbcdn.net/images/share/facebook_share_icon.gif?0:26981) no-repeat top left;
			}
		/*]]>*/
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script type="text/javascript">
		/*<![CDATA[*/
			function increaseDownloads()
			{
				$('#this-version-downloads').html(parseInt($('#this-version-downloads').html(), 10) + 1);
				$('#all-versions-downloads').html(parseInt($('#all-versions-downloads').html(), 10) + 1);
			}
			function fbs_click()
			{
				u = location.href;
				t = document.title;
				window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
				return false;
			}
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
	$this->render(array('partial' => 'downloads'));
	$this->render(array('partial' => 'download_stats'));
?>
<h3><?php echo l('Share'); ?></h3>
<div style="margin: 1em 0">
	<a href="http://www.facebook.com/share.php?u=<?php echo urlencode($this->url_to_myself(FALSE)); ?>"
		onclick="return fbs_click()" class="fb_share_link"><?php echo l('Share on Facebook'); ?></a>
	<script type="text/javascript">
	/*<![CDATA[*/
		var digg_url = '<?php echo $this->software->permalink(FALSE); ?>';
		var digg_skin = 'compact';
		var digg_window = 'new';
	/*]]>*/
	</script>
	<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>
</div>
<?php
	$this->render(array('partial' => 'google_groups'));
?>
<h3><?php echo l('Awards'); ?></h3>
<?php
	$this->render(array('partial' => 'iusethis'));
	$this->render(array('partial' => 'macupdate'));
	$this->render(array('partial' => 'versiontracker'));
	$this->render(array('partial' => 'softpedia_clean_award'));
?>
<div class="expander">
<?php
	$this->link_to(l('More ratings...'), array('class' => 'fwd', 'action' => 'ratings'));
?>

</div>
<?php
	$this->render(array('partial' => 'user_quotes'));
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
