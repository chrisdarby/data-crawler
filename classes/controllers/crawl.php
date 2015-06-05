<?php

/**
 * Process Controller
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Crawl_Controller {

    private $crawler, $data;

    public function __construct() {
	$this->crawler = new Crawler();
	$this->data = new Data();
    }

    /**
     * Run the crawler
     * 
     * @param array $params
     */
    public function run($params = Array()) {
	if ($params[0] == "") {
	    die("No ID provided");
	}

	$get = mysql_query("select * from feeds where id = " . $params[0]);
	$num = mysql_num_rows($get);

	if ($num == 0) {
	    die("No feed with this ID available");
	}

	$result = mysql_fetch_assoc($get);
	$name = $result["name"];
	$links = $result["links"];
	$structure = $result["structure"];

	$returns = $this->crawler->processLinks($links, $structure);
	
	$this->data->clearQueueByFeed($params[0]);
	
	foreach ($returns as $return) {
	    $msg = $this->data->addToQueue($params[0],$return,$structure);
	    log::notice("crawler", $name." : ".$msg);
	}
    }

}