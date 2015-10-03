<?php
	require_once(dirname(__FILE__) . "/../../include/db.inc.php");
	
	$conn = Db::get_connection();

	$conn->connect();

	$month = (isset($_REQUEST["month"]) && !empty($_REQUEST["month"]) && is_numeric($_REQUEST["month"])) ?
		$_REQUEST["month"] :
		date("m");

	$day = (isset($_REQUEST["day"]) && !empty($_REQUEST["day"]) && is_numeric($_REQUEST["day"])) ?
		$_REQUEST["day"] :
		date("d");

	$year = (isset($_REQUEST["year"]) && !empty($_REQUEST["year"]) && is_numeric($_REQUEST["year"])) ?
		$_REQUEST["year"] :
		date("Y");

	$primo_del_mese = mktime(0, 0, 0, $month, 1, $year);
	$primo = date("w", $primo_del_mese);
	$giorni = date("t", $primo_del_mese);
	$mese_seguente = mktime(0, 0, 0, $month + 1, 1, $year);
	$mese_precedente = mktime(0, 0, 0, $month - 1, 1, $year);
?>
<table id="calendario-month-header" style="margin-bottom:1em" width="100%">
	<tr>
		<td>
			<?php echo $this->link_to_remote('&nbsp;',
				array('class' => 'back',
					'target' => 'cal-div',
					'href' => '/diario/date/' . date("Y/m/", $mese_precedente),
					'remote_url' => '/diario/calendar/' . date("Y/m/", $mese_precedente))); ?>
		</td>
		<td align="center">
			<h4 style="margin: 0">
				<?php
					/*print $this->link_to_remote(ucwords(strftime("%B %Y", $primo_del_mese)),
				array('target' => 'center-column',
					'href' => '/diario/date/' . date("Y/m/", $primo_del_mese),
					'remote_url' => '/diario/date/' . date("Y/m/", $mese_precedente) . '?layout=false'));*/
					print $this->link_to(ucwords(strftime("%B %Y", $primo_del_mese)),
				array('href' => '/diario/date/' . date("Y/m/", $primo_del_mese))); ?>
			</h4>
		</td>
		<td>
<?php
	if (time() > $mese_seguente)
	{
		echo $this->link_to_remote('&nbsp;',
				array('class' => 'fwd',
					'target' => 'cal-div',
					'href' => '/diario/date/' . date("Y/m/", $mese_seguente),
					'remote_url' => '/diario/calendar/' . date("Y/m/", $mese_seguente)));
	}
?>
		</td>
	</tr>
</table>
<table id="calendario" width="100%">
	<tr>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 1, 2007))), 0, 2)); ?></th>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 2, 2007))), 0, 2)); ?></th>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 3, 2007))), 0, 2)); ?></th>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 4, 2007))), 0, 2)); ?></th>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 5, 2007))), 0, 2)); ?></th>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 6, 2007))), 0, 2)); ?></th>
		<th align="center"><?php echo l(substr(ucwords(strftime("%a", mktime(0,0,0, 4, 7, 2007))), 0, 2)); ?></th>
	</tr>
	<tr>
<?php
	for ($i = 0; $i < $primo; $i++) // Spazi vuoti all'inizio del mese
	{
?>
		<td></td>
<?php
	}
	$today = mktime (0, 0, 0, date("m"), date("d"), date("Y"));
	for ($i = 1; $i <= $giorni; $i++) // Vai con i giorni
	{
		$giorno = mktime (0, 0, 0, $month, $i, $year);
		$class = "day";
		$class .= ($giorno == $today) ? " today" : "";
		$conn->prepare("SELECT * FROM `diario_posts` WHERE `status` = 'pubblicato' " .
			" AND YEAR(`created_at`) = '{1}'" .
			" AND MONTH(`created_at`) = '{2}'" .
			" AND DAYOFMONTH(`created_at`) = '{3}'",
			date("Y", $giorno),
			date("m", $giorno),
			date("d", $giorno));
		$conn->exec();

		if ($conn->num_rows() > 0)
		{
?>
		<td align="center" class="<?php echo $class; ?>"><a href="/diario/date/<?php echo date("Y/m/d/", $giorno); ?>"><?php echo $i; ?></a></td>
<?php
		}
		else
		{
?>
		<td align="center" class="<?php echo $class; ?>"><?php echo $i; ?></td>
<?php
		}
		$conn->free_result();
		if (($i + $primo) % 7 == 0 && $i != $giorni)
		{
?>
	</tr>
	<tr>
<?php
		}
	}
	Db::close_connection($conn);
?>
	</tr>
</table>