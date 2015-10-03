	<select id="ac_<?php echo $_REQUEST['ip']; ?>" onchange="attribute_visits(this)">
		<option value=""><?php echo l('Choose...'); ?></option>
		<optgroup label="<?php echo h(l('People')); ?>">
<?php
	$people = $this->people;
	foreach ($people as $person)
	{
?>
			<option value="<?php echo $person->id; ?>"><?php echo $person->name; ?></option>
<?php
	}
?>
		</optgroup>
		<option value="0"><?php echo l('Clear'); ?></option>
	</select>