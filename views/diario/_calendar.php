<?php
	require_once(dirname(__FILE__) . "/../../include/db.inc.php");

/**
 *		Calendario del Diario
 *		---------------------
 *		Mostra una tabella contenente i giorni del mese che hanno articoli
 */
 
 		$year = (isset($_REQUEST['year']) && !empty($_REQUEST['year']) ? $_REQUEST['year'] : date("Y"));
 		$month = (isset($_REQUEST['month']) && !empty($_REQUEST['month']) ? $_REQUEST['month'] : date("m"));
	
		$primo_del_mese = mktime (0, 0, 0, $month, 1, $year);
		$primo = date("w", $primo_del_mese);
		$giorni = date("t", $primo_del_mese);
?>
<script>
	var dt = new Date(<?php echo 1000 * $primo_del_mese; ?>);
	function prevMonth()
	{
		if (dt.getMonth() > 0)
		{
			dt.setMonth(dt.getMonth() - 1);
		}
		else
		{
			dt.setFullYear(dt.getFullYear() - 1);
			dt.setMonth(11);
		}
		
		return !loadMonth();
	}
	function nextMonth()
	{
		if (dt.getMonth() < 11)
		{
			dt.setMonth(dt.getMonth() + 1);
		}
		else
		{
			dt.setFullYear(dt.getFullYear() + 1);
			dt.setMonth(0);
		}
		
		return !loadMonth();
	}
	function loadMonth()
	{
		var url = "/diario/calendar/" +
			dt.getFullYear() + 
			"/" +
			(dt.getMonth() + 1);
		return Servo.load({url:url,
			target:document.getElementById('cal-div')
			});
	}
</script>
<h3 class="throbber" id="month-header"><?php echo l("Calendar"); ?></h3>
<div id="cal-div">
<?php
	$this->render_component(array('action' => 'calendar'));
?>
</div>
<form action="<?php echo $this->url_to_myself(); ?>" style="margin:0 0 2em 0;padding:0">
	<p>
		<label for="f_month"><?php echo l("Go to:"); ?></label>
		<select id="f_month" name="month" onchange="location.href = '/diario/date/' + this.value" style="width:100px">
<?php
	$thetime = time();
	$conn = Db::get_connection();
	$conn->connect();
	$conn->prepare("SELECT MIN(`created_at`) FROM `diario_posts`");
	$conn->exec();
	$mindate = strtotime($conn->result(0));
	if ($mindate)
	{
		while ($thetime >= $mindate)
		{
			$themonth = date("m", $thetime);
			$theyear = date("Y", $thetime);
?>
			<option value="<?php echo $theyear; ?>/<?php echo $themonth; ?>"<?php
		
			if ($theyear == $year &&
				$themonth == $month)
			{
				echo ' selected="selected"';
			}
		?>>
			<?php echo ucwords(strftime("%B %Y", $thetime)); ?>
			</option>
<?php
			$thetime = mktime(0, 0, 0, $themonth - 1, 1, $theyear);
		}
	}
	Db::close_connection($conn);
?>
		</select>
	</p>
</form>