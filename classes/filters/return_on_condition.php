<?php
/**
 * Return On Condition Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Return_On_Condition implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	if (is_array($this->values)) {
	    $from = (isset($this->values[0]) ? $this->values[0] : false);
	    $to = (isset($this->values[1]) ? $this->values[1] : false);
	    $else = (isset($this->values[2]) ? $this->values[2] : false);
	    
	    
	    if ($from == false || $to == false || $else == false) {
		$this->output = "";
	    } else {
		if (strpos($this->content,$from) !== false) {
		    $this->output = $to;
		} else {
		    $this->output = $else;
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