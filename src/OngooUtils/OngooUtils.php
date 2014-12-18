<?php

namespace OngooUtils;

/**
 * Description of OngooUtils
 *
 * @author paul
 */
class OngooUtils
{
    protected static $_instance = null;
    protected $injector = null;
    
    protected function __construct()
    {
        
    }

    /**
     * 
     * @return \OngooUtils\OngooUtils
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * 
     * @return \OngooUtils\OngooUtils
     */
    public static function setInstance(OngooUtils\OngooUtils &$instance)
    {
        return self::$_instance = $instance;
    }
    
    public function getInjector()
    {
        return $this->injector;
    }
    
    public function setInjector(&$injector = null)
    {
        $this->injector = $injector;
    }
}
