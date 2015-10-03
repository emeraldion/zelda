<Placemark>
	<name><?php echo $geoip->hostname; ?></name>
	<visibility>1</visibility>
	<Snippet>
	<![CDATA[
		<?php echo $geoip->city; ?>
	]]>
	</Snippet>
	<description>
	<![CDATA[
		<h3><?php echo $geoip->ip_addr; ?></h3>
		<table>
<?php
			foreach ($geoip as $key => $value)
			{
				$key = ucwords(str_replace('_', ' ', $key));
?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $value; ?></td>
			</tr>
<?php
			}
?>
		</table>
	]]>
	</description>
	<Point>
		<extrude>1</extrude>
		<altitudeMode>relativeToGround</altitudeMode>
		<coordinates><?php echo $geoip->longitude . "," . $geoip->latitude . "," . $geoip->altitude . "\n"; ?></coordinates>
	</Point>
</Placemark>