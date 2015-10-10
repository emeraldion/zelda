<?php
	$this->set_title('Emeraldion Lodge - ' . l('Login'));
?>

	<script type="text/javascript">
	/*<![CDATA[*/
		$(function(jq){
			$('#f_username').focus();
			$('#f_leave_me_registered').click(function(){ if ($(this).attr('checked')) $('#leave_me_registered_warning').show(); });
		});
	/*]]>*/
	</script>
	<div id="login-pane">
		<h2><?php echo localized("Login"); ?></h2>
		<form action="<?php echo $this->url_to(array('action' => 'login')); ?>" method="post">
			<p class="form-left">
				<label class="left-aligned" for="f_username"><?php echo l("Username"); ?>:</label>
				<input class="labeled required character" type="text" name="username" id="f_username" size="12" />
			</p>
			<p class="form-left">
				<label class="left-aligned" for="f_password"><?php echo l("Password"); ?>:</label>
				<input class="labeled" type="password" name="password" id="f_password" size="12" />
			</p>
			<p class="padded-to-label">
				<input type="checkbox" name="leave_me_registered" id="f_leave_me_registered" value="1" />
				<label for="f_leave_me_registered">
					<?php echo l('Leave me registered'); ?>
				</label>
			</p>
			<div id="leave_me_registered_warning" style="display: none">
				<div class="toolspane-top">
				</div>
				<div class="toolspane-body">
					<p>
						<?php echo l('By flagging this option, you will remain logged in until you perform a logout. Do not use this option on public computers.'); ?>
					</p>
					<p style="text-align:right">
						[<a href="#" onclick="$('#leave_me_registered_warning').fadeOut(500); return false"><?php echo l('Hide'); ?></a>]
					</p>
				</div>
				<div class="toolspane-bottom">
				</div>
			</div>
			<p class="right-aligned">
				<input type="hidden" name="gate" value="Porta della Luna" />
				<?php echo $this->link_to(l('Forgot your password?'), array('action' => 'lost_password', 'style' => 'float:left')); ?>
				<input type="submit" name="submit" value="<?php echo l("Enter"); ?>" />
			</p>
		</form>                  
	</div>