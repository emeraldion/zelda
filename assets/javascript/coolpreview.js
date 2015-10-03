/**
 *	CoolPreview Image loading stuff
 *
 *	© 2006 Claudio Procida
 *	http://www.emeraldion.it
 *
 *	Original coolpreview_pagesize() code from:
 *
 *	|	Lightbox JS: Fullsize Image Overlays
 *	|	by Lokesh Dhakar - http://www.huddletogether.com
 *
 */

/**
 *	Constants
 */

var CLOCKWISE = 0,
    CCLOCKWISE = 1,
    FADE_IN = 1,
    FADE_OUT = -1,
    NO_IMAGE = "/assets/images/null.png",
    ERROR_IMAGE = "/assets/images/null.png",
/* Set to true if you want to override caching */
	FORCE_RELOAD = false;

/**
 *	Variables
 */

var coolpreview_throbber;
var coolpreview_fader;
var coolpreview_loader;
var coolpreview_container;

function coolpreview_Throbber(img_id)
{
	/* The number of possible states (different frames) */
	this.STATES = 12;
	/* The interval between two frames in milliseconds */
	this.INTERVAL = 67;

	this.throbber = document.getElementById(img_id);
	this.state = 0;
	this.direction = CLOCKWISE;
	this.running = false;

	this.setDirection = function(dir)
	{
		var was_running = this.running;
		if (was_running)
			this.stopAnimation();
		this.direction = dir;
		if (was_running)
			this.startAnimation();
		return this;
	};
	
	this.startAnimation = function()
	{
		if (this.timer)
			this.stopAnimation();
		this.timer = setInterval(function(t) { t._next(); }, this.INTERVAL, this);
		this.running = true;
		return this;
	};
	
	this.stopAnimation = function()
	{
		clearInterval(this.timer);
		this.running = false;
		return this;
	};
	
	this.setIndeterminate = function(really)
	{
		this.throbber.src = (really) ?
			"/assets/images/coolpreview/throbber/throbber_indeterminate.png" :
			"/assets/images/coolpreview/throbber/throbber_0.png";
		return this;
	};

	this._next = function()
	{
		this.state =
			(this.direction == CLOCKWISE) ?
				((this.state + 1) % this.STATES) :
				(this.STATES - (this.state + 1) % this.STATES - 1);
		this.throbber.src = "/assets/images/coolpreview/throbber/throbber_" + this.state + ".png";
	};

}

function coolpreview_pagesize()
{
	var width, height, viewWidth, viewHeight, left = 0, top = 0;
	if (window.innerHeight && window.scrollMaxY)
	{
		width = document.body.scrollWidth;
		height = window.innerHeight + window.scrollMaxY;
	}
	else if (document.body.scrollHeight > document.body.offsetHeight)
	{ // all but Explorer Mac
		width = document.body.scrollWidth;
		height = document.body.scrollHeight;
	}
	else
	{ // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		width = document.body.offsetWidth;
		height = document.body.offsetHeight;
	}

	if (self.innerHeight)
	{ // all except Explorer
		viewWidth = self.innerWidth;
		viewHeight = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
	{ // Explorer 6 Strict Mode
		viewWidth = document.documentElement.clientWidth;
		viewHeight = document.documentElement.clientHeight;
	}
	else if (document.body)
	{ // other Explorers
		viewWidth = document.body.clientWidth;
		viewHeight = document.body.clientHeight;
	}
	
	if (document.documentElement && document.documentElement.scrollTop)
	{
		left = document.documentElement.scrollLeft;
		top = document.documentElement.scrollTop;
	}
	else if (document.body.scrollTop)
	{
		left = document.body.scrollLeft;
		top = document.body.scrollTop;
	}
	else if (window.scrollY)
	{
		left = window.scrollX;
		top = window.scrollY;
	}

	return {left:left, top:top, width:width, height:height, viewWidth:viewWidth, viewHeight:viewHeight};
}

function coolpreview_Fader(elem_id)
{
	/* The interval between two states in milliseconds */
	this.INTERVAL = 67;

	this.target = document.getElementById(elem_id);
	this.opacity = 0.0;
	this.direction = FADE_IN;
	this.running = false;

	this.setDirection = function(dir)
	{
		var was_running = this.running;
		if (was_running)
			this.stopAnimation();
		this.direction = dir;
		if (was_running)
			this.startAnimation();
		return this;
	};
	
	this.startAnimation = function()
	{
		if (this.timer)
			this.stopAnimation();
		this.timer = setInterval(function(t) { t._next(); }, this.INTERVAL, this);
		this.running = true;
		return this;
	};
	
	this.stopAnimation = function()
	{
		clearInterval(this.timer);
		this.running = false;
		return this;
	};
	
	this.reset = function()
	{
		this.opacity = 0.0;
		return this;
	};
	
	this._next = function()
	{
		this.opacity = limit3(this.opacity + this.direction * 0.1, 0.0, 1.0);
		this.target.style.opacity = this.opacity;
		if (this.opacity == 1.0 ||
			this.opacity == 0.0)
		{
			this.stopAnimation();
			//this.reset();
		}
	};
	return this;
}

function coolpreview_Loader()
{
	this.load = function(photo)
	{
		document.getElementById("coolpreview_loader").onload = null;
		// Force reloading
		document.getElementById("coolpreview_loader").src = "";

		document.getElementById("coolpreview_loader").onload = this.onload;

		document.getElementById("coolpreview_loader").setAttribute("onerror",
			"coolpreview_loader_onerror()");

		document.getElementById("coolpreview_loader").src = photo;
	};

	this.onload = function()
	{
		// WARNING: "this" here refers to the image object!

		// Stop throbber
		coolpreview_throbber.stopAnimation();
		// Set throbber indeterminate
		coolpreview_throbber.setIndeterminate(true);
		// Reset fader
		coolpreview_fader.reset();
		document.getElementById("coolpreview_picture").style.opacity = 0.0;
		// Set photo source
		document.getElementById("coolpreview_picture").src = this.src;
		
		var pagesize = coolpreview_pagesize();
		
		with (document.getElementById("coolpreview_picture"))
		{
			style.top = px(pagesize.top + Math.floor((pagesize.viewHeight - height) / 2));
			style.left = px(pagesize.left + Math.floor((pagesize.viewWidth - width) / 2));
		}
		// Start fading animation
		coolpreview_fader.startAnimation();
	};
	
}

function coolpreview_loader_onerror()
{
	// WARNING: "this" here refers to the image object!

	// Stop throbber
	coolpreview_throbber.stopAnimation();
	// Set throbber indeterminate
	coolpreview_throbber.setIndeterminate(true);
	// Reset fader
	coolpreview_fader.reset();
	document.getElementById("coolpreview_picture").style.opacity = 0.0;
	// Set photo source
	document.getElementById("coolpreview_picture").src = ERROR_IMAGE;
	// Start fading animation
	coolpreview_fader.startAnimation();
}

function coolpreview_showimage(theURL)
{
	var pagesize = coolpreview_pagesize();
	// place the container
	with (document.getElementById("coolpreview_container").style)
	{
		display = "block";
		width = px(pagesize.width);
		height = px(pagesize.height);
	}

	// start throbber
	//coolpreview_throbber.startAnimation();

	// load the photo in background
	coolpreview_loader = new coolpreview_Loader();
	coolpreview_loader.load(theURL + 
		(FORCE_RELOAD ? ("?" + Math.random()) : ""));
}

function coolpreview_dismiss()
{
	with (document.getElementById("coolpreview_container").style)
	{
		display = "none";
	}
	// Set photo source
	document.getElementById("coolpreview_picture").src = NO_IMAGE;
	document.getElementById("coolpreview_picture").style.opacity = 0;
}

function coolify_image_links()
{
	for (var i = 0; i < document.links.length; i++)
	{
		var href = document.links[i].href;
		if (href.match(/\.(png|gif|jpg|jpeg)$/i))
		{
			// Why the heck?
//			document.links[i].real_href = href;
//			document.links[i].href = "#";
//			document.links[i].onclick = function() { coolpreview_showimage(this.real_href); return false; };
			document.links[i].onclick = function() { coolpreview_showimage(this.href); return false; };
		}
	}
}

function coolpreview_setup()
{
	coolpreview_container = document.getElementById("coolpreview_container");
	if (!coolpreview_container) return;
	coolpreview_throbber = new coolpreview_Throbber("coolpreview_throbber");
	coolpreview_fader = new coolpreview_Fader("coolpreview_picture");
	
	// Hide throbber
	coolpreview_throbber.setIndeterminate(true);
	coolpreview_container.onclick = function(evt)
	{
		if (evt)
		{
			evt.stopPropagation();
			evt.preventDefault();
		}
		else
		{
			event.cancelBubble = true;
		}
		coolpreview_dismiss();
	};
	
	coolify_image_links();
}

function limit3(val, min, max)
{
	return val < min ? min : (val > max ? max : val);
}

function in_range(val, a, b)
{
	return (a == Math.min(a, b)) ? limit3(val, a, b) : limit3(val, b, a);
}

function removeClass(el, cls)
{
	var classes = el.className.split(" ");
	var pos = array_pos(classes, cls);
	if (pos != -1)
	{
		delete classes[pos];
	}
	el.className = classes.join(" ");
	
}

function addClass(el, cls)
{
	var classes = el.className.split(" ");
	var pos = array_pos(classes, cls);
	if (pos != -1)
	{
		classes[classes.length] = cls;
	}
	el.className = classes.join(" ");
}

function swapClass(el, cls1, cls2)
{
	var classes = el.className.split(" ");
	var pos = array_pos(classes, cls1);
	if (pos != -1)
	{
		classes[pos] = cls2;
	}
	el.className = classes.join(" ");
}

function array_pos(arr, el)
{
	var ret = -1;
	var len = arr.length;
	for (var i = 0; i < len; i++)
	{
		if (arr[i] == el)
			return i;
	}
	return ret;
}

function px(val)
{
	return eval(val) + "px";
}

if (window.addEventListener)
{
	window.addEventListener("load", coolpreview_setup, true);
}
else if (window.attachEvent)
{
	window.attachEvent("onload", coolpreview_setup);
}