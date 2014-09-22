<?php
// Just for debugging / developing
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 1);

// Set the full path to the docroot
define('DOCROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

// ENGINE PATH
$engine = 'engine';

// MODULES PATH
$modules = 'modules';

// PUBLIC PATH
$public = 'public';

// EXTENSION
define('EXT', '.php');

// Check dir - set engine dir
if (!is_dir($engine) AND is_dir(DOCROOT . $engine)) {
    $engine = DOCROOT . $engine;
}

// Check dir - set modules dir
if (!is_dir($modules) AND is_dir(DOCROOT . $modules)) {
    $modules = DOCROOT . $modules;
}

// SET absolute path engine
define('RSF_ENGINE_PATH', realpath($engine) . DIRECTORY_SEPARATOR);

// SET absolute path modules
define('RSF_MODULES_PATH', realpath($modules) . DIRECTORY_SEPARATOR);

// SET absolute path pulic
define('RSF_PUBLIC_PATH', realpath($public) . DIRECTORY_SEPARATOR);

// Cleanup
unset($engine, $modules, $public);

// Profiling - start
if (!defined('RSF_START_TIME')) {
    define('RSF_START_TIME', microtime(TRUE));
}

// Memory usage
if (!defined('RSF_START_MEMORY')) {
    define('RSF_START_MEMORY', memory_get_usage());
}

// Bootstrap the application
require RSF_PUBLIC_PATH.'bootstrap'.EXT;