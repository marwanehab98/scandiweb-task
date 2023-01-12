<?php

include 'APP/Helper.php';

function autoload($class_name) 
{

    $paths = array(
        'APP', 
        'APP/ProductTypes'
    );
    // server/APP/Router.php
    foreach($paths as $path)
    {
        $file = sprintf(dirname(__DIR__).'/server/%s/%s.php', $path, $class_name);
        // echo $file . ': ';
        // echo file_exists($file) ? 'true, ' : 'false, ';
        if(is_file($file)) 
        {
            include_once $file;
        } 

    }
}

spl_autoload_register('autoload');