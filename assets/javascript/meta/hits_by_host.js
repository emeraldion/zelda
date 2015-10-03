
var tree_data = null;
var filter = null;

function lookup_ip(the_ip)
{
	document.frm.filter.value = the_ip;
	load_data(null);
	return false;
}

function export_kml()
{
	location.href = "/kml/hits_by_host.kml?h=" + document.frm.h.value +
				"&l=" + document.frm.l.value +
				"&f=" + encodeURIComponent(document.frm.filter.value) +
				"&p=" + encodeURIComponent(document.frm.p.value) +
				"&r=" + encodeURIComponent(document.frm.r.value) +
				"&u=" + encodeURIComponent(document.frm.u.value) +
				//"&dbn=" + encodeURIComponent(document.frm.dbn.options[document.frm.dbn.selectedIndex].value) +
				"&t=" + document.frm.t.options[document.frm.t.selectedIndex].value;
}

function load_data(sender)
{
	if (sender) sender.disabled = true;
	Servo.load({url: "/meta/hits_by_host_list.html?h=" + document.frm.h.value +
				"&l=" + document.frm.l.value +
				"&f=" + encodeURIComponent(document.frm.filter.value) +
				"&p=" + encodeURIComponent(document.frm.p.value) +
				"&r=" + encodeURIComponent(document.frm.r.value) +
				"&u=" + encodeURIComponent(document.frm.u.value) +
				//"&dbn=" + encodeURIComponent(document.frm.dbn.options[document.frm.dbn.selectedIndex].value) +
				"&t=" + document.frm.t.options[document.frm.t.selectedIndex].value,
			oncomplete: function(txt)
			{
				build_tree(txt);
				if (sender) sender.disabled = false;						
			}});
}

function hostToString()
{
	return "{ ip_addr:" + this.ip_addr + ", host:" + this.host + ", weight:" + this.weight + "}";
}

function setup()
{
	load_data(document.frm.load_button);
}

function build_tree(data)
{
	var tree = new Object();
	var hosts = data.split("\n");
	var hosts_len = hosts.length - 1;
	
	try
	{
		for (var i = 0; i < hosts_len; i++)
		{
			if (filter && (hosts[i].indexOf(document.frm.filter.value) == -1))
				continue;
			var hostinfo = hosts[i].split(":");
			
			var domains = hostinfo[1].toLowerCase().split(".");
			// Do not reverse if it's an IP address
			if (hostinfo[0] != hostinfo[1])
			{
				domains = domains.reverse();
			}
			var levels = domains.length;
			
			var subdomain = tree;
			for (var j = 0; j <= levels; j++)
			{
				if (j < levels)
				{
					var index = domains[j];
					if (!subdomain[index])
					{
						subdomain[index] = new Object();
					}
					subdomain = subdomain[index];
				}
				else
				{
					subdomain["ip_addr"] = hostinfo[0];
					subdomain["host"] = hostinfo[1];
					subdomain["weight"] = hostinfo[2];
				}
			}
		}
		
		display_tree(tree);

	}
	catch (e)
	{
		log(e);
	}
	
}

function hits_details(parent, ip)
{
	if (parent.expanded)
		return;
	
	if (!parent.details_container)
	{
		var details_container = document.createElement('div');
		parent.parentNode.parentNode.appendChild(details_container);
		parent.details_container = details_container;
	}

	Servo.load({url: "/meta/ip.html?ip=" + ip +
				//"&dbn=" + encodeURIComponent(document.frm.dbn.options[document.frm.dbn.selectedIndex].value) +
				"&dt=" + document.frm.t.options[document.frm.t.selectedIndex].value,
			target: parent.details_container,
			oncomplete: function() {
				parent.expanded = true;
				parent.className = "";
				parent.onclick = null;
			}});
}

function attribute_chooser(parent, ip)
{
	if (parent.expanded)
		return;

	Servo.load({url: "/meta/attribute_chooser.html?ip=" + encodeURIComponent(ip),
			target: parent,
			oncomplete: function() {
				parent.expanded = true;
				parent.onclick = null;
			}});
}

function attribute_visits(sender)
{
	var person_id = sender.options[sender.selectedIndex].value;
	if (person_id != '')
	{
		var ip = sender.id.substring(3);
		var info_node = sender.parentNode.nextSibling;
		Servo.load({url: "/meta/attribute_visits.html?ip=" + encodeURIComponent(ip) +
					"&person_id=" + encodeURIComponent(person_id) +
					"&t=" + document.frm.t.options[document.frm.t.selectedIndex].value,
				oncomplete: function() {
					info_node.expanded = false;
					hits_details(info_node, ip);
				}});
	}
}

function block_ip(ip_addr)
{
	if (confirm("Bloccare l'indirizzo IP " + ip_addr + "?"))
	{
		Servo.load({url:"/meta/block_ip.html?ip="+ip_addr,oncomplete:function(resp){alert(resp);}});
	}
}

function print_tree(tree, level)
{
	if (!level) level = 0;
	var tree_html = "<ul>";
	
	for (var node in tree)
	{
		tree_html += "<li><div>" + node;
		//if (level == 1)
		//{
		//	tree_html += '<a class="external" href="#" onclick="window.open(\'http://www.google.com\');return false"></a>';
		//}
		if (tree[node].weight)
		{
			tree_html += '<span class="ip-addr">' +
				'<a href="#" onclick="return lookup_ip(\'' +
					tree[node].ip_addr +
					'\')">' +
				tree[node].ip_addr +
				"</a></span>";
			if (tree[node].weight < 0)
			{
				tree_html += '<span class="weight my-host" title="' + tree[node].host + ' [' + tree[node].ip_addr + ']">' +  (-tree[node].weight) + '</span>';
			}
			else
			{
				tree_html += '<span class="weight" title="' + tree[node].host + ' [' + tree[node].ip_addr + ']">' +  (tree[node].weight) + '</span>';
			}
			tree_html += '<span class="block" href="#" onclick="block_ip(\'' + tree[node].ip_addr + '\'); return false;"></span>';
			tree_html += '<span class="attrib" href="#" onclick="attribute_chooser(this, \'' + tree[node].ip_addr + '\'); return false;"></span>';
			tree_html += '<span class="info" href="#" onclick="hits_details(this, \'' + tree[node].ip_addr + '\'); return false;"></span>';
			tree_html += "</div>";
		}
		else
		{
			tree_html += "</div>";
			tree_html += print_tree(tree[node], level + 1);
		}
		tree_html += '</li>';
	}
	tree_html += "</ul>";
	return tree_html;
}

function filter_hosts(term)
{
	filter = term;
	if (tree_data)
		build_tree(tree_data);
	else
		load_data(document.frm.load_button);
}

function display_tree(tree)
{
	document.getElementById("tree-container").innerHTML = print_tree(tree);
	add_list_togglers();
}

function expand_all()
{
	set_tree_state(true);
}

function collapse_all()
{
	set_tree_state(false);
}

function set_tree_state(onoff)
{
	var li = document.getElementById("tree-container").getElementsByTagName("li");
	for (var i = 0; i < li.length; i++)
	{
		li[i].className = onoff ? 'expanded' : '';
		li[i].style.display = onoff ? 'list-item' : 'none';
	}
}

function log(text)
{
	alert(text);
	//document.frm.log.value += text + "\n";
}

function is_array(val)
{
	return (val instanceof Array);
}

function is_object(val)
{
	return (val instanceof Object);
}


/**
 *	List toggling stuff
 */
 
function toggle_children_list_items(e)
{
	var evt = e || event;
	
	/*
	if (evt.stopPropagation)
		evt.stopPropagation();
	if (evt.preventDefault)
		evt.preventDefault();
	*/
	evt.cancelBubble = true;

	var src = (this == window) ? evt.srcElement : this;
	
	var children_ul = src.getElementsByTagName("ul");
	if (!children_ul ||
		!children_ul.length ||
		!children_ul[0].childNodes)
		return;
	
	var ul_limit = evt.ctrlKey ? children_ul.length : 1;
	for (var k = 0; k < ul_limit; k++)
	{
		var children_li = children_ul[k].childNodes;
		for (var i = 0; i < children_li.length; i++)
		{
			if (children_li[i].nodeType != 1 ||
				children_li[i].nodeName.toLowerCase() != "li")
				continue;
			if (children_ul[k].parentNode.isExpanded)
			{
				children_li[i].style.display = "none";
			}
			else
			{
				children_li[i].style.display = "list-item";
			}
		}
		children_ul[k].parentNode.className = (children_ul[k].parentNode.isExpanded) ?
		"" :
		"expanded";
		children_ul[k].parentNode.isExpanded = !children_ul[k].parentNode.isExpanded;
	}
}

function add_list_togglers()
{
	var li_items = document.getElementById("tree-container").getElementsByTagName("li");
	for (var i = 0; i < li_items.length; i++)
	{
		if (window.addEventListener)
		{
			li_items[i].addEventListener("click", toggle_children_list_items, false);
		}
		else if (window.attachEvent)
		{
			li_items[i].attachEvent("onclick", toggle_children_list_items);
		}
	}
}

var beautifier =
{
	"Gate": function(text)
	{
		return '<a href="' + location.protocol + "//" + location.hostname + text + '">' + text + '</a>';
	},
	"Date": function(text)
	{
		return text;
	},
	"User Agent": function(text)
	{
		return text;
	}
};