<?php
// No direct call 
defined('RSF_PUBLIC_PATH') or die('No direct script access.');

// Default setting - timezone
date_default_timezone_set('Europe/Berlin');

// Default setting - encoding
setlocale(LC_ALL, 'en_US.utf-8');

// Load the core class
if (is_file(RSF_ENGINE_PATH . 'classes/Rsf/Core' . EXT)) {
    // Application extends the core
    require RSF_ENGINE_PATH . 'classes/Rsf/Core' . EXT;
} else {
    // Ouch
    die("Can't load CORE - break up.");
}

if (is_file(RSF_ENGINE_PATH . 'classes/Rsf' . EXT)) {
    // Application extends the Rsf
    require RSF_ENGINE_PATH . 'classes/Rsf' . EXT;
} else {
    // Ouch
    die("Can't load Rsf Controller - break up.");
}

// Autoloader
spl_autoload_register(array('Rsf', 'autoLoad'));

// Init RSF
Rsf::init();

// Call hello function in index controller
Rsf::callExecute('Index', 'hello');