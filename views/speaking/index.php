<?php
  $this->set_title('Emeraldion Lodge - ' . l('Speaking'));
?>
<h2>Speaking</h2>
<p>Here is a selection of decks and recordings from my public speaking activity. I sometimes speak at tech meetups and user groups, and rarely at conferences. I also like to go out to schools and technology fairs to advocate <acronym title="Science, Technology, Engineering, and Mathematics">STEM</acronym> careers and increase participation by girls, underrepresented minorities, and special needs children.</p>

<?php
	foreach ($this->talks as $talk)
	{
?>

<section>
	<h3><?php print $talk->title; ?></h3>
	<div class="lighter"><?php printf('%s, %s', $talk->location, $talk->pretty_date()); ?></div>

<?php
		print $talk->description;
?>

<?php
		foreach ($talk->youtube_videos as $video)
		{
?>
	<iframe class="speaking-item" src="<?php print $video->url; ?>" frameborder="0" allowfullscreen></iframe>
<?php
		}
?>

<?php
		foreach ($talk->vimeo_videos as $video)
		{
?>
	<iframe class="speaking-item" src="<?php print $video->url; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<?php
		}
?>

<?php
		foreach ($talk->speakerdeck_decks as $deck)
		{
?>
	<div class="speaking-item">
<?php
	print $deck->script_tag;
?>
	</div>

<?php
		}
?>

</section>

<?php
	}
?>
