<?php

/**
 * MYSQL Adapter
 */
class adapter_mysql {

    /**
     * Placeholder Connection
     * @var type 
     */
    private $_connection;

    /**
     * Placeholder Instance
     * @var type 
     */
    private static $_instance;

    /**
     * Magic
     * @param string $adapterConfig
     * @return \mysqli
     */
    public function __construct($adapterConfig = 'default') {
        // Databaseconnector
        $databaseConfig = array(
            // Default Adapter Settings
            'default' => array(
                'host' => '127.0.0.1',
                'user' => 'root',
                'pass' => false,
                'database' => 'sandbox',
            ),
        );

        // Check, if adapter is given
        if (!isset($databaseConfig[$adapterConfig])) {
            // Fallback
            $adapterConfig = 'default';
        }

        // Default Check
        if (!isset($databaseConfig['default'])) {
            die("Warning: Default adapter was not found!");
        }

        // Create connection
        $this->_connection = new mysqli($databaseConfig[$adapterConfig]['host'], $databaseConfig[$adapterConfig]['user'], $databaseConfig[$adapterConfig]['pass'], $databaseConfig[$adapterConfig]['database']);

        // Error handling
        if (mysqli_connect_error()) {
            die("Warning: " . mysql_connect_error());
        }
    }

    /**
     * Singleton pattern
     * @return type
     */
    public static function getInstance() {
        // Check instance
        if (!self::$_instance) { 
            // Create new instance
            self::$_instance = new self();
        }
        
        // Return instance
        return self::$_instance;
    }

    /**
     * MAGIC clone
     */
    public function __clone() {
        // I don't think so
    }
    
    /**
     * MAGIC wakeup
     */
    public function __wakeup() {
        // I don't think so
    }

    /**
     * Return MySQL Connection
     * @return type
     */
    public function getConnection() {
        return $this->_connection;
    }
}
