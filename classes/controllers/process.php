<?php

/**
 * Process Controller
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Process_Controller {

    private $utils, $parse, $data;

    public function __construct() {
	$this->utils = new Utilities();
	$this->parse = new Parser();
	$this->data = new Data();

	$this->utils->getHeader("js");
    }

    /**
     * Index Action
     */
    public function index($params = Array()) {
	mysql_query("delete from data where feed = ".$params[0]);
	
	$get = mysql_query("select * from queue where feed = ".$params[0]);
	$num = mysql_num_rows($get);
	
	if ($num == 0) {
	    die("Feed doesn't exist");
	}
	
	while ($result = mysql_fetch_assoc($get)) {
	    $url = $result["url"];
	    $structure = $result["structure"];
	    $id = $result["id"];
	    $feed = $result["feed"];

	    $this->data->setAsProcessing($id);

	    $content = $this->utils->getByCurl($url);
	    $data = $this->parse->parseContent($content, $structure);

	    if ($this->data->addToData($feed, $data, 0, $id, $url)) {
		log::notice("parser", $url . " parsed successfully");
	    } else {
		log::error("parser", $url . " parse failed");
	    }
	}
    }

    public function limit($params = Array()) {
	$get = mysql_query("select * from queue limit " . $params[0]);
	while ($result = mysql_fetch_assoc($get)) {
	    $url = $result["url"];
	    $structure = $result["structure"];
	    $id = $result["id"];
	    $feed = $result["feed"];

	    $this->data->setAsProcessing($id);

	    $content = $this->utils->getByCurl($url);
	    $data = $this->parse->parseContent($content, $structure);

	    if ($this->data->addToData($feed, $data, 0, $id)) {
		log::notice("parser", $url . " parsed successfully");
	    } else {
		log::error("parser", $url . " parse failed");
	    }
	}
    }

}