<?php

/**
 * Replace Words In Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Replace_In_Array implements iFilter {

    private $content;
    private $values;
    private $output;

    public function __construct($content, $values = false) {
	$this->content = $content;
	$this->values = $values;

	$this->processContent();
    }

    public function processContent() {
	if (is_array($this->values)) {
	    $from = (isset($this->values[0]) ? $this->values[0] : false);
	    $to = (isset($this->values[1]) ? $this->values[1] : false);
	    
	    if ($from == false || $to == false) {
		$this->output = "";
	    } else {
		if (!is_array($this->content)) {
		    $this->output = "";
		} else {
		    $array = Array();
		    
		    foreach ($this->content as $item) {
			$array[] = str_replace($from,$to,$item);	
		    }
		    
		    $this->content = $array;
		}
	    }
	} else {
	    $this->output = "";
	}
    }

    public function filteredContent() {
	return $this->output;
    }

}