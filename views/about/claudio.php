<?php
	$this->set_title("Emeraldion Lodge .o. " . l('About Claudio'));
?>
<script type="text/javascript">
/*<![CDATA[*/
	$(function ()
		{
			var preloadImage = new Image();
			preloadImage.src = '/assets/images/about/primula_47a.png';
			$('#primula_toggler').click(function()
				{
					Servo.load({
						url: '<?php echo $this->url_to(array('action' => 'primula_toggle')); ?>',
						oncomplete: function()
						{
							$('#about_image').attr('src', '/assets/images/about/primula_47a.png');
							$('#primula_toggler').hide();
						}});
				});
		});
/*]]>*/
</script>
<div class="navbox">
	<div class="clear">
	</div>

	<div style="float: left; width: 290px;position:relative">
		<img id="about_image" src="/assets/images/about/primula_47b.png" style="margin: 50px 0 0 0" alt="???" title="???"/>
		<img id="primula_toggler"
			src="/assets/images/about/primula_47_toggler.png"
			title="<?php echo h(l('Do not click me')); ?>"
			alt="!!!" />
		<p class="caption"><?php echo l("Picture:"); ?> ???</p>
	</div>
	<div style="margin: 0 20px 0 310px">
		<h2>
			<?php echo l("Who I am"); ?>
		</h2>
		<p>
			<?php printf(l("whoiam-para1"), date("Y", mktime(0, 0, 0, date("m") - 4, date("d") - 21, date("Y") - 1978)) - 2000); ?>
		</p>
		<p>
			<?php echo l("whoiam-para2"); ?>
		</p>
		<p>
			<?php echo l("whoiam-para3"); ?>
		</p>

		<h2>
			<?php echo l("What I like"); ?>
		</h2>
		<p>
			<?php echo l("whatilike-para1"); ?>
		</p>

		<h2>
			<?php echo l("Contact me"); ?>
		</h2>
		<p>
			<?php echo l("writeme-para1"); ?>
		</p>

	</div>
	<div class="clear">
	</div>
</div>
