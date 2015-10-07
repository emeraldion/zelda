<?php
	$this->set_title("Emeraldion Lodge .o. " . l('About Claudio'));
?>
<h2>
	<?php echo l("Who I am"); ?>
</h2>
<p>
	<?php printf(l("whoiam-para1"), date("Y", mktime(0, 0, 0, date("m") - 4, date("d") - 21, date("Y") - 1978)) - 2000); ?>
</p>
<p>
	<?php echo l("whoiam-para2"); ?>
</p>
<p>
	<?php echo l("whoiam-para3"); ?>
</p>

<h2>
	<?php echo l("What I like"); ?>
</h2>
<p>
	<?php echo l("whatilike-para1"); ?>
</p>

<h2>
	<?php echo l("Contact me"); ?>
</h2>
<p>
	<?php echo l("writeme-para1"); ?>
</p>
