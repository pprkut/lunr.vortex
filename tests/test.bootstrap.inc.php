<?php

$base = dirname(__FILE__) . "/..";

set_include_path(
    $base . "/config:" .
    $base . "/system/config:" .
    $base . "/system/libraries/core:" .
    $base . "/system/libraries/third-party:" .
    get_include_path()
);

// Load and setup class file autloader
include_once("class.autoloader.inc.php");
spl_autoload_register("Autoloader::load");


?>
