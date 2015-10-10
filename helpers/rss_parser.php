<?php

	/**
	 *	@class RSSParser
	 *	@short Helper class for RSS feed parsing.
	 */
	class RSSParser
	{
		/**
		 *	@attr parser
		 *	@short The parser.
		 */
		public $parser;
		
		/**
		 *	@attr file
		 *	@short The file of the feed.
		 */
		public $file;
		
		public $isWithinItem;
		public $currentItem;
		public $currentTag;
		public $items;
		
		/**
		 *	@fn RSSParser($inFile)
		 *	@short Constructor for the RSSParser object.
		 *	@param inFile A file to parse.
		 */
		public function RSSParser($inFile = null)
		{
			$this->parser = null;
			$this->file = $inFile;
			$this->isWithinItem = false;
			$this->currentItem = array();
			$this->items = array();
		}
		
		/**
		 *	@fn parseFile($persist)
		 *	@short Parses the file.
		 *	@param persist Tells the parser to stay around after completion.
		 */
		public function parseFile($persist = false)
		{
			if (empty($this->parser))
			{
				error_log("No parser, so allocating new xml parser");
				$this->parser = xml_parser_create();
				xml_set_object($this->parser, $this);
				xml_set_element_handler($this->parser, "startHandler", "endHandler");
				xml_set_character_data_handler($this->parser, "cdataHandler");
			}
			
			if (!empty($this->file))
			{
				// process & parse
				$fp = fopen($this->file, 'r');
				if ($fp)
				{
					// could read the file successfully
					while ($data = fread($fp, 4096))
					{
						xml_parse($this->parser, $data, feof($fp)) 
							or 
						error_log(sprintf(	"Error in parsing XML: %s at line %d", 
											xml_error_string(xml_get_error_code($this->parser)),
											xml_get_current_line_number($this->parser)));
					}
					fclose($fp);
				}
				else
				{
					error_log("Could not read file (name: {$this->file}).");
				}
			}
			else
			{
				error_log("Could not parse. No file specified.");
			}
			
			if (!$persist)
			{
				xml_parser_free($this->parser);
			}
			
		}
		
		protected function startHandler($parser, $tagName, $attrs)
		{
			if ($this->isWithinItem)
			{
				$this->currentTag = $tagName;
			}
			else if ($tagName == "ITEM")
			{
				$this->isWithinItem = true;
			}
		}
		
		protected function endHandler($parser, $tagName)
		{
			if ($tagName == "ITEM")
			{
				$this->items[] = $this->currentItem; // could be $this->items[$this->currentItem['title']] = $this->currentItem to use titles as keys
				$this->currentItem = array();
				$this->currentTag = '';
				$this->isWithinItem = false;
			}
		}
		
		protected function cdataHandler($parser, $cdata)
		{
			if ($this->isWithinItem)
			{
				$trimmedData = trim($cdata);
				if (!empty($trimmedData) && isset($this->currentTag) && !empty($this->currentTag))
				{
					if (!isset($this->currentItem[strtolower($this->currentTag)]))
					{
						$this->currentItem[strtolower($this->currentTag)] = "";
					}
					$this->currentItem[strtolower($this->currentTag)] .= $trimmedData;
				}
			}
		}
		
		/**
		 *	@fn release
		 *	@short Releases the parser object.
		 */
		public function release() {
			xml_parser_free($this->parser);
			unset($this);
		}
		
		/**
		 *	@fn hasItems
		 *	@short Tells whether the feed has item elements.
		 */
		public function hasItems() {
			return (count($this->items) > 0);
		}
	}

?>
