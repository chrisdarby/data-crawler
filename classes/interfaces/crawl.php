<?php
/**
 * Interface for the Crawl Class
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
interface iCrawl {
    
    public function defineCrawler($links);
    public function returnLinks();
    
}