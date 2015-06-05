<?php

/**
 * Return If List of Conditions True Filter
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class Filter_Return_If_Conditions implements iFilter {

    private $content;
    private $values;
    private $output;

    public function __construct($content, $values = false) {
	$this->content = $content;
	$this->values = $values;

	$this->processContent();
    }

    public function processContent() {
	if (is_array($this->values)) {
	    $from = (isset($this->values[0]) ? $this->values[0] : false);
	    $to = (isset($this->values[1]) ? $this->values[1] : false);

	    if ($from == false || $to == false) {
		$this->output = $this->content;
	    } else {
		if (strpos($from, ",") !== false) {
		    $list = explode(",", $from);

		    $is = false;
		    foreach ($list as $item) {
			if (strpos($this->content, $item) !== false) {
			    $is = true;
			}
		    }

		    if ($is) {
			$this->output = $to;
		    } else {
			$this->output = $this->content;
		    }
		} else {
		    if (strpos($this->content, $from) !== false) {
			$this->output = $to;
		    } else {
			$this->output = $this->content;
		    }
		}
	    }
	} else {
	    $this->output = $this->content;
	}
    }

    public function filteredContent() {
	return $this->output;
    }

}