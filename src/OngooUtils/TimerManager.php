<?php

namespace OngooUtils;

class TimerManager
{

    protected $timers = array();
    protected static $_instance = null;
    protected $logger = null;

    protected function __construct()
    {
        if(class_exists('\Logging\LoggersManager'))
        {
            $this->logger = \Logging\LoggersManager::getInstance()->get();
        }
    }

    /**
     * 
     * @param string $name
     * @return \OngooUtils\Timer
     */
    public function getTimer($name)
    {
        if (!isset($this->timers[$name]))
        {
            $this->timers[$name] = new Timer();
        }
        return $this->timers[$name];
    }

    /**
     * 
     * @return \OngooUtils\TimerManager
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
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
    
    public function setLogger(\Psr\Log\LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }
    
    public function log($message, $level = 'debug')
    {
        if( !$this->getLogger() )
        {
            echo $message . "\n";
            return;
        }
        
        switch( $level )
        {
            case "notice":
                $this->getLogger()->notice($message);
                break;
            case "info":
                $this->getLogger()->info($message);
                break;
            case "emergency":
                $this->getLogger()->emergency($message);
                break;
            case "critical":
                $this->getLogger()->critical($message);
                break;
            case "alert":
                $this->getLogger()->alert($message);
                break;
            case "error":
                $this->getLogger()->error($message);
                break;
            case "warning":
                $this->getLogger()->warning($message);
                break;
            case "debug":
            default:
                $this->getLogger()->debug($message);
        }
    }
}
