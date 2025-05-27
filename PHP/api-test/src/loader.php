<?php
//$folders = ['../config', 'controllers', 'services', 'routes', 'validators'];
$folders = ['routes']; //Solo routes porque el resto fue por composer autoload

foreach($folders as $folder)
    foreach (glob(__DIR__ . "/../src/"."$folder/*.php") as $filename)
        require_once($filename);
?>