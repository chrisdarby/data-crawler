<?php

/**
 * Entry Point
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */

// Include all classes
foreach (glob("classes/interfaces/*.php") as $filename) {
    include $filename;
}

foreach (glob("classes/abstract/*.php") as $filename) {
    include $filename;
}

foreach (glob("classes/crawlers/*.php") as $filename) {
    include $filename;
}

foreach (glob("classes/filters/*.php") as $filename) {
    include $filename;
}

foreach (glob("classes/core/*.php") as $filename) {
    include $filename;
}

foreach (glob("classes/controllers/*.php") as $filename) {
    include $filename;
}

foreach (glob("config/*.php") as $filename) {
    include $filename;
}
   
// Connect to the database
if (@mysql_connect($config_db["server"], $config_db["username"], $config_db["password"])) {
    if (!@mysql_select_db($config_db["database"])) {
	die("Database not found");
    }
} else {
    die("Database connection failed");
}

// Process Url

$url = $_SERVER["REQUEST_URI"];

if (strpos($url,"?") !== false) {
    list($url,$params) = explode("?",$url);
}

if ($base != "/") {
    $url = str_replace($base,"/",$url);
}

$url = rtrim($url,"/");
$url = ltrim($url,"/");


// Build Segments

if (strpos($url,"/") !== false) {
    $segments = explode("/", $url);
} else if ($url != "") {
    $segments = Array($url);
} else {
    $segments = Array();
}

$controller = $segments[0];

if (count($segments) > 1) {
    $action = $segments[1];
    
    unset($segments[0]);
    unset($segments[1]);
    
    $params = array_values($segments);
} else {
    $action = "index";
    $params = Array();
}

// Prepare Controller and Action
$controller_class = $controller."_Controller";
$action_class = $action;

// Run Controller
if (class_exists($controller_class)) {
    $run = new $controller_class();
    
    if (method_exists($run, $action_class)) {
	$run->$action_class($params);
    } else {
	die("No action found");
    }
} else {
    die("No controller found");
}
