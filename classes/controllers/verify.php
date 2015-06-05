<?php
/**
 * Verification Controller
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */

class Verify_Controller {
    
    private $utils;
    
    public function __construct() {
	$this->utils = new Utilities();
	$this->utils->getHeader("js");
    }
    
    /**
     * Schema Action
     * 
     * @param array $params
     */
    public function schema($params = Array()) {
	if (empty($params)) {
	    die("No schema found");
	} else {
	    $schema = $this->utils->getStructureSchema($params[0]);
	    
	    if ($schema == "") {
		die("Invalid schema file");
	    } else {
		print_r($schema);
	    }
	}
	
    }
    
}