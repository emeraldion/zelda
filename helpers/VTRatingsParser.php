<?php
	/**
	 *	@class VTRatingsParser
	 *	@short VersionTracker Ratings parser.
	 */
	class VTRatingsParser
	{
		/**
		 *	@short URL scheme for ratings data.
		 *	@details Use this string as format for the actual ratings URL by replacing the VersionTracker id of the software product.
		 */
		const URL_SCHEME = 'http://tc.versiontracker.com/product/jsdvfd?id=%s&incRating=yes&type=prod&rndz=52369';
		
		/**
		 *	@attr file
		 *	@short Filename of the ratings data.
		 */
		protected $file;
		
		/**
		 *	@attr rating
		 *	@short Rating for the software product.
		 *	@details VersionTracker assigns a rating between 0.0 (poor) and 5.0 (excellent) to every software product.
		 */
		public $rating;
		
		/**
		 *	@fn VTRatingsParser($vt_id)
		 *	@short Constructor for VTRatingsParser objects.
		 *	@param vt_id The VersionTracker id of the software product you are interested in.
		 */
		public function VTRatingsParser($vt_id)
		{
			$this->file = sprintf(self::URL_SCHEME, $vt_id);
		}
		
		/**
		 *	@fn parse
		 *	@short Parses the ratings file.
		 */
		public function parse()
		{
			$contents = file_get_contents($this->file);
			preg_match("/\d\.\d/",
				$contents,
				$matches);
			$this->rating = $matches[0];
		}
	
	}


?>
