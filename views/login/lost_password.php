	<div id="lostpass-pane">
		<h2><?php echo l('Retrieve lost password'); ?></h2>
		<p>
			<?php echo l('lost_password_para'); ?>
		</p>
		<form action="<?php echo $this->url_to(array('action' => 'request_password')); ?>" method="post">
			<p class="form-left">
				<label class="left-aligned" for="f_email"><?php echo l("Email"); ?>:</label>
				<input class="labeled" type="text" name="email" id="f_email" size="24" />
			</p>
			<p class="form-left padded-to-label">
				<label for="f_antispam_math_result" class="required">
					<?php echo localized("Antispam question:"); ?>
					<?php echo Antispam::$first_operand; ?> +
					<?php echo Antispam::$second_operand; ?> = ?
				</label>
				<input type="text" name="antispam_math_result" id="f_antispam_math_result" size="3" />
			</p>
			<p class="lighter padded-to-label">
				<?php echo localized("An asterisk (*) denotes a required field."); ?>
			</p>
			<p class="form-left padded-to-label">
				<input type="submit" name="submit" value="<?php echo l("Send request"); ?>" />
			</p>
		</form>                  
	</div>