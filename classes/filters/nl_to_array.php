<?php

/**
 * Nl To Array Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Nl_To_Array implements iFilter {

    private $content;
    private $values;
    private $output;

    public function __construct($content, $values = false) {
	$this->content = $content;
	$this->values = $values;

	$this->processContent();
    }

    public function processContent() {
	$list = explode("\n", $txt);
	$this->output = Array();
	foreach ($list as $item) {
	    $item = strip_tags($item);
	    $this->output[] = $item;
	}
    }

    public function filteredContent() {
	return $this->output;
    }

}