<?php
	/**
	 *	MacUpdate Ratings parser
	 *	http://www.macupdate.com/rss/examples.php#downloads_php
	 */

class MURatingsParser {

	var $parser;
	var $file;
	var $isWithinItem;
	var $currentItem;
	var $currentTag;
	var $items;
	
	function MURatingsParser($inFile = null) {
		$this->parser = null;
		$this->file = $inFile;
		$this->isWithinItem = false;
		$this->currentItem = array();
		$this->items = array();
	}
	
	function parseFile($persist = false) {
		if (empty($this->parser)) {
			error_log("No parser, so allocating new xml parser");
			$this->parser = xml_parser_create();
			xml_set_object($this->parser, $this);
			xml_set_element_handler($this->parser, "startHandler", "endHandler");
			xml_set_character_data_handler($this->parser, "cdataHandler");
		}
		
		if (!empty($this->file)) {
			// process & parse
			$fp = fopen($this->file, 'r');
			if ($fp) { // could read the file successfully
				while ($data = fread($fp, 4096)) {
					xml_parse($this->parser, $data, feof($fp)) 
						or 
					error_log(sprintf(	"Error in parsing XML: %s at line %d", 
										xml_error_string(xml_get_error_code($this->parser)),
										xml_get_current_line_number($this->parser)));
				}
				fclose($fp);
			} else {
				error_log("Could not read file (name: {$this->file}).");
			}
		} else {
			error_log("Could not parse. No file specified.");
		}
		
		if (!$persist) {
			xml_parser_free($this->parser);
		}
		
	}
	
	function startHandler($parser, $tagName, $attrs) {
		if ($this->isWithinItem) {
			$this->currentTag = $tagName;
		} else if ($tagName == "ITEM") {
			$this->isWithinItem = true;
		}
	}
	
	function endHandler($parser, $tagName)  {
		if ($tagName == "ITEM") {
			$this->items[] = $this->currentItem; // could be $this->items[$this->currentItem['title']] = $this->currentItem to use titles as keys
			$this->currentItem = array();
			$this->currentTag = '';
			$this->isWithinItem = false;
		}
	}
	
	function cdataHandler($parser, $cdata) {
		if ($this->isWithinItem) {
			$trimmedData = trim($cdata);
			if (!empty($trimmedData) && isset($this->currentTag) && !empty($this->currentTag)) {
				if (!isset($this->currentItem[strtolower($this->currentTag)]))
				{
					$this->currentItem[strtolower($this->currentTag)] = "";
				}
				$this->currentItem[strtolower($this->currentTag)] .= $trimmedData;
			}
		}
	}
	
	function release() {
		xml_parser_free($this->parser);
		unset($this);
	}
	
	function hasItems() {
		return (count($this->items) > 0);
	}

		// this method should be overloaded to produce the desired content
	function formatRating(&$item) {
		// do the work of actually producing (HTML) representation of a rating
	}
	
	function ratingForTitle($title) {
		$lambda_form = "return (strtolower(\$elt['title']) === strtolower('$title'));";
		return reset(array_filter($this->items, create_function('$elt', $lambda_form)));
	}
	
	function ratingsList($withTitles = true) {
		$results = array();
		foreach($this->items as $i) {
			if ($withTitles) {
				$results[$i['title']] = $i; //['description'];
			} else {
				$results[] = $i; //['description'];
			}
		}
		return $results;
	}
	
	function ratingsValues($withTitles = true) {
		$results = array();
		foreach($this->items as $i) {
			if ($withTitles) {
				$results[$i['title']] = $i['description'];
			} else {
				$results[] = $i['description'];
			}
		}
		return $results;
	}
	
	function writeRatingOutput($title) {
		$output = '';
		$theItem = $this->ratingForTitle($title);
		if (empty($theItem)) {
			error_log("Could not get information for title [$title]");
		} else {
			$rating = $theItem['description'];
			$formattedRating = number_format($rating, 1);
			$roundedRating = round(($rating * 2), 0) / 2;
			$stars = "http://www.macupdate.com/images/" . (($roundedRating >= 1) ? "stars{$roundedRating}.gif" : "stars0.gif");
			$output = "<div style='width: 125px; font-family: Geneva, Helvetica, sans-serif; border: dotted 1px #cccccc;'>\n";
			$output .= "<div><a href='{$theItem['link']}'><img alt='$roundedRating stars' src='$stars' border='0'></a> <span style='font-size: 8pt;'>($formattedRating)</span></div>\n";
			$output .= "<div style='text-align: center;'><a href='{$theItem['link']}' style='text-decoration: none; font-weight: bold; font-size: 10pt; color: black;'>MacUpdate</a></div>\n";
			$output .= "</div>\n\n";
		}		
		return $output;
	}
	
	function debug() {
		$out = "<table>";
		$out .= "<tr><td>(key)</td><td>title</td><td>descr</td><td>link</td><td>pubdate</td></tr>\n";
		if ($this->hasItems()) {
			foreach($this->items as $k => $item) {
				$out .= "<tr><td>$k</td><td>{$item['title']}</td><td>{$item['description']}</td><td>{$item['link']}</td><td>{$item['pubdate']}</td></tr>\n";
			}
		} else {
			$out .= "<tr><td colspan='5'>There are no items</td></tr>";
		}
		$out .= "</table>";
		
		return $out;
	}

}

?>
