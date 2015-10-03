		<title>Emeraldion Lodge .o. <?php printf(l('Comments on %s'), utf8_encode($this->software->title)) ?></title>
		<link><?php print $this->feed_permalink(); ?></link>
		<description><?php printf(l('Comments issued on %s by users.'), utf8_encode($this->software->title)); ?></description>
		<language>en</language>
		<copyright>Copyright 2001-<?php echo date("Y"); ?>, Claudio Procida</copyright>
		<webMaster>webmaster@emeraldion.it (Emeraldion Lodge Webmaster)</webMaster>
		<pubDate><?php print date('r'); ?></pubDate>
		<lastBuildDate><?php print date('r'); ?></lastBuildDate>
		<category>Software</category>
		<generator>In house</generator>
		<atom:link href="<?php print $this->feed_permalink(); ?>" rel="self" type="application/rss+xml" />
<?php
	$comments = $this->comments;
	foreach ($comments as $comment)
	{
		if (!$comment->approved)
		{
			// Hide comment pending moderation
			continue;
		}
		$comment->software = $this->software;
?>
		<item>
			<title><?php printf(l('Comment by %s'), utf8_encode($comment->author)); ?></title>
			<guid isPermaLink="true"><?php echo $comment->permalink(FALSE); ?></guid>
			<link><?php echo $comment->permalink(FALSE); ?></link>
			<description>
				<![CDATA[
				<p>
					<?php echo utf8_encode($comment->text); ?>
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