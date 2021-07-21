<?php

spl_autoload_register(function($class){
$root = dirname(__DIR__);
$class='app/Core/'.$class;
$file= $root .'/'.str_replace('\\','/',$class).".php";
if(is_readable($file)){
    require $root .'/'.str_replace('\\','/',$class).".php";
    echo "File Name :".$file;
}
});

$router = new Router();
echo "<br/>";
//echo "is_callable :<br/>".is_callable($router);
var_dump(is_callable($router));

//$router->dispatch($_SERVER['QUERY_STRING']);
echo "<br/>";
$router->get_names("Rammorthi");

?>