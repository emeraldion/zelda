<?php
	$this->set_title('Emeraldion Lodge - Morse Code');
?>
<script type="text/javascript">
/*<![CDATA[*/
	$(function()
	{
		$('#plain_text').keyup(function()
		{
			if ($(this).val())
			{
				var the_url = $('#decode').attr('checked') ?
					'<?php echo $this->url_to(array('action' => 'decode')); ?>' :
					'<?php echo $this->url_to(array('action' => 'encode')); ?>';
				$.get(the_url,
					{text: $(this).val()},
					function (data)
					{
						$('#morse_translation').html(data);
					});
			}
			else
			{
				fill_blank();
			}
		}).focus();
		fill_blank();
	});
	
	function fill_blank()
	{
		$('#morse_translation').html('<?php echo l('Type something! It will be translated to Morse code.'); ?>');
	}
/*]]>*/
</script>
<h2><?php echo l("Morse Code"); ?></h2>

<p>
	<?php echo l('This stupid little application demonstrates the use of filters in EmeRails.'); ?>
</p>

<div id="morse_translation" class="comment-odd">
</div>
<form id="morse_composer">
	<p>
		<textarea id="plain_text" rows="5" cols="25"></textarea>
		<input type="checkbox" id="decode" /><label for="decode">Translate from Morse code.</label>
	</p>
</form>