<?php
	echo '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
?>

<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
<?php
	print $this->content_for_layout;
?>
	</channel>
</rss>