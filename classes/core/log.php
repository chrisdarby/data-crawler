<?php

/**
 * Log Helper
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */
class log {

    public static function make($status,$area,$string) {
	$current = "logs/".date("Y-m-d") . ".log";

	if (file_exists($current)) {
	    $handler = fopen($current, 'a');
	} else {
	    $handler = fopen($current, 'a');
	}

	$message = date("Y-m-d H:i:s")." : ".$status." - ".$area." - ".$string;
	echo $message."\n";
	
	fwrite($handler, $message . "\n");
	fclose($handler);
    }
    
    public static function notice($area,$string) {
	self::make("NOTICE",$area,$string);
    }

    public static function warn($area,$string) {
	self::make("WARNING",$area,$string);
    }
    
    public static function error($area,$string) {
	self::make("ERROR",$area,$string);
    }
}