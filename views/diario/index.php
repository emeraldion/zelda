<div class="rss-feed">
	<?php $this->link_to(l('RSS Feed'), array('controller' => 'feed', 'action' => 'diario', 'type' => 'rss')); ?>
</div>
<?php
	$this->set_title('Emeraldion Lodge - ' . l('Blog'));

	$articles = $this->articles;
	if (count($articles) > 0)
	{
		foreach ($articles as $article)
		{
			if ($article->status != 'pubblicato')
			{
				continue;
			}

			$article->has_many('diario_comments', array('where_clause' => "`approved` = '1' " .
				"OR (`author` = '{$this->credentials['realname']}' " .
				"AND `email` = '{$this->credentials['email']}')"));
			$article->belongs_to('diario_authors');
			$article->has_and_belongs_to_many('tags');
			$comments = $article->diario_comments;
?>
<h2>
	<a class="permalink" href="<?php echo $article->permalink(); ?>"><?php echo $article->title; ?></a>
</h2>
<div class="lighter">
	<a href="<?php echo $article->permalink(); ?>">#</a>
	<?php echo l('Written by'); ?>
	<a href="<?php echo $article->diario_author->permalink(); ?>"><?php echo ucwords($article->author); ?></a>
	<?php echo l('on'); ?>
	<?php echo $article->human_readable_date(); ?>,
	<?php printf(l('read %s times'), $article->readings); ?>.
</div>
<p>
<?php
			echo $article->summary();
?>
</p>
<div class="lighter">
	<?php echo l('Tagged with:'); ?>

<?php
			$tags = $article->tags;
			for ($i = 0; $i < count($tags); $i++)
			{
				print $this->link_to(ucwords($tags[$i]->tag), array('class' => 'token', 'action' => 'tag', 'id' => $tags[$i]->id));
				if ($i < count($tags) - 1)
					print ", ";
			}
?>
</div>
<div class="diario-controls lighter">
	<ul class="plain">
<?php
		if (Login::is_logged_in())
		{
?>
		<li class="plain">
			<?php echo $this->link_to(l('Edit'), array('controller' => 'backend', 'action' => 'diario_post_edit', 'id' => $article->id)); ?>
		</li>
<?php
		}
?>

		<li class="plain">
			<a class="permalink" href="<?php echo $article->permalink(); ?>"><?php echo l('Permalink'); ?></a>
		</li>
		<li class="plain">
			<a class="trackback" rel="nofollow"
				href="<?php echo $article->trackback_url(); ?>"
				title="<?php echo h(l('Use this URI for your Trackback')); ?>"><?php echo l('Trackback URI'); ?></a>
		</li>
		<li class="plain">
			<a class="comment" href="<?php echo $article->comments_permalink(); ?>"><?php printf(l('%s Comments'), count($comments)); ?></a>
		</li>
	</ul>
</div>
<?php
		}
		$this->render(array('partial' => 'prev_next_page'));
	}
	else
	{
		echo em(l('No items'), NULL);
	}
?>
