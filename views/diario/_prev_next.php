<div class="prev_next">
<?php
	if (($next = $this->article->next()) !== NULL)
	{
?>
	<a class="fwd"
		href="<?php print $next->permalink(); ?>?trk=next"><?php print $next->title; ?></a>
<?php
	}
	if (($prev = $this->article->previous()) !== NULL)
	{
?>
	<a class="back"
		href="<?php print $prev->permalink(); ?>?trk=prev"><?php print $prev->title; ?></a>
<?php
	}
?>
</div>
