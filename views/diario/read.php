<?php
	$this->article->has_many('diario_comments', array('where_clause' => "`approved` = '1' " .
		"OR (`author` = '{$this->credentials['realname']}' " .
		"AND `email` = '{$this->credentials['email']}')"));
	$this->article->belongs_to('diario_authors');
	// $this->article->has_and_belongs_to_many('tags');
	$comments = $this->article->diario_comments;

	$this->set_title('Emeraldion Lodge .o. ' . l('Diario') . " .o. {$this->article->title}");

	// $this->render(array('partial' => 'prev_next'));
?>
<div class="rss-feed">
	<?php echo l('Subscribe to the'); ?>
	<?php $this->link_to(l('Diario RSS Feed'), array('controller' => 'feed', 'action' => 'diario', 'type' => 'rss')); ?>
</div>
<!--
	<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
		xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
		<rdf:Description
			rdf:about="<?php echo $this->article->permalink(FALSE); ?>"
			dc:identifier="<?php echo $this->article->permalink(FALSE); ?>"
			dc:title="<?php echo h($this->article->title); ?>"
			trackback:ping="<?php echo $this->article->trackback_url(); ?>" />
	</rdf:RDF>
-->
<h2>
	<a class="permalink" href="<?php echo $this->article->permalink(); ?>"><?php echo $this->article->title; ?></a>
</h2>
<div class="lighter">
	<a href="<?php echo $this->article->permalink(); ?>">#</a>
	<?php echo l('Written by'); ?>
	<a href="<?php echo $this->article->diario_author->permalink(); ?>"><?php echo ucwords($this->article->author); ?></a>
	<?php echo l('on'); ?>
	<?php echo $this->article->human_readable_date(); ?>
	(<?php printf(l('%s readings'), $this->article->readings); ?>)
</div>
<div class="diario-text">
<?php
			echo $this->article->text;
?>
</div>
<!--div class="lighter">
	<?php echo l('Tag:'); ?>

<?php
	// $tags = $this->article->tags;
	// for ($i = 0; $i < count($tags); $i++)
	// {
	// 	print $this->link_to(ucwords($tags[$i]->tag), array('class' => 'token', 'action' => 'tag', 'id' => $tags[$i]->id));
	// 	if ($i < count($tags) - 1)
	// 		print ", ";
	// }
?>
</div-->
<div class="diario-controls lighter">
	<ul class="plain">
<?php
	if (Login::is_logged_in())
	{
?>
		<li class="plain">
			<?php echo $this->link_to(l('Edit'), array('controller' => 'backend', 'action' => 'diario_post_edit', 'id' => $this->article->id)); ?>
		</li>
<?php
	}
?>
		<!--
		<li class="plain">
			<?php echo $this->link_to_remote(l('Update'), array('action' => 'comments', 'id' => $this->article->id, 'target' => 'comments')); ?>
		</li>
		-->
		<li class="plain">
			<a class="permalink" href="<?php echo $this->article->permalink(); ?>">
				<?php echo l('Permalink'); ?>
			</a>
		</li>
		<li class="plain">
			<a class="trackback" rel="nofollow"
				href="<?php echo $this->article->trackback_url(); ?>"
				title="<?php echo h(l('Use this URI for your Trackback')); ?>">
				<?php echo l('Trackback URI'); ?>
			</a>
		</li>
		<li class="plain">
			<a class="comment" href="<?php echo $this->article->comments_permalink(); ?>"><?php printf(l('%s Comments'), count($comments)); ?></a>
		</li>
	</ul>
</div>
<?php $this->render_component(array('action' => 'comments')); ?>
<script type="text/javascript">
/*<![CDATA[*/
	$(function() {
		$('#f_remember_me').click(function(){ if ($(this).attr('checked')) $('#remember_me_warning').css('display', 'block'); });
	});
/*]]>*/
</script>
<div id="comment-form">
	<h2><?php echo l('Write a comment'); ?></h2>
	<form id="emailform" action="<?php echo $this->make_relative_url(array('action' => 'post_comment')); ?>" method="post">
		<p class="form-left">
			<label class="left-aligned required" for="f_author"><?php echo localized("Name"); ?></label>
			<input class="labeled" type="text" name="author" id="f_author" tabindex="1" size="24" value="<?php echo $this->credentials['realname']; ?>" />
		</p>
		<p class="form-left">
			<label class="left-aligned required" for="f_email"><?php echo localized("Email"); ?></label>
			<input class="labeled" type="text" name="email" id="f_email" tabindex="2" size="24" value="<?php echo $this->credentials['email']; ?>" />
		</p>
		<p class="form-left">
			<label class="left-aligned" for="f_URL"><?php echo localized("Website"); ?></label>
			<input class="labeled" type="text" name="URL" id="f_URL" tabindex="3" size="24" value="<?php echo $this->credentials['url']; ?>" />
		</p>
		<p class="padded-to-label">
			<input type="checkbox" name="remember_me" id="f_remember_me" value="1" />
			<label for="f_remember_me">
				<?php echo l('Remember me'); ?>
			</label>
		</p>
		<div id="remember_me_warning" style="display: none">
			<div class="toolspane-top">
			</div>
			<div class="toolspane-body">
				<p>
					<?php echo l('By flagging this option, your personal data will be already filled in when writing subsequent comments. Do not use this option on public computers.'); ?>
				</p>
				<p style="text-align:right">
					[<a href="#" onclick="$('#remember_me_warning').css('display', 'none'); return false"><?php echo l('Hide'); ?></a>]
				</p>
			</div>
			<div class="toolspane-bottom">
			</div>
		</div>
		<p class="form-left">
			<label class="left-aligned required" for="f_text"><?php echo localized("Comment"); ?></label>
			<textarea name="text" id="f_text" tabindex="4" rows="10" cols="48"></textarea>
		</p>
		<p class="form-left padded-to-label">
			<label for="f_antispam_math_result" class="required">
				<?php echo l("Antispam question:"); ?>
				<?php echo Antispam::$first_operand; ?> +
				<?php echo Antispam::$second_operand; ?> = ?
			</label>
			<input type="text" name="antispam_math_result" id="f_antispam_math_result" tabindex="5" size="3" />
		</p>
		<p class="lighter padded-to-label">
			<?php echo l("An asterisk (*) denotes a required field."); ?>
			<?php printf(l('%s syntax allowed.'), a('Markdown', array('class' => 'external', 'href' => Wikipedia::lookup_url('Markdown')))); ?>
		</p>
		<p class="padded-to-label">
			<input type="checkbox" name="followup_email_notify" id="f_followup_email_notify" value="1" />
			<label for="f_followup_email_notify">
				<?php echo l('Notify me of followup comments via e-mail'); ?>
			</label>
		</p>
		<p class="form-left padded-to-label">
			<input type="hidden" name="post_id" value="<?php echo $this->article->id; ?>" />
			<input type="submit" name="submit" id="submit" tabindex="6" value="<?php echo localized("Send"); ?>" />
		</p>
	</form>
</div>
