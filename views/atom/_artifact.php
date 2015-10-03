			<enclosure xmlns="http://purl.org/rss/1.0/"
				url="<?php echo $artifact->permalink(FALSE); ?>"
				length="<?php echo $artifact->filesize(); ?>"
				type="application/octet-stream"
			/>