<?php
	$this->set_title('Emeraldion Lodge .o. Services');
?>
<h2>Services</h2>
<p>
	I have more than eight years experience in web development.
	When I started, there was just HTML and some odd-looking tiled background images.
	I have then seen the birth of languages, standards, tools, and trends.
	Those things pass. What really matters is requirements analysis, functionality design,
	best programming practices and using the right tool for the job.
</p>

<h2>Web development</h2>
<p>
	My services range from the design and development from the ground of personal and
	SMB corporate internet/intranet web applications to the development of customized software solutions.
	I am really strong in LAMP development, master of Javascript with excellent AJAX skills.
	My primary web language is PHP, but I do not disregard other technologies like Java, Ruby etc.
</p>

<h2>Cocoa software development</h2>
<p>
	I am particularly good at Cocoa and Mac software development. From 2005, I have written
	more than 10,000 lines of code that runs everyday on more than <?php
	
		$count = SoftwareArtifact::total_downloads();
		$count_rounded = 1000 * floor($count / 1000);
		print number_format($count_rounded, 0, '.', ',');
	
	?> Macintosh computers<sup>(<a href="#note-1">1</a>)</sup>
	all over the world.
	If you need some expertise with Cocoa development, I may be the right guy for you.
</p>

<h2>Italian localization</h2>
<p>
	I have localized several applications developed by myself, and contributed to localize application written by others as well.
	Do you need help with Italian localization for your application? I&rsquo;ll be glad to help you.
</p>

<ol id="footnotes">
	<li id="note-1">Guessed estimate based on total number of software downloads from may 2005.</li>
</ol>

<?php
	//print $this->render_component(array('controller' => 'portfolio', 'action' => 'latest_works'));
?>