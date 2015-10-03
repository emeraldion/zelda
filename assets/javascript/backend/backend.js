$(function()
{
	$(':text').after('<input type="button" value="&times;" onclick="this.previousSibling.value=this.previousSibling.defaultValue" />');
});