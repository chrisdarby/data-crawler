<?php

/**
 * Auto Run Controller
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Auto_Controller {

    public function to_crawl() {
	$get = mysql_query("select * from feeds where crawling = 0");
	
	$array = Array();
	while ($result = mysql_fetch_array($get)) {
	    $last_crawled = $result["last_crawled"];
	    
	    if ($last_crawled != "0") {
		$now = strtotime("now");
		$hour = $now - 7200;
		
		if ($last_crawled > $hour) {
		    $array[] = $result["id"];
		}
	    } else {
		$array[] = $result["id"];
	    }
	}
	
	echo json_encode($array);
    }
    
    public function go($params = Array()) {
	global $base;
	global $site;
	
	$utils = new Utilities();
	$utils->getHeader("txt");
	
	$feed = $params[0];
	$now = strtotime("now");
	
	mysql_query("update feeds set crawling = 1, last_crawled = '".strtotime("now")."' where id = ".$feed);
	$get = mysql_query("select * from feeds where id = " . $feed);
	$num = mysql_num_rows($get);

	if ($num == 0) {
	    die("Feed does not exist");
	} else {
	    $result = mysql_fetch_array($get);
	    $output = $result["output"];
	    $array = Array();

	    if ($output == "") {
		$output = Array(Array("js" => "standard"));
	    } else {
		$output = json_decode($output, true);
	    }

	    $generate = Array();
	    foreach ($output as $element) {
		foreach ($element as $key => $val) {
		    $generate[] = $base."feed/generate/" . $key . "/".$val."/".$feed;
		}
	    }
	    
	    echo "Running Crawl\n";
	    echo $utils->getByCurl($site.$base."crawl/run/".$feed);
	    
	    echo "Running Process\n";
	    echo $utils->getByCurl($site.$base."process/index/".$feed);
	    
	    foreach ($generate as $generation_key) {
		echo $utils->getByCurl($site.$generation_key);
	    }
	}
	
	mysql_query("update feeds set crawling = 0, last_crawled = '".strtotime("now")."' where id = ".$feed);
    }

}