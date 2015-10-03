<?php
	echo '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
?>

<feed xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns="http://www.w3.org/2005/Atom">
<?php
	print $this->content_for_layout;
?>
</feed>