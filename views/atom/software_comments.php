		<title>Emeraldion Lodge - <?php printf(l('Comments on %s'), utf8_encode($this->software->title)) ?></title>
		<link href="<?php print htmlentities($this->feed_permalink()); ?>" type="application/atom+xml" rel="self" />
		<id><?php print $this->feed_permalink(); ?></id>
		<updated><?php print date('c'); ?></updated>
		<generator>In house</generator>
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
		<entry>
			<title><?php printf(l('Comment by %s'), utf8_encode($comment->author)); ?></title>
			<id><?php echo $comment->permalink(FALSE); ?></id>
			<link href="<?php echo htmlentities($comment->permalink(FALSE)); ?>" rel="self" type="text/html" />
			<author>
				<name><?php echo htmlentities($comment->author); ?></name>
			</author>
			<summary type="html">
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
			</summary>
			<updated><?php echo $comment->iso8601_date(); ?></updated>
		</entry>
<?php
	}
?>