<?php

$base = dirname(__FILE__) . "/..";

set_include_path(
    $base . "/config:" .
    $base . "/system/config:" .
    $base . "/system/libraries/core:" .
    $base . "/system/libraries/third-party:" .
    get_include_path()
);

?>
