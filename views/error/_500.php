<?php
	$this->set_title('Emeraldion Lodge .o. 500 Internal Server Error');
?>
<h1>500 Internal Server Error</h1>
<p>
	The server encountered an error while processing your request.
</p>
<p>
	If you feel this shouldn't have happened, feel free to
	<?php print $this->link_to('report the error', array('controller' => 'contact', 'action' => 'report')); ?>.
</p>
