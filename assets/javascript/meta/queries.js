function reload_queries()
{
	var frm = document.getElementById('queries-frm');
	var limit = frm.l.options[frm.l.selectedIndex].value;
	var query = frm.q.value;
	var group = frm.g.checked;
	
	Servo.load({url:"/meta/queries_list.html?l=" + limit + "&q=" + query + "&g=" + group,
		target:document.getElementById("queries-list-container"),
		oncomplete:add_info_handlers
	});
}

function add_info_handlers()
{
	$('span.info-button').click(function(e)
			{
				hits_details(this, this.id.substring(this.id.indexOf("-") + 1));
			});
}

function queries_csv()
{
	var frm = document.getElementById('queries-frm');
	var limit = frm.l.options[frm.l.selectedIndex].value;
	var query = frm.q.value;
	var group = frm.g.checked;
	
	// This one is syncrhonous
	location.href = "csv.php?l=" + limit + "&q=" + query + "&g=" + group;

}

function hits_details(parent, id)
{
	if (parent.expanded)
		return;
	Servo.load({url:"/meta/id.html?id=" + id,
		target: parent,
		oncomplete:function ()
			{
				parent.expanded = true;
				parent.className = "";
			}});
}

function is_array(val)
{
	return (val instanceof Array);
}

function is_object(val)
{
	return (val instanceof Object);
}
