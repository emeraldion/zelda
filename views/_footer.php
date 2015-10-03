<div class="footer">
	<?php echo $this->link_to('Emeraldion Lodge', array('action' => 'emeraldion_lodge', 'controller' => 'about')); ?>

	<?php echo l('powered by'); ?>

	<?php echo $this->link_to('EmeRails', array('action' => 'emerails', 'controller' => 'about')); ?>

	&copy; 2001-<?php echo date("Y"); ?> Claudio Procida
	&mdash;
	<?php echo $this->link_to(l('Disclaimer'), array('action' => 'disclaimer', 'controller' => 'legal')); ?>

	<div id="consacration">
		Dicatus Regin&aelig; Pacis
	</div>
</div>