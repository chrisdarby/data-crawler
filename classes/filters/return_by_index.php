<?php
/**
 * Returns an Index From An Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Return_By_Index implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	if (is_array($this->content)) {
	    if (isset($this->content[$this->values[0]])) {
		$this->output = $this->content[$this->values[0]];
	    } else {
		$this->output = "";
	    }
	} else {
	    $this->output = "";    
	}
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}