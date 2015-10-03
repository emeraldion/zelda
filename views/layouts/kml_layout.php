<?php
	echo '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
?>

<kml xmlns="http://earth.google.com/kml/2.0">
<Document>
<name><?php echo strip_tags($this->title); ?></name>
<open>1</open>
<?php
	echo $this->content_for_layout;
?>
</Document>
</kml>