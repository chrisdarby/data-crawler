<?php

/**
 * Get Array Between Blocks Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Array_Between_Blocks implements iFilter {

    private $content, $values, $output, $util;

    public function __construct($content, $values = false) {
	$this->content = $content;
	$this->values = $values;

	$this->processContent();
	$this->util = new Utilities();
    }

    public function processContent() {
	if (is_array($this->values)) {
	    $open = (isset($this->values[0]) ? $this->values[0] : false);
	    $close = (isset($this->values[1]) ? $this->values[1] : false);
	    
	    $array = Array();
	    
	    if ($open == false || $close == false) {
		$current = $this->util->getArrayBetweenBlocks($open, $close, $content);

		foreach ($current as $item) {
		    if (!in_array($item, $array)) {
			$array[] = $item;
		    }
		}
	    }

	    $this->output = $array;
	} else {
	    $this->output = "";
	}
    }

    public function filteredContent() {
	return $this->output;
    }

}