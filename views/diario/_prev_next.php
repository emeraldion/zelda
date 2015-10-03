<div class="prev_next" style="margin-bottom:2em;height:1em">
<?php
	if (($next = $this->article->next()) !== NULL)
	{
?>
	<a class="fwd" style="float:right"
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