<?php
	header('Content-Type: text/xml; charset=utf-8');
	echo "<" . '?xml version="1.0" encoding="utf-8"?' . ">";
?>

<rss version="2.0" xmlns:sparkle="http://andymatuschak.org/sparkle">
<?php
	print $this->content_for_layout;
?>
</rss>