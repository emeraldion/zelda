<?php
	$this->set_title('Emeraldion Lodge - ' . l('Meta') . ' - ' . l('Hits by host'));
	
	$hosts = $this->hosts;
	if (count($hosts) > 0)
	{
		foreach ($hosts as $host)
		{
			if (empty($host->latitude) || empty($host->longitude))
			{
				continue;
			}
			$this->render(array('partial' => 'geoip', 'object' => $host));
		}
	}
?>