<?php
	foreach ($this->search_results as $result)
	{
?>
	<div class="search-result"
		onclick="location.href='<?php print $result->permalink(); ?>'">
		<div class="lighter">
			<?php echo $result->human_readable_date(); ?>
		</div>
		<div>
			<?php echo a($result->title, array('href' => $result->permalink() . '?term=' . urlencode($_REQUEST['term']))); ?>
		</div>
	</div>
<?php
	}
?>
