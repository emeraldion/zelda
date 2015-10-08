<div class="footer">
	<ul class="social-icons">
		<li><a target="_blank" class="github" href="https://github.com/claudiopro" title="claudiopro on GitHub"></a></li>
		<li><a target="_blank" class="codepen" href="https://codepen.io/claudiopro" title="claudiopro on Codepen"></a></li>
		<li><a target="_blank" class="twitter" href="https://twitter.com/claudiopro" title="claudiopro on Twitter"></a></li>
		<li><a target="_blank" class="instagram" href="https://instagram.com/alpeia" title="alpeia on Instagram"></a></li>
		<li><a target="_blank" class="flickr" href="https://flickr.com/claudiopro" title="claudiopro on Flickr"></a></li>
		<li><a target="_blank" class="youtube" href="https://www.youtube.com/claudiopro" title="claudiopro on Youtube"></a></li>
		<li><a target="_blank" class="linkedin" href="https://linkedin.com/in/claudioprocida" title="Claudio Procida on LinkedIn"></a></li>
	</ul>

	<?php echo $this->link_to('Emeraldion Lodge', array('action' => 'emeraldion_lodge', 'controller' => 'about')); ?>

	<?php echo l('powered by'); ?>

	<?php echo $this->link_to('EmeRails', array('action' => 'emerails', 'controller' => 'about')); ?>

	&copy; 2001-<?php echo date("Y"); ?> Claudio Procida
	&mdash;
	<?php echo $this->link_to(l('Disclaimer'), array('action' => 'disclaimer', 'controller' => 'legal')); ?>
</div>
