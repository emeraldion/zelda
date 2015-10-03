	<blockquote>
<?php
	$visits = $this->visits;
	foreach($visits as $visit)
	{
		$this->render(array('partial' => 'visit', 'object' => $visit));
	}
?>
	</blockquote>
