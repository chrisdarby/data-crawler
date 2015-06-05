<?php
/**
 * Process Crawler
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Crawler {
    
    private $debug = false;
    
    /**
     * Returns an array of links to parse
     * 
     * @param string $links
     * @return string
     */
    public function getLinksArray($links) {
	if (strpos($links,"\n") !== false) {
	    return Array($links);
	} else {
	    return explode("\n", $links);
	}
    }
    
    /**
     * Process links and return data
     * 
     * @param string $links
     * @param string $structure
     * @return array
     */
    public function processLinks($links,$structure) {
	$class = "Crawler_".$structure;
	$instance = new $class();
	
	$instance->defineCrawler($links);
	return $instance->returnLinks();
    }
}
