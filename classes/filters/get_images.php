<?php

/**
 * Get Images Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Get_Images implements iFilter {

    private $content, $values, $output, $util;

    public function __construct($content, $values = false) {
	$this->content = $content;
	$this->values = $values;
	$this->util = new Utilities();
	
	$this->processContent();
    }

    public function processContent() {
	if (is_array($this->values)) {
	    $open = (isset($this->values[0]) ? $this->values[0] : false);
	    $close = (isset($this->values[1]) ? $this->values[1] : false);

	    $elements = Array(
		"src=\"" => "\"",
		"src='" => "'"
	    );

	    $array = Array();

	    foreach ($elements as $open_element => $close_element) {
		$current = $this->util->getArrayBetweenBlocks($open_element, $close_element, $this->content);

		foreach ($current as $item) {
		    if (!in_array($item, $array)) {
			$array[] = $item;
		    }
		}
	    }

	    if ($open == false || $close == false) {
		$current = $this->util->getArrayBetweenBlocks($open, $close, $this->content);

		foreach ($current as $item) {
		    if (!in_array($item, $array)) {
			$array[] = $item;
		    }
		}
	    }

	    $returned = Array();
	    foreach ($array as $item) {
		$lower = strtolower($item);
		if (strpos($lower,".jpg") !== false || strpos($lower,"..png") !== false || strpos($lower,".jpeg") !== false || strpos($lower,".png") !== false) {
		    $returned[] = $item;
		}
	    }
	    
	    $this->output = $returned;
	} else {
	    $this->output = "";
	}
    }

    public function filteredContent() {
	return $this->output;
    }

}