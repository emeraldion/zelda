<?php
	$this->set_title('Emeraldion Lodge .o. ' . l('Home'));
?>
<div class="section">
	<h2><?php echo l('Welcome!'); ?></h2>
	<p>
		<?php echo l('welcome-para1'); ?>
	</p>
	<p>
		<?php echo l('Care to know a little more'); ?>
		<?php echo $this->link_to(l('about me?'), array('controller' => 'about', 'action' => 'claudio')); ?>
	</p>
</div>
<div class="section">
<?php
	$this->render_component(array('controller' => 'software', 'action' => 'last_releases'));
?>
</div>