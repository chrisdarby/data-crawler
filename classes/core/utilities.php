<?php

/**
 * Utilities Class
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Utilities {

    private $curl, $agent;
    
    public function __construct() {
	$this->curl = curl_init();
	$this->agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
	
	curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($this->curl, CURLOPT_VERBOSE, true);
	curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
    }
    
    /**
     * Save a file or array to cache
     * 
     * @param string $name
     * @param string $content
     */
    public function saveToCache($name,$content) {
	if (is_array($content)) {
	    file_put_contents("cache/".$name, "Array".json_encode($content));
	} else {
	    file_put_contents("cache/".$name, $content);    
	}
	
    }
    
    /**
     * Return file or array from cache
     * 
     * @param string $name
     * @return mixed
     */
    public function getFromCache($name) {
	$content = file_get_contents("cache/".$name);

	if (substr($content,0,5) == "Array") {
	    $content = substr($content,5);
	    return json_decode($content,true);
	} else {
	    return $content;
	}
    }
    
    /**
     * Sanatizes an XML output
     * 
     * @param string $content
     * @return string
     */
    public function sanatizeXML($content) {
	$content = str_replace(" & "," and ", $content);
	$content = str_replace("&","&amp;", $content);
	return $content;
    }
    
    /**
     * Return Array Between Blocks
     * 
     * @param string $open
     * @param string $close
     * @param string $content
     * @return array
     */
    public function getArrayBetweenBlocks($open, $close, $content) {	
	$close = str_replace("/", "\\/", $close);
	$open = str_replace("/", "\\/", $open);

	$pattern = "/$open(.*?)$close/s";
	preg_match_all($pattern, $content, $matches);

	if (isset($matches[1])) {
	    return $matches[1];
	} else {
	    return Array();
	}
    }
    
    /**
     * Return array of fields between square brackets
     * 
     * @param string $content
     * @return array
     */
    public function getFieldArray($content) {
	$pattern = "/\[.*?\]/";
	preg_match_all($pattern, $content, $matches);

	if (isset($matches[0])) {
	    return $matches[0];
	} else {
	    return Array();
	}
    }
    
    /**
     * Returns all links between two blocks segments
     * 
     * @param string $open
     * @param string $close
     * @param string $link
     * @return array
     */
    public function getLinksFromHtmlBlock($link, $open = false, $close = false) {
	if ($open == false || $close == false) {
	    $html = $this->getByCurl($link);
	} else {
	    $html = $this->getByCurl($link);
	    $html = $this->getTextBetweenBlocks($open, $close, $html);
	}

	$returned_links = $this->linksInBlock($html);
	
	return $returned_links;
    }

    /**
     * Returns all links within a block
     * 
     * @param string $open
     * @param string $close
     * @param string $content
     * 
     * @return array
     */
    public function linksInBlock($content) {
	return $this->getArrayBetweenBlocks('href="', '"', $content);
    }

    /**
     * Return Text Between Blocks
     * 
     * @param string $open
     * @param string $close
     * @param string $content
     * @return string
     */
    public function getTextBetweenBlocks($open, $close, $content) {
	$open = str_replace("/", "\\/", $open);
	$close = str_replace("/", "\\/", $close);
	$pattern = "/$open(.*?)$close/s";

	preg_match($pattern, $content, $matches);
	if (isset($matches[1])) {
	    return $matches[1];
	} else {
	    return "";
	}
    }
    
    /**
     * Sets a header of the required type
     * 
     * @param string $type
     */
    public function getHeader($type = null) {
	switch ($type) {
	    case "js":
		header("Content-type: application/javascript");	
		break;
	    case "txt":
		header("Content-type: text/plain");	
		break;
	    case "xml":
		header("Content-type: text/xml");	
		break;
	    default:
		header("Content-type: text/plain");	
		break;
	}
    }
    
    /**
     * Returns an array from a structure json string
     * 
     * @param type $structure
     * @return array
     */
    public function getStructureSchema($structure) {
	$json = file_get_contents("schemas/".$structure.".json");
	return json_decode($json,true);
    }

    /**
     * Get text from website using CURL
     * 
     * @param string $url
     * @return string
     */
    public function getByCurl($url) {
	curl_setopt($this->curl, CURLOPT_URL, $url);
	return curl_exec($this->curl);
    }

}