<?php
	$this->set_title('Emeraldion Lodge - 404 Not Found');
?>
<h1>404 Not Found</h1>
<p>
	The page you requested does not exist on the server.
	The link you followed may be outdated, the requested resource may no longer exist or an error occurred.
</p>
<p>
	If you feel this shouldn't have happened, feel free to
	<?php print $this->link_to('report the error', array('controller' => 'contact', 'action' => 'report')); ?>.
</p>
