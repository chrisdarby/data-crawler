<?php
/**
 * Interface for the Filter Class
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
interface iFilter {
    
    public function processContent();
    public function filteredContent();
    
}