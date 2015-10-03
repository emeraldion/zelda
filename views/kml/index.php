<?php
	$this->set_title('Sample KML file');
	
	$geoips = $this->geoips;
	if (count($geoips) > 0)
	{
		foreach ($geoips as $geoip)
		{
			$this->render(array('partial' => 'geoip', 'object' => $geoip));
		}
	}
?>