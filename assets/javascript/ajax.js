/**
 *	Cross-browser HTTP request object
 */
function XMLHttp()
{
	if (window.XMLHttpRequest)
	{
		return new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	else return null;
}

/**
 *	Asynchronous HTTP request handler
 */
var Servo = {
	load: function(params)
	{
		var xmlhttp = new XMLHttp();
		if (xmlhttp)
		{
			xmlhttp.onreadystatechange = function()
			{
				if (xmlhttp.readyState == 4)
				{
					if (xmlhttp.status == 200)
					{
						if (params["target"])
						{
							params["target"].innerHTML = xmlhttp.responseText;
						}
					}
					else
					{
						if (params["target"])
						{
							params["target"].innerHTML = "Failed. Status:" + xmlhttp.status;
						}
					}
					// Execute anyway. Is it really a Good Thing??
					if (params["oncomplete"])
					{
						params["oncomplete"](xmlhttp.responseText);
					}
				}
			};
			xmlhttp.open("GET", params["url"], true);
			xmlhttp.send(null);
			return true;
		}
		return false;
	},
	download: function(params)
	{
		var xmlhttp = new XMLHttp();
		if (xmlhttp)
		{
			xmlhttp.open("GET", params["url"], false);
			xmlhttp.send(null);
			if (xmlhttp.status == 200)
			{
				return xmlhttp.responseText;
			}
		}
	},
	post: function(params)
	{
		var xmlhttp = new XMLHttp();
		if (xmlhttp)
		{
			xmlhttp.onreadystatechange = function()
			{
				if (xmlhttp.readyState == 4)
				{
					if (xmlhttp.status == 200)
					{
						if (params["target"])
							params["target"].innerHTML = xmlhttp.responseText;
					}
					else
					{
						if (params["target"])
							params["target"].innerHTML = "Failed. Status:" + xmlhttp.status;
					}
					// Execute anyway. Is it really a Good Thing??
					if (params["oncomplete"])
					{
						params["oncomplete"](xmlhttp.responseText);
					}
				}
			};
			xmlhttp.open("POST", params["url"] || params["form"].getAttribute("action"), true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			var post_data = getPostData(params["form"]);
			xmlhttp.setRequestHeader("Content-Length", 8 * post_data.length);
			xmlhttp.send(post_data);
			return true;
		}
		return false;
	}
};

function getPostData(frm)
{
	var post_data = "";
	var els = frm.elements;
	for (var i = 0; i < els.length; i++)
	{
		var post_part = "";
		var el = els[i];
		if (!el.name) continue;
		switch (el.type)
		{
			case "checkbox":
				if (!el.checked)
				{
					continue;
				}
				post_part = el.name + "=" + encodeURIComponent(el.value);
				break;
			case "select-one":
				post_part = el.name + "=" + encodeURIComponent(el.options[el.selectedIndex].value);
				break;
			case "select-multiple":
				for (var j = 0; j < el.options.length; j++)
				{
					if (el.options[j].selected)
					{
						post_part += el.name + "=" + encodeURIComponent(el.options[j].value);
					}
				}
				break;
			case "textarea":
			case "text":
			default:
				post_part = el.name + "=" + encodeURIComponent(el.value);
		}
		post_data += (post_data ? "&" : "") + post_part;
	}
	return post_data;
}
