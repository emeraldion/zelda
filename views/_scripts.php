		<!--script type="text/javascript" src="/javascript/common.js"></script-->
		<script src="//cdn.jsdelivr.net/jquery/2.1.4/jquery.min.js"></script>
		<!--[if lt IE 7]>
		<script defer type="text/javascript" src="/assets/javascript/pngfix.js"></script>
		<![endif]-->
		<script src="//cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
		<script src="//cdn.jsdelivr.net/headroomjs/0.7.0/headroom.min.js"></script>
		<script src="//cdn.jsdelivr.net/headroomjs/0.7.0/jQuery.headroom.min.js"></script>
		<script src="//cdn.jsdelivr.net/highlight.js/8.8.0/highlight.min.js"></script>
		<script>
			$(function() {
				// Initialize floating header
				$("header").headroom();

				// Syntax highlighting
				hljs.initHighlighting();

				// Add Italian flag emoji ;-)
				if (navigator.userAgent.indexOf('Mac OS X') !== -1) {
					location.hash = '\uD83C\uDDEE\uD83C\uDDF9';
				}
			});
		</script>
