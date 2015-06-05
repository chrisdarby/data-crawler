<?php
/**
 * Numbers Only Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Numbers_Only implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	$this->output = preg_replace("/[^0-9.]/", "", $this->content);
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}