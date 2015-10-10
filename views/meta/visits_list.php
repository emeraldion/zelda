<?php
	if (count($this->visits) > 0)
	{
?>
<ol id="queries-list">
<?php
		foreach ($this->visits as $visit)
		{
?>
	<li>
<?php
			$this->render(array('partial' => 'visit', 'object' => $visit));
?>
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