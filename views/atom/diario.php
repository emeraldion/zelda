		<title>Emeraldion Lodge .o. <?php echo utf8_encode(l('Diario')); ?></title>
		<link href="<?php print htmlentities($this->feed_permalink()); ?>" rel="self" type="application/atom+xml" />
		<id><?php print $this->feed_permalink(); ?></id>
		<generator>In house</generator>
		<updated><?php print date("c"); ?></updated>
<?php
	function unhtmlentities($string)
	{
		// replace numeric entities
		$string = preg_replace('/&[lr]squo;/', '\'', $string);
		$string = preg_replace('/&[lr]dquo;/', '"', $string);
		return html_entity_decode($string, ENT_QUOTES);
	}
	
	foreach ($this->posts as $post)
	{
		$this->render(array('partial' => 'post', 'object' => $post));
	}
?>