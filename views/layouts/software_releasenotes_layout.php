<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title><?php echo h($this->title); ?></title>
	<style type="text/css">
		*
		{
			font-family: "Lucida Grande", Arial, sans-serif;
			font-size: 9pt;
		}
		#header
		{
			height: 48px;
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			background: url("/assets/images/bluegradient.png") repeat-x 0 0;
		}
		.form
		{
			margin: 0;
		}
		.button
		{
			float: right;
			margin: 8px 8px 8px 0 ;
		}
		#content
		{
			margin: 56px 0 0 0;
		}
		#title-header
		{
			height: 20px;
			margin: 0;
			padding: 14px 0;
			vertical-align: center;
			margin-left: 8px;
			float: left;
			font-weight: bold;
			color: #fff;
			text-shadow: 0 2px 2px #000;
			font-size: 11pt;
		}
	</style>
</head>
<body>
	<?php print $this->content_for_layout; ?>
</body>
</html>
