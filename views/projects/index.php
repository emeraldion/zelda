<?php
  $this->set_title('Emeraldion Lodge - ' . l('Projects'));
?>
<h2>Projects</h2>
<ul>
<?php
  foreach($this->projects as $project)
  {
?>
  <li><a href="#<?php print joined_lower($project->name); ?>"><?php print $project->name; ?></a> &ndash; <?php print $project->summary; ?></li>
<?php
  }
?>
</ul>

<?php
  foreach($this->projects as $project)
  {
?>
<a name="<?php print joined_lower($project->name); ?>"></a>
<h2><a target="_blank" href="<?php print $project->url; ?>"><?php print $project->name; ?></a></h2>
<h4><?php print $project->summary; ?></h4>
<?php
  print $project->description;
?>
<div class="lighter">
  Tags: <?php print implode(', ', array_map(function($item)
  {
    return ucwords($item->tag);
  }, $project->tags)); ?>.
</div>
<?php
  }
?>