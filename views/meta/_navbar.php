<?php
	$meta_sections = array(
		array('title' => l('Visits'),
			'action' => 'visits'),
		array('title' => l('Queries'),
			'action' => 'queries'),
		array('title' => l('Referrers'),
			'action' => 'referrers'),
		array('title' => l('Outbounds'),
			'action' => 'outbounds'),
		array('title' => l('Hits by host'),
			'action' => 'hits_by_host'),
		array('title' => l('Blocked IPs'),
			'action' => 'blocked_ips'),
		);
?>
	<ul class="subnavbar">
<?php
	$i = 0;
	$subnavbar_length = count($meta_sections);
	foreach ($meta_sections as $section)
	{
		$classname = "subnavitem";
		if ($section['action'] == $_REQUEST['action'])
		{
			$classname .= " this-subnavitem";
		}
		if ($i == 0)
		{
			$classname .= " subnavfirst";
		}
		else if ($i == $subnavbar_length - 1)
		{
			$classname .= " subnavlast";
		}
?>
		<li>
			<?php echo $this->link_to($section['title'], array('class' => $classname, 'action' => $section['action'])); ?>
		</li>
<?php
		$i++;
	}
?>
	</ul>
