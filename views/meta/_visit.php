		<dl class="<?php echo $visit->classname(); ?>">
<?php
				if ($visit->date)
				{
?>
			<dt>Date</dt>
			<dd><?php echo $visit->date; ?></dd>
<?php
				}
				if ($visit->gate)
				{
?>
			<dt>Gate</dt>
			<dd><?php echo Gate::by_URI($visit->gate, $visit->params); ?></dd>
<?php
				}
				if ($visit->ip_addr)
				{
?>
			<dt>Hostname</dt>
			<dd>
				<?php echo Host::by_ip_addr($visit->ip_addr)->hostname; ?>
				[<?php echo $this->link_to($visit->ip_addr, array('action' => 'hits_by_host', 'query_string' => "ip={$visit->ip_addr}&l=1")); ?>]
			</dd>
<?php
				}
				if ($visit->user_agent)
				{
?>
			<dt>User Agent</dt>
			<dd><?php echo $visit->user_agent; ?></dd>
<?php
				}
				if ($visit->referrer)
				{
?>
			<dt>Referrer</dt>
			<dd><?php echo a($visit->referrer, array('href' => $visit->referrer, 'class' => 'external')); ?></dd>
<?php
				}
				if (!empty($visit->person_id))
				{
					$visit->belongs_to('people');
?>
			<dt>Person</dt>
			<dd><?php echo $visit->person->name; ?></dd>
<?php
				}
?>
		</dl>