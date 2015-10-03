		<title>Emeraldion Lodge .o. <?php printf(l('Comments on %s'), utf8_encode($this->article->title)) ?></title>
		<link><?php print $this->feed_permalink(); ?></link>
		<description><?php printf(l('Comments issued on %s by readers.'), utf8_encode($this->article->title)); ?></description>
		<language>en</language>
		<copyright>Copyright 2001-<?php echo date("Y"); ?>, Claudio Procida</copyright>
		<webMaster>webmaster@emeraldion.it (Emeraldion Lodge Webmaster)</webMaster>
		<pubDate><?php print date('r'); ?></pubDate>
		<lastBuildDate><?php print date('r'); ?></lastBuildDate>
		<category><?php echo utf8_encode(l('Blogging')); ?></category>
		<generator>In house</generator>
		<atom:link href="<?php print $this->feed_permalink(); ?>" rel="self" type="application/rss+xml" />
<?php
	$comments = $this->comments;
	foreach ($comments as $comment)
	{
?>
		<item>
			<title><?php printf(l('Comment by %s'), utf8_encode($comment->author)); ?></title>
			<guid isPermaLink="true"><?php echo $comment->permalink(FALSE); ?></guid>
			<link><?php echo $comment->permalink(FALSE); ?></link>
			<description>
				<![CDATA[
				<p>
					<?php echo utf8_encode($comment->pretty_text()); ?>
				</p>
				<p>
					<?php printf(l('Issued by %s on %s.'),
						a(utf8_encode($comment->author), array('href' => utf8_encode($comment->permalink(FALSE)))),
						utf8_encode($comment->human_readable_date())); ?>
				</p>
				]]>
			</description>
			<pubDate><?php echo $comment->rfc2822_date(); ?></pubDate>
		</item>
<?php
	}
?>