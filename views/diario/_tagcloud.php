<h3><?php echo l("Tag cloud"); ?></h3>
<div id="tag-cloud">
<?php
	$tag_factory = new Tag();
	
	$tags = $tag_factory->find_all(array('order_by' => '`tag` ASC'));

	$max = 0;
	
	if (count($tags) > 0)
	{
		foreach ($tags as $tag)
		{
			$tag->has_and_belongs_to_many('diario_posts');
			//print_r($tag);
		
			$max = max($max, count($tag->diario_posts));
		}
	
		foreach ($tags as $tag)
		{
			if (($weight = count($tag->diario_posts)) > 0)
			{
				$style = 'font-size:' . round(($weight / $max * 16) + 10) . 'px';
?>
	<?php echo $this->link_to($tag->tag, array('action' => 'tag', 'id' => $tag->id, 'style' => $style)); ?>
<?php
			}
		}
	}
	else
	{
		echo em(l('No items'), NULL);
	}
?>
</div>