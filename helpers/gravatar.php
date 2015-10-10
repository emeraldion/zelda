<?php

	/**
	 *	@class Gravatar
	 *	@short Helper class for Gravatar user icons.
	 *	@details Gravatar (http://www.gravatar.com) is a popular provider for universally recognized avatars
	 *	(i.e. user icons) used to distinguish users when they comment blog posts, join a forum etc.
	 */
	class Gravatar
	{
		/**
		 *	@fn gravatar_url($email, $size, $default)
		 *	@short Returns the URL of the gravatar icon for an email address.
		 *	@param email The email for the gravatar profile.
		 *	@param size A size (side of the square) for the gravatar icon.
		 *	@param default The default icon for users that do not have a registered gravatar icon.
		 */
		public static function gravatar_url($email, $size = 40, $default = 'http://www.emeraldion.it/assets/images/no-avatar.png')
		{
			return "http://www.gravatar.com/avatar.php?gravatar_id=" . md5($email) .
				"&amp;default=" . urlencode($default) .
				"&amp;size=" . $size;
		}
	}

?>