<?php
/**
 * Commas To Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Commas_To_Array implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	if (strpos($this->content,",") !== false) {
	    $this->output = explode(",",$this->content);
	} else {
	    $this->output = Array();
	}
	
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}