<?php
/**
 * Feed Generator
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Feed {
    
    private $content, $util, $loop, $loop_static, $field_array, $feed, $data, $output;
    
    /**
     * Initialize and start the feed generation process
     * 
     * @param string $template
     * @param string $feed
     */
    public function __construct($template, $feed) {
	$this->util = new Utilities();
	$this->data = "";
	
	$this->feed = $feed;
	$this->getTemplate($template);
	$this->replaceFeedDetails($feed);
	$this->getFeedLoop();
	$this->processFeedData();
	$this->generateFullFeed();
    }
    
    /**
     * Returns the feed content
     * 
     * @return string
     */
    public function returnFeed() {
	return $this->output;
    }
    
    /**
     * Generate the full feed file
     */
    public function generateFullFeed() {
	$this->output = str_replace($this->loop_static,$this->data,$this->content);
    }
    
    /**
     * Process Feed Data to an Array
     */
    public function processFeedData() {
	$get = mysql_query("select * from data where feed = ".$this->feed);
	while ($result = mysql_fetch_array($get)) {
	    $data = json_decode($result["data"],true);
	    $current = $this->field_array;
	    
	    foreach ($current as $field => $elements) {
		if (isset($data[$field])) {
		    $current[$field]["data"] = $data[$field];
		}
	    }
	    
	    $content = $this->convertArrayToTemplate($current);
	    
	    $this->data .= $content;
	}
    }
    
    /**
     * Convert an array to a template
     * 
     * @param string $data
     * @return string
     */
    public function convertArrayToTemplate($data) {
	$loop_template = $this->loop;
	
	foreach ($data as $field => $content) {
	    if (is_array($content["data"])) {
		$inner_loop = "";
		
		foreach ($content["data"] as $tag) {
		    $inner_loop .= "<".$content["loop"].">".$tag."</".$content["loop"].">\n";
		}
		
		$loop_template = str_replace($content["original"],$inner_loop,$loop_template);
	    } else {
		$loop_template = str_replace($content["original"],$content["data"],$loop_template);
	    }
	}
	
	return $loop_template;
    }
    
    /**
     * Return the feed loop
     */
    public function getFeedLoop() {
	$this->loop = $this->util->getTextBetweenBlocks("<!-- start loop -->", "<!-- end loop -->", $this->content);
	$this->loop_static = "<!-- start loop -->".$this->loop."<!-- end loop -->";
	
	$fields = $this->util->getFieldArray($this->loop);
	
	$array = Array();
	
	foreach ($fields as $element) {
	    $key = str_replace("[","",$element);
	    $key = str_replace("]","",$key);
	    
	    $array[$key] = $element;
	}
	
	$fields = $array;
	
	$this->field_array = $fields;
	
	$array = Array();
	
	foreach ($this->field_array as $key => $val) {
	    $raw = str_replace("[","",$val);
	    $raw = str_replace("]","",$raw);
	    
	    $sub = Array(
		"original" => $val,
		"field" => null,
		"loop" => null,
		"data" => null
	    );
	    
	    if (strpos($raw,"|") !== false) {
		list($field,$loop) = explode("|", $raw);
		$sub["field"] = $field;
		$sub["loop"] = $loop;
		
		$array[$field] = $sub;
	    } else {
		$sub["field"] = $raw;
		$sub["loop"] = null;
		$array[$raw] = $sub;
	    }
	    
	}
	
	$this->field_array = $array;
    }
    
    public function getTemplate($template) {
	$this->content = file_get_contents("templates/".$template);
    }
    
    public function replaceFeedDetails($feed) {
	$get = mysql_query("select * from feeds where id = ".$feed);
	$result = mysql_fetch_array($get);
	
	$agent_details = $result["agent_details"];
	
	if ($agent_details != "") {
	    $details = json_decode($agent_details, true);
	   
	    foreach ($details as $key => $value) {
		$new_key = "feed_".$key;
		$this->content = str_replace("[".$new_key."]", $value, $this->content);
	    }
	}
	
    }
    
}