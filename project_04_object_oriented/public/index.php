<?php

// Error reporting

error_reporting(-1);
ini_set("display_errors", "On");

// Autoload

require ("../autoload.php");

// Setup directory config
Config\Directory::set("../");

$button=new \Widget\Button(1);
//$button->draw();
echo "<br>";
$link=new \Widget\Link(1);
//$link->draw();
//echo "<br>";

// App example

$app = new App();
$app->run();

