<?php

defined('RSF_ENGINE_PATH') OR die('No direct script access.');

class Rsf_Core {

    /**
     * All pathes for controllers like engine and public
     * @var type 
     */
    protected static $_paths = array(RSF_ENGINE_PATH, RSF_PUBLIC_PATH);
    
    /**
     * Init bool
     * @var type 
     */
    protected static $_init = FALSE;

    /**
     * Init the core
     * @return type
     */
    public static function init() {
        // Check, if allready inited
        if (self::$_init) {
            // If inited return
            return;
        }
        
        // Set inited to true
        self::$_init = TRUE;

        // Load all given classes
        self::loadClasses();
    }

    /**
     * Current instance
     * @var type 
     */
    static private $instance = null;

    /**
     * Get the instance
     * @return type
     */
    static public function getInstance() {
        // If instance is NULL
        if (self::$instance === NULL) {
            // Instance is a new self
            self::$instance = new self;
        }
        
        // Return the instance
        return self::$instance;
    }

    /**
     * Overwrite protection
     */
    private function __construct() {
        // NOPE
    }

    /**
     * Overwrite protection
     */
    private function __clone() {
        // NOPE
    }

    /**
     * Load all given classes under engine
     */
    public static function loadClasses() {
        // Get all available files 
        $availableFiles = scandir(RSF_ENGINE_PATH . 'classes');

        // Iterate all files
        foreach ($availableFiles as $fileKey => $file) {
            // Check, if current filename is in array, or file is in directory
            if (in_array($file, ['.', '..', 'Rsf.php', 'Rsf']) || is_dir($file)) {
                // Skip it
                continue;
            }

            // Require once file
            require_once RSF_ENGINE_PATH . 'classes/Rsf/' . $file;

            // Get filename
            $classname = str_replace(EXT, '', $file);

            // Current loaded class
            $loadedClass = new $classname;
        }
    }

    /**
     * Autoload a class
     * @param type $class
     * @param type $directory
     * @return boolean
     */
    public static function autoLoad($class, $directory = 'classes') {
        // Skip left double backslashes
        $class = ltrim($class, '\\');
        
        // Placeholder
        $file = '';
        
        // Placeholder
        $namespace = '';

        // Get last checked position by "\\" and check, if given
        if ($last_namespace_position = strripos($class, '\\')) {
            // Set namespace to the last position by doublebackslash
            $namespace = substr($class, 0, $last_namespace_position);
            
            // Raise +1 in substring
            $class = substr($class, $last_namespace_position + 1);
            
            // Current file
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        // Replace the underscore with a simple directory seperator
        $file .= str_replace('_', DIRECTORY_SEPARATOR, $class);

        // Find file
        if ($path = self::findFile($directory, $file)) {
            // Require the path, if given
            require $path;

            // Everything is fine
            return TRUE;
        }

        // Class not found?
        return FALSE;
    }

    /**
     * Find a file in system
     * @param type $dir
     * @param type $file
     * @param type $ext
     * @return string
     */
    public static function findFile($dir, $file, $ext = EXT) {
        // Create a partial path of the filename
        $path = $dir . DIRECTORY_SEPARATOR . $file . $ext;

        // Found placeholder
        $found = FALSE;

        // Iterate the given class directorys
        foreach (Rsf::$_paths as $dir) {
            // If found is not given
            if($found !== FALSE) {
                // Stop
                break;
            }
            
            // If is file
            if (is_file($dir . $path)) {
                // Build the found in path
                return($dir . $path);
            }
        }
        
        // Something went wrong
        return FALSE;
    }

    /**
     * Execute  function by controller and function
     * @param type $controller
     * @param type $function
     */
    public static function callExecute($controller, $function) {
        // Find fine
        $findFile = self::findFile('classes/Controller', $controller);

        // If file is given
        if ($findFile) {
            // Require the file
            require $findFile;

            // Create the new name
            $className = 'Controller_' . $controller;

            // Load class
            $loadedClass = new $className;

            // Build function name
            $functionName = 'action_'  .$function;
            
            // Execute the function
            $loadedClass::$functionName();
        }
    }

}
