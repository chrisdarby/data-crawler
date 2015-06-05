<?php
/**
 * Output Controller
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */

class Out_Controller {
    
    private $utils;
    
    public function __construct() {
	$this->utils = new Utilities();
    }
    
    public function feed($params = Array()) {
	$url = $params[0];
	$template = $params[1];
	$type = $params[2];
	
	$get = mysql_query("select * from feeds where url = '".$url."'");
	$num = mysql_num_rows($get);
	
	if ($num == 0) {
	    die("No feed found for this url");
	} else {
	    $result = mysql_fetch_array($get);
	    $id = $result["id"];
	    
	    $file = $url."_".$template.".".$type;
	    if (file_exists("cache/".$file)) {
		$this->utils->getHeader($type);
		echo $this->utils->getFromCache($file);
	    }
	}
    }
    
}