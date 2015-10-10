<?php
	if (count($this->outbounds) > 0)
	{
?>
<ol id="queries-list">
<?php
		foreach ($this->outbounds as $outbound)
		{
?>
	<li>
		<dl>
<?php
			if (isset($outbound->count))
			{
?>
			<dt><?php printf(l("%s hits"), $outbound->count); ?></dt>
<?php
			}
			else
			{
?>
			<dt><?php echo date("d F Y H:i:s", strtotime($outbound->occurred_at)); ?></dt>
<?php
			}
?>
			<dd>
				<?php echo a($outbound->url, array('href' => $outbound->url, 'class' => 'external')); ?>
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