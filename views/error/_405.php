<?php
	$this->set_title('Emeraldion Lodge - 405 Method Not Allowed');
?>
<h1>405 Method Not Allowed</h1>
<p>
	The HTTP method used to access the requested resource is not allowed.
</p>
<p>
	If you feel this shouldn't have happened, feel free to
	<?php print $this->link_to('report the error', array('controller' => 'contact', 'action' => 'report')); ?>.
</p>
