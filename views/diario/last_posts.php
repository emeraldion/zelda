		<div class="rss-feed">
			<?php $this->link_to(l('RSS Feed'), array('controller' => 'feed', 'action' => 'diario', 'type' => 'rss')); ?>
		</div>
		<h2><?php echo l('Latest Blog Entries'); ?></h2>
<?php
	$articles = $this->articles;
	$count = 0;
	foreach ($articles as $article)
	{
		$article->belongs_to('diario_authors');
?>
		<h3>
			<a class="permalink" href="<?php echo $article->permalink(); ?>"><?php echo $article->title; ?></a>
		</h3>
		<p>
<?php
			echo $article->summary();
?>
		</p>
<?php

		if (++$count > 2)
			break;
	}
?>
	<div class="expander">
		<?php echo $this->link_to(l('Read more...'), array('class' => 'fwd')); ?>
	</div>
