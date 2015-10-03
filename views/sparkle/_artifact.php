			<enclosure
				url="<?php echo $artifact->permalink(FALSE); ?>"
				length="<?php echo $artifact->filesize(); ?>"
				sparkle:version="<?php echo $artifact->release->version; ?>"
				sparkle:md5Sum="<?php echo $artifact->md5_sum(); ?>"
				type="application/octet-stream"
			/>