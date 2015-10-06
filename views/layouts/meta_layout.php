<!DOCTYPE html>
<html>
	<head>
		<title><?php echo h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_styles.php");
?>
		<link href="/assets/styles/meta/meta.css" rel="stylesheet" type="text/css" />
		<link href="/assets/styles/meta/hits_by_host.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		/*<![CDATA[*/
			label.left-aligned
			{
				float: left;
				display: block;
				width: 50px;
				text-align:right;
				margin-right: 10px;
			}
			.labeled
			{
				margin-left: 60px;
			}
			.padded-to-label
			{
				padding-left: 60px;
			}
			label.required:after
			{
				content: "*";
			}
		/*]]>*/
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script type="text/javascript">
		/*<![CDATA[*/
		/*]]>*/
		</script>
	</head>
	<body>
		<div id="external">

<?php
	require(dirname(__FILE__) . "/../views/_topbar.php");
?>

			<div id="top"></div>
			<div id="page-bg">
				<div id="brd_s">
					<div id="brd_w">
						<div id="brd_e">
							<div id="crn_sw">
								<div id="crn_se">
									<div id="header"></div>
<?php
	require(dirname(__FILE__) . "/../views/_navbar.php");
?>
									<div id="page" style="padding-top:0">
										<div id="single-central">
<?php
	$this->render(array('partial' => 'navbar'));
	print $this->content_for_layout;
?>
										</div>
<?php
	require(dirname(__FILE__) . "/../views/_footer.php");
?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
