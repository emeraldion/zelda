<?php
	$this->set_title('Emeraldion Lodge .o. 404 Not Found');
?>
<h1>404 Not Found</h1>
<p>
	The page you requested does not exist on this server.
	The link you followed may be outdated, the requested resource may no longer exist or an error occurred.
</p>
<p>
	If you feel this shouldn't have happened and want to report the error,
	feel free to
	<?php print $this->link_to('contact the webmaster', array('controller' => 'contact')); ?>.
</p>