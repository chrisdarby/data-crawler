<?php
/**
 * Remove From Start Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Remove_From_Start implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	$count = (int)$values[0];
	$this->output = substr($this->content, $count);
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}