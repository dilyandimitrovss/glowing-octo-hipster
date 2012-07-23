<?php
ini_set('memory_limit', -1);

// As required by PHP, makes life easier!
date_default_timezone_set('Europe/London');

// Needed for the autoloader
$includePaths = array(
        __DIR__ . '/lib',
        get_include_path()
    );

set_include_path(implode(PATH_SEPARATOR, $includePaths));

// Register the autoloader
spl_autoload_register(function($className) {
    $file = implode(DIRECTORY_SEPARATOR, explode('\\', $className)) . '.php';
    
    // check if the file exists in the include path
    foreach(explode(PATH_SEPARATOR, get_include_path()) as $includePath) {
        if(file_exists($includePath . DIRECTORY_SEPARATOR . $file)) {
            include($file);
            
            // File exists but it might not define the required class
            return class_exists($className, false);
        }
    }
    
    // If we got this far, we probably got nothing
    return false;
});