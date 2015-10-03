<h3><?php echo l("Feeds"); ?></h3>
<div>
	<ul id="feeds-list">
		<li>
			<?php echo $this->link_to(l('Software'), array('action' => 'software', 'type' => 'rss')); ?>
			(<a class="external" href="http://feedvalidator.org/check.cgi?url=http%3A//www.emeraldion.it<?php echo $this->url_to(array('action' => 'software', 'type' => 'rss')); ?>"><acronym title="Really Simple Syndication">RSS</acronym> 1.0</a>)
		</li>
		<li>
			<?php echo $this->link_to(l('Software'), array('controller' => 'atom', 'action' => 'software', 'type' => 'atom')); ?>
			(<a class="external" href="http://feedvalidator.org/check.cgi?url=http%3A//www.emeraldion.it<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'software', 'type' => 'atom')); ?>">Atom</a>)
		</li>
		<li>
			<?php echo $this->link_to(l('Blog'), array('action' => 'diario', 'type' => 'rss')); ?>
			(<a class="external" href="http://feedvalidator.org/check.cgi?url=http%3A//www.emeraldion.it<?php echo $this->url_to(array('action' => 'diario', 'type' => 'rss')); ?>"><acronym title="Really Simple Syndication">RSS</acronym> 1.0</a>)
		</li>
		<li>
			<?php echo $this->link_to(l('Blog'), array('controller' => 'atom', 'action' => 'diario', 'type' => 'atom')); ?>
			(<a class="external" href="http://feedvalidator.org/check.cgi?url=http%3A//www.emeraldion.it<?php echo $this->url_to(array('controller' => 'atom', 'action' => 'diario', 'type' => 'atom')); ?>">Atom</a>)
		</li>
	</ul>
</div>
