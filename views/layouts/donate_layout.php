<!DOCTYPE html>
<html>
	<head>
		<title><?php echo h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<style type="text/css">
			#donate-button
			{
				float: left;
				width: 200px;
				text-align: center;
			}
			#paypal-frm
			{
			}
			.donate-caption
			{
				margin-left: 200px;
			}
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script>
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
									<div id="page">
										<div id="single-central" class="page-tight">
<?php
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
