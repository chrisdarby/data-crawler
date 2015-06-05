<?php

/**
 * Tones Crawler
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Crawler_Tones extends abstractCrawl {

    private $links, $return;

    public function defineCrawler($links) {
	$this->links = $this->crawler->getLinksArray($links);
	$this->return = Array();

	foreach ($this->links as $link) {
	    $start = 0;
	    $step = 10;
	    while ($start < 500) {
		$index = ($start * $step);
		$paged_link = str_replace("*", $index, $link);

		$returned_links = $this->utils->getLinksFromHtmlBlock($paged_link);

		$current = Array();
		foreach ($returned_links as $returned_link) {

		    if (strpos($returned_link, "/used-car/") !== false) {
			    $returned_link = "http://www.tonesusedcars.com" . $returned_link;

			    if (!in_array($returned_link, $this->return)) {
				$current[] = $returned_link;
				$this->return[] = $returned_link;
			    }
			
		    }
		}

		if (empty($current)) {
		    $start = 500;
		}

		$start++;
	    }
	}
    }

    public function returnLinks() {
	return $this->return;
    }

}