<?php
	if (count($this->queries) > 0)
	{
?>
<ol id="queries-list">
<?php
		foreach ($this->queries as $query)
		{
?>
	<li>
		<dl>
<?php
			if (!empty($query->date))
			{
?>
			<dt><?php echo date("d F Y H:i:s", strtotime($query->date)); ?></dt>
<?php
			}
			else if (!empty($query->count))
			{
?>
			<dt><?php printf(l('%s queries'), $query->count); ?></dt>
<?php
			}
?>
			<dd><?php echo $query->term; ?>
<?php
			if (!empty($query->id))
			{
?>
				<span class="info-button" id="info-<?php echo $query->id; ?>">&nbsp;</span>
<?php
			}
?>
			</dd>
		</dl>
	</li>
<?php
		}
?>
</ol>
<?php
	}
	else
	{
?>

	<p class="error centered"><?php echo l('No results'); ?></p>	

<?php
	}
?>