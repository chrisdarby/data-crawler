<?php

/**
 * Remove From Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Remove_From_Array implements iFilter {

    private $content;
    private $values;
    private $output;

    public function __construct($content, $values = false) {
	$this->content = $content;
	$this->values = $values;

	$this->processContent();
    }

    public function processContent() {
	if (!is_array($this->content)) {
	    $this->output = "";
	} else {
	    $array = Array();

	    foreach ($this->content as $item) {
		$array[] = str_replace($values[0], "", $item);
	    }

	    $this->content = $array;
	}
    }

    public function filteredContent() {
	return $this->output;
    }

}