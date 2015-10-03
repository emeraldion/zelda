<?php
	$this->set_title('Emeraldion Lodge .o. ' . l('Meta') . ' .o. ' . l('Blocked IPs'));
?>
<script type="text/javascript">
/*<![CDATA[*/

	function setup()
	{
		$('#f_q').keyup(function(e)
		{
			reload_blocked_ips();
		});
		$('#queries-frm').submit(function(e)
		{
			return reload_blocked_ips();
		});
		$('#f_block').click(function(e)
		{
			var ip = prompt('<?php echo s(l('Enter the IP address')); ?>', '');
			if (ip.match(/^(\d{1,3}\.){3}\d{1,3}$/))
			{
				Servo.load({url:"/meta/block_ip.html?ip="+encodeURIComponent(ip),oncomplete:function(resp){alert(resp);reload_blocked_ips()}});
			}
		});
		reload_blocked_ips();
	}
	
	function reload_blocked_ips()
	{
		return !Servo.load(
			{
				url: '<?php print $this->url_to(array('action' => 'blocked_ips_list')); ?>?q='
					+ encodeURIComponent($('#f_q').val()),
				target: document.getElementById('blocked-ips-list-container')
			});
	}
	
	function unblock(sender)
	{
		var id = sender.id.substring(3);
		if (confirm("<?php echo h(l('Sbloccare questo indirizzo IP?')); ?>"))
		{
			Servo.load({
				url: "/meta/unblock_ip/" + encodeURIComponent(id),
				oncomplete: reload_blocked_ips});
		}
	}
	
	$(setup);
/*]]>*/
</script>
<form id="queries-frm">
	<p>
		<label class="left-aligned" for="f_q"><?php echo l('Filter:'); ?></label>
		<input type="text" id="f_q" name="q" size="12" value="<?php echo @$_REQUEST["q"]; ?>" />
		
		<span id="throbber" style="padding-left:100px">
			<input type="submit" value="<?php echo h(l('Refresh')); ?>" />
			<input type="button" id="f_block" value="<?php echo h(l('Block IP')); ?>" />
		</span>
	</p>
</form>

<div id="blocked-ips-list-container">
</div>