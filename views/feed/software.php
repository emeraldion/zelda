		<title>Emeraldion Lodge .o. <?php echo l('Software'); ?></title>
		<link><?php print $this->feed_permalink(); ?></link>
		<description><?php echo utf8_encode(l('Latest software releases by Emeraldion Lodge.')); ?></description>
		<language>en</language>
		<copyright>Copyright 2001-<?php echo date("Y"); ?>, Claudio Procida</copyright>
		<webMaster>webmaster@emeraldion.it (Emeraldion Lodge Webmaster)</webMaster>
		<pubDate><?php print date('r'); ?></pubDate>
		<lastBuildDate><?php print date('r'); ?></lastBuildDate>
		<category>Software</category>
		<generator>In house</generator>
		<atom:link href="<?php print $this->feed_permalink(); ?>" rel="self" type="application/rss+xml" />
<?php
	foreach ($this->releases as $release)
	{
		$release->belongs_to('softwares');
		$software = $release->software;
?>
		<item>
			<title><?php echo utf8_encode($software->title); ?> <?php echo $release->version; ?></title>
			<guid isPermaLink="true"><?php echo $software->permalink(FALSE); ?></guid>
			<link><?php echo $software->permalink(FALSE); ?></link>
			<description>
				<![CDATA[
				<p><?php echo utf8_encode($software->description); ?></p>
<?php
		if (!empty($release->changes))
		{
?>
				<h3><?php printf(l('What&rsquo;s new in version %s?'), $release->version); ?></h3>
				<ul>
<?php
				$changes = explode("\r\n", $release->changes);
				foreach ($changes as $change)
				{
?>
					<li><?php echo utf8_encode(h($change)); ?></li>
<?php
				}
?>
				</ul>
<?php
		}
?>
				<p>
					<a href="<?php echo $software->permalink(FALSE); ?>"><?php echo $software->title; ?></a> |
<?php
		switch ($software->license)
		{
			case "shareware":
			case "commercial":
?>
					<?php echo a(l('Register'), array('href' => $software->registration_permalink(FALSE))); ?> |
<?php
				break;
			default:
?>
					<?php echo a(l('Donate'), array('href' => $software->donate_permalink(FALSE))); ?> |
<?php
				break;
		}
?>
					<?php echo a(l('Comments'), array('href' => $software->comments_permalink(FALSE))); ?>
				</p>
			]]>
			</description>
<?php
		$release->has_many('software_artifacts');
		if (count($release->software_artifacts) > 0)
		{
			foreach ($release->software_artifacts as $artifact)
			{
				if ($artifact->enabled &&
					$artifact->visible)
				{
					$artifact->release = $release;
					$this->render(array('partial' => 'artifact', 'object' => $artifact));
				}
			}
		}
?>
			<pubDate><?php echo $release->rfc2822_date(); ?></pubDate>
		</item>
<?php
	}
?>