<div id="pingback-<?php echo $pingback->id; ?>"
	class="<?php echo $pingback->comment_class(); ?>">
	<div class="lighter" style="float:right">
		<?php printf(l('Pingback issued on %s'), $pingback->human_readable_date()); ?>
		<a href="<?php echo $pingback->permalink(); ?>" title="<?php echo h(l('Permalink for pingback')); ?> #<?php echo $pingback->id; ?>">#</a>
	</div>
	<h4><?php print a($pingback->title, array('href' => $pingback->url)); ?></h4>
	<div class="diario-pingback-text">
		<p>
			<?php echo $pingback->pretty_excerpt(); ?>
		</p>
	</div>
</div>