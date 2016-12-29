<!DOCTYPE html>
<html>
	<head>
		<title><?php echo h($this->title); ?></title>
<?php
	require(dirname(__FILE__) . "/../views/_headers.php");
?>
		<style type="text/css">
		</style>
	</head>
	<body>
<?php
//	require(dirname(__FILE__) . "/../views/_topbar.php");
?>
    <header>
<?php
	require(dirname(__FILE__) . "/../views/_navbar.php");
?>
    </header>
    <main>
      <div id="single-central" class="single-central page-tight">
        <div class="center-column">

<?php
	print $this->content_for_layout;
?>
				</div>
			</div>
		</main>
		<footer>
<?php
	require(dirname(__FILE__) . "/../views/_footer.php");
?>
		</footer>
<?php
	require(dirname(__FILE__) . "/../views/_scripts.php");
?>
		<script>
			$(function(jq) {
				$('#f_username').focus();
				$('#f_leave_me_registered').click(function() {
					if ($(this).attr('checked')) {
						$('#leave_me_registered_warning').show();
					}
				});
			});
		</script>
	</body>
</html>
