<?php
/**
 * Change Case Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Change_Case implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	$case = $this->values[0];
	$this->output = $this->content;
	
	switch($case) {
	    case "upper":
		$this->output = strtoupper($this->content);
		break;
	    case "lower":
		$this->output = strtolower($this->content);
		break;
	    case "upper_first_letter":
		$this->output = ucfirst($this->content);
		break;
	    case "upper_first_letters":
		$this->output = ucwords($this->content);
		break;
	    default:
		$this->output = "";
	}
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}