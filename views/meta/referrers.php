<?php
	$this->set_title('Emeraldion Lodge .o. ' . l('Meta') . ' .o. ' . l('Referrers'));
?>
<script type="text/javascript">
/*<![CDATA[*/
	function load_referrers(frm)
	{
		return Servo.post({
			form:frm,
			url:'<?php echo $this->url_to(array('action' => 'referrers_list')); ?>',
			target:document.getElementById('referrers_container'),
			oncomplete: add_info_handlers
		});
	}
	
	function add_info_handlers()
	{
		$('span.info-button').click(function(e)
			{
				var me = this;
				Servo.load({
					url: '<?php echo $this->url_to(array('action' => 'id')); ?>?id=' + this.id.substring(this.id.indexOf("-") + 1),
					target: me,
					oncomplete: function() {
						me.className = '';
					}
				});
			});
	}
	
	$(add_info_handlers);
/*]]>*/
</script>
<form method="get" onsubmit="return !load_referrers(this)">
	<p>
		<label for="f_l"><?php echo l('Limit to:'); ?></label>
		<?php print select('l',
			array(10 => 10,
				50 => 50,
				100 => 100,
				500 => 500,
				1000 => 1000),
			isset($_REQUEST['l']) ? $_REQUEST['l'] : 50,
			array('id' => 'f_l',
				'onchange' => 'if (!load_referrers(this.form)) this.form.submit()')); ?>
		
		<label for="f_f"><?php echo l('Filter:'); ?></label>
		<input type="text" id="f_f" name="f" size="12" onkeyup="if (!load_referrers(this.form)) this.form.submit()" />
		
		<input type="checkbox" id="f_g" name="g" onclick="if (!load_referrers(this.form)) this.form.submit()" />
		<label for="f_g"><?php echo l('Group'); ?></label>
		
		<span style="padding-left:100px">
			<input type="submit" value="<?php echo h(l('Refresh')); ?>" />
		</span>
	</p>
</form>
<div id="referrers_container">
<?php
	$this->render_component(array('controller' => 'meta', 'action' => 'referrers_list'));
?>
</div>