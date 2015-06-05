<?php

/**
 * Right Move Crawler
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Crawler_RightMove extends abstractCrawl {

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
		    $returned_link = substr($returned_link, 0, strpos($returned_link, ".html") + 5);

		    if (strpos($returned_link, "property-to-rent") !== false || strpos($returned_link, "commercial-property-to-let") !== false) {
			if (strcspn($returned_link, '0123456789') != strlen($returned_link)) {
			    $returned_link = "http://www.rightmove.co.uk" . $returned_link;

			    if (!in_array($returned_link, $this->return)) {
				$current[] = $returned_link;
				$this->return[] = $returned_link;
			    }
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