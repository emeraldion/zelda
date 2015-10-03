<h3><?php echo l("Meta"); ?></h3>
<ul>
	<li><?php print $this->link_to(l("Hits by host"), array('controller' => 'meta', 'action' => 'hits_by_host')); ?></li>
	<li><?php print $this->link_to(l("Queries"), array('controller' => 'meta', 'action' => 'queries')); ?></li>
	<li><?php print $this->link_to(l("Referrers"), array('controller' => 'meta', 'action' => 'referrers')); ?></li>
	<li><a href="http://validator.w3.org/check?uri=referer"
		class="external"><?php echo l("Valid"); ?> <acronym title="eXtensible HyperText Markup Language">XHTML</acronym> 1.0</a></li>
	<li><a onclick="this.href+=encodeURIComponent(location.href); return true"
		href="http://jigsaw.w3.org/css-validator/validator?uri="
		class="external"><?php echo l("Valid"); ?> <acronym title="Cascading Style Sheets">CSS</acronym></a></li>
	<li><?php print $this->link_to(l("My vCard"), array('controller' => 'services', 'action' => 'vcf')); ?></li>
</ul>