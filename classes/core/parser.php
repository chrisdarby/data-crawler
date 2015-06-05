<?php

/**
 * Parser Class
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Parser {
    
    private $utils, $filter;
    
    public function __construct() {
	$this->filter = new Filter();
	$this->utils = new Utilities();
    }
    
    public function parseContent($content, $structure) {
	$schema = $this->utils->getStructureSchema($structure);
	$array = Array();
	
	foreach ($schema as $element) {
	    $name = $element["name"];
	    $open = $element["open"];
	    $close = $element["close"];
	    $filters = $element["filters"];
	    
	    $data = $this->getContentBlock($content,$open,$close);

	    $array[$name] = $this->applyFilters($data,$filters);
	}
	
	return $array;
    }
    
    private function applyFilters($data,$filters) {
	foreach ($filters as $filter) {
	    if (isset($filter["values"])) {
		$values = $filter["values"];
	    } else {
		$values = Array();
	    }
	    
	    $data = $this->filter->processContent($data, $filter["name"], $values);
	}
	
	return $data;
    }
    
    private function getContentBlock($content,$open,$close) {
	return $this->utils->getTextBetweenBlocks($open, $close, $content);
    }
    
    
}