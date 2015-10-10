	<channel>
		<title>Emeraldion Lodge - <?php echo utf8_encode(sprintf(l('Sparkle appcast for %s'), $this->software->title)); ?></title>
		<link><?php echo $this->software->appcast_permalink(); ?></link>
		<description><?php echo utf8_encode(l('Appcast for Sparkle automatic updates.')); ?></description>
		<language>en</language>      
		<item>
			<title><?php echo utf8_encode(sprintf(l('Version %s'), $this->software->release->version)); ?></title>
			<sparkle:releaseNotesLink><?php echo $this->software->releasenotes_permalink(); ?></sparkle:releaseNotesLink>
			<pubDate><?php echo $this->software->release->rfc2822_date(); ?></pubDate>
<?php
	for ($i = 0; $i < count($this->software->release->software_artifacts); $i++)
	{
		$artifact = $this->software->release->software_artifacts[$i];
		if (!$artifact->enabled ||
			$artifact->type() != 'zip')
		{
			continue;
		}
		$artifact->release = $this->software->release;
		$this->render(array('partial' => 'artifact', 'object' => $artifact));
	}
?>
		</item>
	</channel>