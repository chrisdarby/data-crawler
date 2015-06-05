<?php
/**
 * Add To Content Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Add_To_Content implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	$values = $this->values;
	
	if ($values[0] == "before") {
	    $this->output = $values[1].$this->content;
	} else if ($values[0] == "after") {
	    $this->output = $this->content.$values[1];
	} else {
	    $this->output = $this->content;
	}
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}