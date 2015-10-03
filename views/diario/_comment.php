<div id="comment-<?php echo $comment->id; ?>"
	class="<?php echo $comment->comment_class(); ?>">
	<div class="lighter" style="float:right">
		<?php printf(l('Comment issued on %s'), $comment->human_readable_date()); ?>
		<a href="<?php echo $comment->permalink(); ?>" title="<?php echo h(l('Permalink for comment')); ?> #<?php echo $comment->id; ?>">#</a>
	</div>
	<h4><?php printf(l('%s says:'), empty($comment->URL) ? $comment->author : a($comment->author, array('href' => $comment->URL))); ?></h4>
	<img class="diario-gravatar" src="<?php echo Gravatar::gravatar_url($comment->email); ?>" alt="Gravatar" />
	<div class="diario-comment-text">
		<p>
			<?php echo $comment->pretty_text(); ?>
		</p>
	</div>
</div>