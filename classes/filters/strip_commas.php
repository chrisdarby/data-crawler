<?php
/**
 * Strip Commas Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Strip_Commas implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	$this->output = str_replace(",","",$this->content);
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}