<?php
	if (date("Y-m-d") == "2008-06-17")
	{
?>
	<div style="position:fixed;width:200px;height:200px;z-index:1000;top:0;right:0">
		<a href="http://www.spreadfirefox.com/node&amp;id=98359&amp;t=271"><img border="0" alt="Download Day - English" title="Download Day - English" src="/assets/images/ff3_download_day.png"/></a>
	</div>
<?php
	}
?>
<div id="coolpreview_container">
	<img id="coolpreview_loader" src="/assets/images/null.png" alt="" />
	<img id="coolpreview_throbber" src="/assets/images/null.png" alt="" />
	<img id="coolpreview_picture" src="/assets/images/null.png" alt="" />
</div>
<div id="toplinks">
	<script type="text/javascript">
	/*<![CDATA[*/
		$(function()
			{
				$('#language-chooser a').hover(
					function(){$('#the-language').html($(this).attr('title'));},
					function(){$('#the-language').html('&nbsp;');});
			});
	/*]]>*/
	</script>
	<div id="language-chooser">
		<span id="the-language">&nbsp;</span>
		<ul><li><a
				href="<?php echo $this->url_to(array('controller' => 'language', 'action' => 'set', 'id' => 'it')); ?>"
				title="Italiano"><img src="/assets/images/it_flag.gif" alt="Italian flag" /></a></li><li><a
				href="<?php echo $this->url_to(array('controller' => 'language', 'action' => 'set', 'id' => 'en')); ?>"
				title="English"><img src="/assets/images/uk_flag.gif" alt="English flag" /></a></li><li><a
				href="<?php echo $this->url_to(array('controller' => 'language', 'action' => 'set', 'id' => 'es')); ?>"
				title="Español"><img src="/assets/images/es_flag.gif" alt="Spanish flag" /></a></li></ul>
	</div>
	<ul class="toplinks">
		<li>
			<?php echo $this->link_to(l('Contact'), array('controller' => 'contact')); ?>
		</li>
<?php
	if ($this->name != 'login')
	{
?>
		<li>
			<?php echo Login::is_logged_in() ? 
				$this->link_to(l('Logout'), array('controller' => 'login', 'action' => 'logout')) :
				$this->link_to(l('Login'), array('controller' => 'login')); ?>
		</li>
<?php
	}
?>
	</ul>
<?php
	if (date("Y-m-d") == "2008-05-23")
	{
?>
	<div style="position:absolute;right:90px;z-index:2000">
		<a href="http://en.wikipedia.org/wiki/Giovanni_Falcone"><img
			src="/assets/images/a/falcone_1992_2008.png" alt="Giovanni Falcone &mdash; 1992-2008" /></a>
	</div>
<?php
	}
?>
</div>