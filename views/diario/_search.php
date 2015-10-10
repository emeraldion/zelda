<script type="text/javascript">
/*<![CDATA[*/
	
	function livesearch(term)
	{
		if (term && term.length > 2)
		{
			return Servo.load({url:'<?php print $this->url_to(array('action' => 'live_search')); ?>?term='+encodeURIComponent(term),
				target:document.getElementById('searchbubble-body'),
				oncomplete: function(){$("#search-results").fadeIn(200);}});
		}
		else
		{
			return hidebubble();
		}
	}
	
	function hidebubble()
	{
		$("#search-results").fadeOut(200);
		return false;
	}
	
	$(function(){
		$('#diario-livesearch').submit(function(){return !livesearch(this.term.value);});
		$('#f_term').keyup(function(){livesearch(this.value);});
		$('a.dismiss-search').click(function(){return hidebubble();});
	});
	
/*]]>*/
</script>
<h3><?php echo l('Search'); ?></h3>
<div id="searchbar" style="margin-bottom: 2em">
	<form id="diario-livesearch" action="<?php print $this->url_to(array('action' => 'search')); ?>">
		<p id="diario-search" style="text-align:left" class="throbber">
			<label for="f_term"><?php echo l('Find:'); ?></label>
			<input type="text" class="searchfield" size="11" name="term" id="f_term" style="margin-right:0" />
		</p>
	</form>
</div>
<div style="position:relative">
	<div id="search-results">
		<div id="searchbubble-top-l">
			<a class="dismiss-search" href="#"></a>
		</div>
		<div id="searchbubble-body"></div>
		<div id="searchbubble-bottom"></div>
	</div>
</div>