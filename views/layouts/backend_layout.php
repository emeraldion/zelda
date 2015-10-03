<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
	<head>
		<title><?php print h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_styles.php");
?>
		<link href="/assets/styles/backend/backend.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		/*<![CDATA[*/
		/*]]>*/
		</style>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script type="text/javascript" src="/assets/javascript/backend/backend.js"></script>
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
									<div id="page">
										<div id="single-central">
<?php
	include(dirname(__FILE__) . "/../views/backend/_navbar.php");

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
