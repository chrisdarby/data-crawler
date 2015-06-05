<?php
/**
 * Li To Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Li_To_Array implements iFilter {
    
    private $content;
    private $values;
    private $output;
    
    public function __construct($content,$values = false) {
	$this->content = $content;
	$this->values = $values;
	
	$this->processContent();
    }
    
    public function processContent() {
	preg_match_all('/<li>(.*)<\/li>/', $this->content, $matches);
	
	$data = $matches[0];
	$array = Array();
	
	foreach ($data as $element) {
	    $element = strip_tags($element);
	    $array[] = $element;
	}
	
	$this->output = $array;
    }
    
    public function filteredContent() {
	return $this->output;
    }
 
}