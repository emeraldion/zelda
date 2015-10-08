<div class="prev_next">
<?php
  if (isset($this->next_start) && $this->next_start > 10)
	{
?>
	<a class="fwd"
    href="<?php print $this->url_to(array('query_string' => 'trk=next&start=' . ($this->next_start - 20))); ?>">Newer articles</a>
<?php
	}
  if (isset($this->next_start))
	{
?>
	<a class="back"
    href="<?php print $this->url_to(array('query_string' => 'trk=prev&start=' . ($this->next_start))); ?>">Older articles</a>
<?php
	}
?>
</div>
