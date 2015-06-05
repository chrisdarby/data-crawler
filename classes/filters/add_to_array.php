<?php
/**
 * Add To Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Add_To_Array implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	if ($values[0] == "before") {
	    $array = Array();
	    
	    foreach ($this->content as $item) {
		$array[] = $values[1].$item;
	    }
	    
	    $this->output = $array;
	} else if ($values[0] == "after") {
	    $array = Array();
	    
	    foreach ($this->content as $item) {
		$array[] = $item.$values[1];
	    }
	    
	    $this->output = $array;
	} else {
	    $this->output = $this->content;
	}
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}