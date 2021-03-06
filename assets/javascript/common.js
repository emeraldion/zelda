String.prototype.clipToLength = function(len)
{
	var str = this;
	if (str.length > len)
	{
		var demilen = Math.floor(len / 2);
		str = str.substr(0, demilen) + '...' +
			str.substr(-demilen);
	}
	return str;
};

$(function()
{
	var url_reg = /^http:\/\//;
	var localdomain_reg = new RegExp("^" + location.protocol + "//" + location.hostname.replace(/\./g, "\\."));
	$('a').each(function(){var href = $(this).attr('href'); if (url_reg.test(href) && !localdomain_reg.test(href)) $(this).addClass('outbound')});
	$('a').filter('.outbound').click(function(evt){ window.open('/outbound.html?url='+encodeURIComponent($(this).attr('href'))); return false; });
	$('a.tab').wrapInner('<span class="tab-inner"></span>');
	$('a.button').wrapInner('<span class="button-inner"></span>');
	$('a.token').wrapInner('<span class="token-inner"></span>');
	$(':text').filter('.email').filter('.required').blur(function(){
		/*
		var me = $(this);
		$.getJSON("/validate/validate_email.json?email=" + encodeURIComponent($(this).val()),
			function(data){
				if (!data.valid)
				{
					$(me).addClass('error');
				}
			});
		*/
		if (/^[_a-z0-9\-]+(\.[_a-z0-9\-]+)*@[a-z0-9-]+(\.[a-z0-9\-]+)+$/.test($(this).val()))
		{
			$(this).removeClass('error');
		}
		else
		{
			$(this).addClass('error');
		}
	});
});