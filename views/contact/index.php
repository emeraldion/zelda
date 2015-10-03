		<h2><?php echo l("Contact"); ?></h2>
		<p>
			<?php echo l("Fill out this form to send me an email. Leave your name, your email address and your website URL. You&rsquo;ll be answered as soon as possible."); ?>
		</p>
		<script type="text/javascript">
		/*<![CDATA[*/
			$(function() {
				$('#f_remember_me').click(function(){ if ($(this).attr('checked')) $('#remember_me_warning').css('display', 'block'); });
			});
		/*]]>*/
		</script>
		<h2><?php echo l("Fill out this form"); ?></h2>
		<div style="width: 500px; margin:auto">
			<form id="emailform" action="<?php echo $this->make_relative_url(array('action' => 'send')); ?>" method="post">
				<p class="form-left">
					<label class="left-aligned required" for="autore"><?php echo l("Name"); ?></label>
					<input class="labeled" type="text" name="name" id="autore" size="24" value="<?php echo $this->credentials['realname']; ?>" />
				</p>
				<p class="form-left">
					<label class="left-aligned required" for="email"><?php echo l("Email"); ?></label>
					<input class="labeled email required" type="text" name="email" id="email" size="24" value="<?php echo $this->credentials['email']; ?>" />
				</p>
				<p class="form-left">
					<label class="left-aligned" for="URL"><?php echo l("Website"); ?></label>
					<input class="labeled" type="text" name="URL" id="URL" size="24" value="<?php echo $this->credentials['url']; ?>" />
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
					<label class="left-aligned required" for="f_text"><?php echo l("Message"); ?></label>
					<textarea name="text" id="f_text" rows="10" cols="48"></textarea>
				</p>
				<p class="form-left padded-to-label">
					<label for="f_antispam_math_result" class="required">
						<?php echo l("Antispam question:"); ?>
						<?php
							Antispam::init_math_test();
							echo Antispam::$first_operand; ?> +
						<?php echo Antispam::$second_operand; ?> = ?
					</label>
					<input type="text" name="antispam_math_result" id="f_antispam_math_result" size="3" />
				</p>
				<p class="lighter padded-to-label">
					<?php echo l("An asterisk (*) denotes a required field."); ?>
				</p>
				<p class="form-left padded-to-label">
					<input type="hidden" name="subject" value="<?php echo @$_REQUEST["subject"]; ?>" />
					<input type="submit" name="submit" id="submit" value="<?php echo l("Send"); ?>" />
				</p>
			</form>
		</div>