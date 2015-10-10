<?php
	if (count($this->blocked_ips) > 0)
	{
?>
<ol id="blocked-ip-list">
<?php
		foreach ($this->blocked_ips as $blocked_ip)
		{
?>
	<li>
		<span class="lighter"><?php echo $blocked_ip->human_readable_date(); ?></span>
		<br />
		<span class="query-term"><del><?php echo $blocked_ip->ip_addr; ?></del></span>
		<span
			id="ub_<?php echo $blocked_ip->id; ?>"
			class="unblock"
			title="<?php print h(sprintf(l('Unblock %s'), $blocked_ip->ip_addr)); ?>"
			onclick="unblock(this)"></span>
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