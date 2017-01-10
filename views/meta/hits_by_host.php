<?php
	$this->set_title('Emeraldion Lodge - ' . l('Meta') . ' - ' . l('Hits by host'));
?>
<script type="text/javascript" src="<?php print APPLICATION_ROOT; ?>assets/javascript/meta/hits_by_host.js"></script>
<script>
	$(load_data);
</script>
<form id="frm" name="frm" onsubmit="return false">
	<p>
		<label for="f_h"><?php echo l("Max:"); ?></label>
		<input type="text" id="f_h" name="h" size="2" value="32768" />
		
		<label for="f_l"><?php echo l("Min:"); ?></label>
		<input type="text" id="f_l" name="l" size="2"  value="<?php echo isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 3; ?>" />

		<label for="f_t"><?php echo l("Time:"); ?></label>
		<select id="f_t" name="t" onchange="load_data(this.form.load_button)" style="width:50px">
			<option value="hour"><?php echo l("hour"); ?></option>
			<option value="day" selected="selected"><?php echo l("day"); ?></option>
			<option value="week"><?php echo l("week"); ?></option>
			<option value="month"><?php echo l("month"); ?></option>
			<option value="year"><?php echo l("year"); ?></option>
			<option value=""><?php echo l("million years"); ?></option>
		</select>

		<label for="f_f"><?php echo l("IP:"); ?></label>
		<input type="text" id="f_f" name="filter" size="8" onkeyup="filter_hosts(this.value)" value="<?php echo @$_REQUEST['ip']; ?>" />

		<label for="f_p"><?php echo l("Gate:"); ?></label>
		<input type="text" id="f_p" name="p" size="8" />

		<label for="f_r"><?php echo l("Referrer:"); ?></label>
		<input type="text" id="f_r" name="r" size="8" />
		
		<label for="f_u"><?php echo l("Agent:"); ?></label>
		<input type="text" id="f_u" name="u" size="8" />
	</p>
	<p>
		<span class="throbber" id="resolve-progress">
			<input name="load_button" type="button" value="<?php echo h(l("Refresh")); ?>" onclick="load_data(this)" />
			<input name="expand_button" type="button" value="<?php echo h(l("Expand")); ?>" onclick="expand_all()" />
			<!--<input name="collapse_button" type="button" value="<?php echo h(l("Collapse")); ?>" onclick="collapse_all()" />-->
			<input name="kml_button" type="button" value="<?php echo h(l("KML")); ?>" onclick="export_kml()" />
		</span>
	</p>
</form>
<div id="tree-container"></div>