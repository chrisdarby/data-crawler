<?php
/**
 * Cralwer Abstract Class
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
abstract class abstractCrawl implements iCrawl {
    
    public $utils, $crawler;
    
    public function __construct() {
	$this->utils = new Utilities();
	$this->crawler = new Crawler();
    }
    
    public function defineCrawler($links) {
	
    }
    
    public function returnLinks() {
	
    }
    
}