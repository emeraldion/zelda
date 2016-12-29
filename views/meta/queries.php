<?php
	$this->set_title('Emeraldion Lodge - ' . l('Meta') . ' - ' . l('Queries'));
?>
<script src="/assets/javascript/meta/queries.js"></script>
<script>
	$(reload_queries);
</script>
<form id="queries-frm" onsubmit="reload_queries(); return false">
	<p>
		<label for="f_l"><?php echo l('Limit to:'); ?></label>
<?php
	print select('l',
		array(10 => 10,
				50 => 50,
				100 => 100,
				500 => 500,
				1000 => 1000),
		isset($_REQUEST['l']) ? $_REQUEST['l'] : 50,
		array('id' => 'f_l',
			'onchange' => 'reload_queries(this.form)'));
?>

		<label for="f_q"><?php echo l('Filter:'); ?></label>
		<input type="text" id="f_q" name="q" size="12" value="<?php echo @$_REQUEST["q"]; ?>" onkeyup="reload_queries(this.form)" />

		<input type="checkbox" onchange="reload_queries(this.form)" id="f_g" name="g" value="y" />
		<label for="f_g"><?php echo l('Group'); ?></label>

		<span id="throbber" style="padding-left:100px">
			<input type="submit" value="<?php echo h(l('Refresh')); ?>" />
			<input type="button" onclick="queries_csv(this.form)" value="<?php echo h(l('CSV')); ?>" />
		</span>
	</p>
</form>

<div id="queries-list-container">
</div>