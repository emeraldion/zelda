<?php
	$about_sections = array(
		array('title' => 'Claudio',
			'action' => 'claudio'),
		array('title' => 'Emeraldion Lodge',
			'action' => 'emeraldion_lodge'),
		);
?>
	<ul class="subnavbar">
<?php
	$i = 0;
	$subnavbar_length = count($about_sections);
	foreach ($about_sections as $section)
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
