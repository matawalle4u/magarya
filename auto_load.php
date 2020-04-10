<?php
spl_autoload_register('auto_load_class');
function auto_load_class($class){
    $ext =".php";
    $path =$class . $ext;
    include_once $path;
}
?>