<?php
	if (count($this->referrers) > 0)
	{
?>
<ol id="queries-list">
<?php
		foreach ($this->referrers as $referrer)
		{
?>
	<li>
		<dl>
<?php
			if (!empty($referrer->date))
			{
?>
			<dt><?php echo date("d F Y H:i:s", strtotime($referrer["date"])); ?></dt>
<?php
			}
			else if (!empty($referrer->count))
			{
?>
			<dt><?php printf(l("%s hits"), $referrer['count']); ?></dt>
<?php
			}
?>
			<dd>
				<?php echo a($referrer['referrer'], array('href' => $referrer['referrer'], 'class' => 'external')); ?>
				<span id="info-<?php echo $referrer["id"]; ?>" class="info-button">&nbsp;</span>
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