		<entry>
			<title><?php echo utf8_encode(unhtmlentities($post->title)); ?></title>
			<id><?php echo $post->permalink(FALSE); ?></id>
			<link href="<?php echo htmlentities($post->permalink(FALSE)); ?>" rel="alternate" type="text/html" />
			<author>
				<name><?php echo utf8_encode($post->author); ?></name>
			</author>
			<summary type="html">
				<![CDATA[
					<p>
						<?php echo utf8_encode($post->summary(FALSE)); ?>
					</p>
					<p>
						<?php echo a(l('Read more...'), array('href' => $post->permalink(FALSE))); ?>
					</p>
				]]>
			</summary>
			<updated><?php echo $post->iso8601_date(); ?></updated>
		</entry>
