<?php
	$navbar_sections = array(
		array('title' => localized('Home'),
			"url" => $this->url_to(array('controller' => 'home'))),
		array('title' => localized('Software'),
			"url" => $this->url_to(array('controller' => 'software'))),
		/*
		array('title' => localized("Services"),
			"url" => $this->url_to(array('controller' => 'services'))),
		*/
		array('title' => localized('Blog'),
			"url" => $this->url_to(array('controller' => 'diario'))),
		array('title' => localized('About'),
			"url" => $this->url_to(array('controller' => 'about'))),
		);

	if (Login::is_logged_in())
	{
		$navbar_sections[] = array('title' => localized('Meta'),
				"url" => $this->url_to(array('controller' => 'meta')));
		$navbar_sections[] = array('title' => localized('Backend'),
				"url" => $this->url_to(array('controller' => 'backend')));
	}
?>
	<nav>
		<ul id="navbar">
<?php
	$i = 0;
	$navbar_length = count($navbar_sections);
	foreach ($navbar_sections as $navbar_section)
	{
		$classname = 'navitem';
		$accesskey = 'a';//accesskey($navbar_section['title']);
		$url_items = explode("/", $navbar_section["url"]);
		if ($url_items[count($url_items) - 2] == $_REQUEST['controller'])
		{
			$classname .= " here";
		}
		if ($i == 0)
		{
			$classname .= " navfirst";
		}
		else if ($i == $navbar_length - 1)
		{
			$classname .= " navlast";
		}
?>
			<li>
				<a class="<?php echo $classname; ?>" href="<?php echo $navbar_section["url"]; ?>">
					<?php echo $navbar_section['title']; ?>
				</a>
			</li>
<?php
		$i++;
	}
?>
		</ul>
	</nav>
<?php
	// Ladies and gentlemen, the FLASH!

	// The flash is just a storage area to flush messages, alerts and such.
	// It gets flushed every time the user browses a page.

	// This is an example of how to use it
	// $_SESSION["flash"] = array("class"=>"message", "message"=>"Are you crazy?");

	if (isset($_SESSION["flash"]))
	{
		// flush to screen
?>
	<div class="error-outer">
	<div id="flash" class="<?php echo $_SESSION["flash"]["type"]; ?>">
		<?php echo $_SESSION["flash"]["message"]; ?>
		[<?php print a(l('hide'), array('href' => '#', 'onclick' => "$('#flash').css('display','none')")); ?>]
	</div>
	</div>
	<script type="text/javascript">
	/*<![CDATA[*/
		$(function(){setTimeout(function(){$('#flash').fadeOut(500)}, 5000)});
	/*]]>*/
	</script>
<?php
		// unset
		unset($_SESSION["flash"]);
	}
?>
