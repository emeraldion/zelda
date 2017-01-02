<?php
	$navbar_sections = array(
/*
		array('title' => localized('Home'),
			"url" => $this->url_to(array('controller' => 'home'))),
*/
		array('title' => localized('Blog'),
			"url" => $this->url_to(array('controller' => 'diario'))),
		array('title' => localized('Projects'),
			"url" => $this->url_to(array('controller' => 'projects'))),
		/*
		array('title' => localized('Software'),
			"url" => $this->url_to(array('controller' => 'software'))),
		array('title' => localized("Services"),
			"url" => $this->url_to(array('controller' => 'services'))),
		array('title' => localized('Blog'),
			"url" => $this->url_to(array('controller' => 'diario'))),
			*/
		array('title' => localized('Speaking'),
			"url" => $this->url_to(array('controller' => 'speaking'))),
		array('title' => localized('Photos'),
			"url" => $this->url_to(array('controller' => 'photos'))),
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
	<h1>
		<svg id="eme-logo" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 500 575" width="24" height="24">
			<path d="M 27 131 C 46 51 131 2 210 4 C 258 3 302 27 336 60 C 381 43 425 26 471 13 C 443 132 416 254 356 363 C 325 417 297 435 274 456 C 254 472 243 478 213 494 C 255 426 261 410 273 365 C 300 266 328 167 333 65 C 286 63 254 92 232 127 C 200 179 174 233 152 290 C 130 352 102 415 140 482 C 112 424 127 364 155 302 C 168 279 194 258 222 261 C 248 265 263 292 265 316 C 272 382 233 465 194 488 C 185 493 159 494 145 490 C 112 481 82 455 65 425 C 37 373 38 311 50 255 C 75 179 121 106 192 66 C 229 44 284 45 328 59 C 273 30 200 36 154 70 C 79 123 47 215 32 303 C 15 248 13 187 27 131 Z"></path>
		</svg><span class="text-logo">emeraldion lodge</span>
	</h1>
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
<style type="text/css">
	header.headroom--unpinned {
    	top: <?php printf('%dpx', - ($i + 1.2) * 52); ?>;
    }
</style>
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
	<div id="flash" role="alert" class="<?php echo $_SESSION["flash"]["type"]; ?>">
		<?php echo $_SESSION["flash"]["message"]; ?>
		[<?php print a(l('hide'), array('href' => '#', 'onclick' => "$('#flash').css('display','none')")); ?>]
	</div>
	</div>
	<script>
		$(function(){setTimeout(function(){$('#flash').fadeOut(500)}, 5000)});
	</script>
<?php
		// unset
		unset($_SESSION["flash"]);
	}
?>
