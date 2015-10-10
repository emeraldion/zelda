<?php
	require_once(dirname(__FILE__) . "../../models/blogroll_entry.php");
?>

<h3><?php echo l("Blogroll"); ?></h3>
<?php
	$blogroll_factory = new BlogrollEntry();
	$entries = $blogroll_factory->find_all(array('order_by' => '`created_at` DESC'));
?>
<ul>
<?php
	if (count($entries) > 0)
	{
		foreach ($entries as $entry)
		{
?>
	<li>
		<?php echo a($entry->title, array('href' => $entry->URL, 'class' => 'external')); ?>

	</li>
<?php
		}
	}
?>
</ul>