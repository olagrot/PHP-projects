<?php
$view = "home.php";
$name=explode('/',$_SERVER["REQUEST_URI"]);
array_shift($name);

if($name[0]!="") {
    if (file_exists("../views/" . $name[0] . ".php")) {
        $view = $name[0] . ".php";
    }
    else {
        $view = "404.php";
    }
}
require_once "../views/layout.php";
?>
