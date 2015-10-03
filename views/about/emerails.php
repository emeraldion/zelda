<?php
	$this->set_title("Emeraldion Lodge .o. " . l('About Emerails'));
?>
<div class="navbox">
	<div class="clear">
	</div>

	<div style="float: left; width: 290px; text-align:center">
		<img src="/assets/images/about/emerails_code_snippet.png"
			style="margin: 20px 0 0 0" alt="EmeRails code snippet" title="EmeRails code snippet" />
		<p class="caption"><?php echo l("Picture:"); ?> ???</p>
	</div>
	<div style="margin: 0 20px 0 310px">
		<h2>
			<?php echo l("About EmeRails"); ?>
		</h2>
		<p>
			In the middle of February 2008, I became unsatisfied with the current homebrew framework I was using for
			the Emeraldion Lodge, EmePavilion. I felt the need for a solid platform that was object-oriented, fully
			<acronym title="Model View Controller">MVC</acronym> compliant, and had an
			<acronym title="Object Relational Mapping">ORM</acronym> layer that relieved me from having to hardcode
			repetitive query patterns.
		</p>
		<p>
			I then tried to write from scratch a lightweight clone of
			<a href="http://www.rubyonrails.org" class="external">Ruby on Rails</a>,
			by replicating much of their ActiveRecord model class, and a convention-based development model.
			I struggled against the syntactical and practical limitations of the language I am bound to with my hosting,
			<a href="http://www.php.net" class="external">PHP</a>, but at the end I had a working framework in less
			than a month.
		</p>
		<p>
			EmeRails supports page caching, action filtering and a lot of useful features that save coding time and
			server load.
			I am quite satisfied about the result, and I am looking forward to improving it and smudging the edges
			that are still rough in the future.
		</p>
		
		<h3>Let&rsquo;s show off!</h3>
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
	</div>
	<div class="clear">
	</div>
</div>