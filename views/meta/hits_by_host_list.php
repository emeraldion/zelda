<?php
	$hosts = $this->hosts;
	foreach ($hosts as $host)
	{
		echo "{$host->ip_addr}:{$host->hostname}:{$host->weight}\n";
	}
?>