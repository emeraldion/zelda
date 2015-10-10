		<title>Emeraldion Lodge - <?php echo utf8_encode(l('Diario')); ?></title>
		<link><?php print $this->feed_permalink(); ?></link>
		<description><?php echo utf8_encode(l('Latest blog entries by Claudio Procida, Emeraldion Lodge.')); ?></description>
		<language>en</language>
		<copyright>Copyright 2001-<?php echo date("Y"); ?>, Claudio Procida</copyright>
		<webMaster>webmaster@emeraldion.it (Emeraldion Lodge Webmaster)</webMaster>
		<pubDate><?php print date('r'); ?></pubDate>
		<lastBuildDate><?php print date('r'); ?></lastBuildDate>
		<category><?php echo utf8_encode(l('Blogging')); ?></category>
		<generator>In house</generator>
		<atom:link href="<?php print $this->feed_permalink(); ?>" rel="self" type="application/rss+xml" />
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
?>
		<item>
			<title><?php echo utf8_encode(unhtmlentities($post->title)); ?></title>
			<guid isPermaLink="true"><?php echo $post->permalink(FALSE); ?></guid>
			<link><?php echo $post->permalink(FALSE); ?></link>
			<description>
				<![CDATA[
				<p>
					<?php echo utf8_encode($post->summary(FALSE)); ?>
				</p>
				<p>
					<?php echo a(l('Read more...'), array('href' => $post->permalink(FALSE))); ?>
				</p>
			]]>
			</description>
			<pubDate><?php echo $post->rfc2822_date(); ?></pubDate>
		</item>
<?php
	}
?>