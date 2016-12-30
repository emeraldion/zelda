<?php
	$this->set_title("Emeraldion Lodge - " . l('About Emerails'));
?>
<h2>
	<?php echo l("About EmeRails"); ?>
</h2>
<p>
	<a href="https://github.com/emeraldion/emerails" class="external">EmeRails</a> is a PHP web application
	framework I wrote circa February 2008 and improved and maintained since, taking inspiration from
	<a href="http://www.rubyonrails.org" class="external">Ruby on Rails</a>.
	It has a <acronym title="Model View Controller">MVC</acronym> architecture, has an
	<acronym title="Object Relational Mapping">ORM</acronym> layer that mimics ActiveRecord, and separates
	presentation from business logic quite nicely, prioritizing conventions over configuration.
</p>
<p>
	EmeRails supports page caching, action filtering and a lot of useful features that save coding time and
	server load. EmeRails is available on <a href="https://github.com/emeraldion/emerails" class="external">GitHub</a>
	under the <a href="http://opensource.org/licenses/MIT" class="external">MIT</a> license. I'm currently
	in the process of making it container-ready with <a href="https://docs.docker.com/engine/" class="external">Docker</a>.
</p>

<h3>Let me show it off</h3>
<ul>
	<li>
		<?php print a('Show this page without layout markup', array('href' => $this->url_to_myself() . '?nolayout')); ?>.
		This demonstrates how the actions are rendered.
	</li>
	<li>
		<?php print a('Show this page in Morse code', array('href' => $this->url_to_myself() . '?hl=morse')); ?>.
		This demonstrates how filters can be applied to the response before it is served.
	</li>
</ul>
