<?php
	$comments = array();
	if (!isset($this->article->diario_comments))
	{
		$this->article->has_many('diario_comments', array('where_clause' => "`approved` = '1' " .
			"OR (`author` = '{$this->credentials['realname']}' " .
			"AND `email` = '{$this->credentials['email']}')"));
	}
	if (is_array($this->article->diario_comments))
	{
		$comments = array_merge($comments, $this->article->diario_comments);
	}
	if (!isset($this->article->diario_pingbacks))
	{
		$this->article->has_many('diario_pingbacks');
	}
	if (is_array($this->article->diario_pingbacks))
	{
		$comments = array_merge($comments, $this->article->diario_pingbacks);
	}
	if (count($comments) > 0)
	{
		usort($comments, array($comments[0], 'sort_comments'));
?>
	<div class="rss-feed">
		<?php echo l('Subscribe to the'); ?>
		<?php $this->link_to(l('Comments RSS Feed'), array('controller' => 'feed', 'action' => 'diario_comments', 'id' => $this->article->id, 'type' => 'rss')); ?>
	</div>
	<h2><?php printf(l('Comments for %s'), $this->article->title); ?></h2>
	<div id="comments">
<?php
		foreach ($comments as $comment)
		{
			if ($comment instanceof DiarioComment)
			{
				$this->render(array('partial' => 'comment', 'object' => $comment));
			}
			else
			{
				if (!$comment->approved)
				{
					// Hide comment pending moderation
					continue;
				}
				$this->render(array('partial' => 'pingback', 'object' => $comment));
			}
		}
?>
	</div>
<?php
	}
?>
