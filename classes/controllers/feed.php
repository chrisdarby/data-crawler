<?php

/**
 * Feed Generator Controller
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Feed_Controller {

    private $utils, $feed;

    public function __construct() {
	$this->utils = new Utilities();
    }

    /**
     * Generates a cached data file
     * 
     * @param array $params
     */
    public function generate($params = Array()) {
	$this->feed = new Feed($params[1] . "." . $params[0], $params[2]);

	if ($params[0] == "js") {
	    $feed = $this->getRawFeedData($params[2]);
	} else {
	    $feed = $this->feed->returnFeed();

	    if ($params[0] == "xml") {
		$feed = $this->utils->sanatizeXML($feed);
	    }
	}

	$get = mysql_query("select * from feeds where id = " . $params[2]);
	$num = mysql_num_rows($get);

	if ($num > 0) {
	    $result = mysql_fetch_array($get);
	    $url = $result["url"];

	    $file = $url . "_" . $params[1] . "." . $params[0];
	    $this->utils->saveToCache($file, $feed);
	    echo $params[0]." Cache file saved\n";
	}
    }

    /**
     * Gets the raw feed data
     * 
     * @param string $feed
     * @return string
     */
    public function getRawFeedData($feed) {
	$get = mysql_query("select * from data where feed = " . $feed);
	$array = Array();
	while ($result = mysql_fetch_array($get)) {
	    $array[] = json_decode($result["data"], true);
	}

	return json_encode($array);
    }

}
