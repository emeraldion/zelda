<?php
	require_once(dirname(__FILE__) . "../../models/book.php");
?>

<h3><?php echo l("Books"); ?></h3>
<p>
	<?php echo l("diario-books-caption"); ?>
</p>
<?php
	$book_factory = new Book();
	$book_kinds = array("essay" => l("Essays"),
		"novel" => l("Novels"),
		"computer" => l("Computer Books"));

	foreach ($book_kinds as $kind => $title)
	{
?>
<h4><?php echo $title ?></h4>
<?php
		$books = $book_factory->find_all(array('where_clause' => "`kind` = '{$kind}'",
			'order_by' => '`date` DESC',
			'limit' => 3));
		if (count($books) > 0)
		{
?>
<ul>
<?php
			foreach ($books as $book)
			{
?>
	<li>
		<?php echo $book->permalink(); ?>
	</li>
<?php
			}
?>
</ul>
<?php
		}
	}
?>
<p>
	<a href="<?php echo $this->url_to(array('controller' => 'contact')); ?>?subject=<?php echo urlencode(l('I suggest you a book')); ?>"><?php echo l("diario-book-suggest"); ?></a>
</p>