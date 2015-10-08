		<title>Emeraldion Lodge - <?php echo l('Software'); ?></title>
		<link href="<?php print htmlentities($this->feed_permalink()); ?>" type="application/atom+xml" rel="self" />
		<id><?php print $this->feed_permalink(); ?></id>
		<updated><?php print date('c'); ?></updated>
		<generator>In house</generator>
<?php
	foreach ($this->releases as $release)
	{
		$release->belongs_to('softwares');
		$software = $release->software;
?>
		<entry>
			<title><?php echo utf8_encode($software->title); ?> <?php echo $release->version; ?></title>
			<id><?php echo $software->permalink(FALSE); ?></id>
			<link href="<?php echo htmlentities($software->permalink(FALSE)); ?>" rel="alternate" type="text/html" />
			<author>
				<name>claudio</name>
			</author>
			<summary type="html">
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
			</summary>
<?php
// TODO: figure out how to include enclosures into Atom
/*
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
*/
?>
			<updated><?php echo $release->iso8601_date(); ?></updated>
		</entry>
<?php
	}
?>