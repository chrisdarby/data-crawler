<?php

/**
 * Data Management
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Data {

    /**
     * Add entry to queue
     * 
     * @param type $feed
     * @param type $url
     * @param type $structure
     */
    public function addToQueue($feed, $url, $structure) {
	if ($this->checkUrlByFeed($feed, $url)) {
	    return $url . " already exists<br />";
	} else {
	    $query = "insert into queue (url,structure,status,created,feed) values ('" . $url . "','" . $structure . "',0,'" . date("Y-m-d H:i:s") . "','" . $feed . "')";

	    if (@mysql_query($query)) {
		return $url . " added<br />";
	    } else {
		return $url . " not added<br />";
	    }
	}
    }
    
    public function clearQueueByFeed($id) {
	mysql_query("delete from queue where feed = " . $id . " and status = 1");
    }
    
    public function checkUrlByFeed($feed, $url) {
	$check = mysql_query("select * from queue where url = '".$url."' and feed = '".$feed."'");
	if (mysql_num_rows($check) == 0) {
	    return false;
	} else {
	    return true;
	}
    }
    
    public function setAsProcessing($id) {
	$created = date("Y-m-d H:i:s");
	mysql_query("update queue set status = 1 and processing = '".$created."' where id = ".$id);
    }
    
    public function addToData($feed,$data,$status,$queue,$url) {
	$internal_id = $data["internal_id"];
	$json = json_encode($data);
	$created = date("Y-m-d H:i:s");
	
	if ($this->doesDataExist($feed,$internal_id)) {
	    $query = "update data set data = '".addslashes($json)."', status = 0, created = '".$created."', url = '".$url."' where feed = '".$feed."' and internal_id = '".$internal_id."'";
	} else {
	    $query = "insert into data (feed,internal_id,status,data,created,url) values ('".$feed."','".$internal_id."',0,'".addslashes($json)."','".$created."','".$url."')";
	}
	
	if (mysql_query($query)) {
	    mysql_query("delete from queue where id = ".$queue);
	    
	    return true;
	} else {
	    echo mysql_error();
	    return false;
	}
    }
    
    public function doesDataExist($feed,$internal_id) {
	$check = mysql_query("select * from data where feed = '".$feed."' and internal_id = '".$internal_id."'");
	if (mysql_num_rows($check) == 0) {
	    return false;
	} else {
	    return true;
	}
    }

}