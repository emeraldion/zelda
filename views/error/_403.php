<?php
	$this->set_title('Emeraldion Lodge - 403 Forbidden');
?>
<h1>403 Forbidden</h1>
<p>
	You are not allowed to read the page you requested.
	You don't have sufficient rights to obtain the requested resource,
	and the server has been instructed to not let you have it.
</p>
<p>
	If you feel this shouldn't have happened, feel free to
	<?php print $this->link_to('report the error', array('controller' => 'contact', 'action' => 'report')); ?>.
</p>
