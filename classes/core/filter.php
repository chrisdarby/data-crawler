<?php
/**
 * Process Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter {
    
    private $debug = false;
    
    /**
     * Process content filters
     * 
     * @param string $content
     * @param string $filter
     * @param array $options
     * @return mixed
     */
    public function processContent($content, $filter, $options = Array()) {
	$filter_dec = "Filter_".$filter;
	$filter_class = new $filter_dec($content, $options);
	$data = $filter_class->filteredContent();
	
	if ($this->debug == true) {
	    if ($data == "") {
		return $filter;
	    } else {
		return $data;
	    }
	} else {
	    return $data;
	}
    }
}