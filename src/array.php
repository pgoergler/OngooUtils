<?php

namespace Hidden
{

    class FoundException extends \Exception
    {

        protected $key;
        protected $value;

        public function __construct($key, $value)
        {
            parent::__construct("found", 0, null);
            $this->key = $key;
            $this->value = $value;
        }

        public function getKey()
        {
            return $this->key;
        }

        public function getValue()
        {
            return $this->value;
        }

    }

}

namespace
{
    
    /**
     * 
     * Return $array group by $groupby key
     * 
     * @param array $array
     * @param string $groupby
     * @param mixed $notexists
     * @return array
     */
    function groupby($array, $groupby, $notexists = '-')
    {
        $result = array();
        foreach ($array as $key => $data)
        {
            $id = isset($data[$groupby]) ? $data[$groupby] : $notexists;
            if (isset($result[$id]))
            {
                $result[$id][$key] = $data;
            } else
            {
                $result[$id] = array($key => $data);
            }
        }
        return $result;
    }

    /**
     * Return an array which contains :
     *  index 0: all elements in $array1 that is not in $array2
     *  index 1: all elements in $array2 that is not in $array1
     * 
     * @param array $array1
     * @param array $array2
     * @param callable $comparator
     * @return array
     */
    function array_diff_exclude(array $array1, array $array2, $comparator = null)
    {
        if (is_null($comparator) || !is_callable($comparator))
        {
            $onlyA1 = array_diff($array1, $array2);
            $onlyA2 = array_diff($array2, $array1);
        } else
        {
            $onlyA1 = array_udiff($array1, $array2, $comparator);
            $onlyA2 = array_udiff($array2, $array1, $comparator);
        }

        return array($onlyA1, $onlyA2);
    }

    function array_get_value($key, $array, $defaultValue = null)
    {
        return array_key_exists($key, $array) ? $array[$key] : $defaultValue;
    }

    function array_set_recursive($key, $value, array $array)
    {
        $keys = explode('.', $key);
        $finder = function(array $keys, $value, $array, $keysDone = '') use (&$finder)
        {

            $key = array_shift($keys);
            if (is_null($key))
            {
                return $value;
            }

            $keysDone = $keysDone ? "$keysDone.$key" : $key;
            if (array_key_exists($key, $array))
            {
                if (!is_array($array[$key]) && count($keys) > 0)
                {
                    throw new \InvalidArgumentException("$keysDone set but not an array");
                }
            } else
            {
                $array[$key] = array();
            }

            $array[$key] = $finder($keys, $value, $array[$key], $keysDone);
            return $array;
        };

        return $finder($keys, $value, $array);
    }

    function array_get_recursive($key, array $array, $defaultValue = null)
    {
        $keys = explode('.', $key);
        $finder = function(array $keys, $array, $defaultValue, $keysDone = '') use (&$finder)
        {

            $key = array_shift($keys);
            if (is_null($key))
            {
                throw new \InvalidArgumentException("unexpected end of keys");
            }

            if (!array_key_exists($key, $array))
            {
                return $defaultValue;
            }

            if (empty($keys))
            {
                return $array[$key];
            }

            $keysDone = $keysDone ? "$keysDone.$key" : $key;
            return $finder($keys, $array[$key], $defaultValue, $keysDone);
        };

        return $finder($keys, $array, $defaultValue);
    }

    function array_update($array, $function)
    {
        if ($array instanceof \Traversable)
        {
            return \iterator_apply($array, function($iterator) use(&$function)
            {
                return $function($iterator->current()) === false ? false : true;
            }, array($array));
        } elseif (is_array($array))
        {
            return \array_walk($array, $function);
        }
        return false;
    }

    function array_return($array, $function)
    {
        if ($array instanceof Traversable)
        {
            $result = array();
            foreach ($array as $k => $v)
            {
                $result[$k] = $function($v, $k);
            }
            return $result;
        } elseif (is_array($array))
        {
            return \array_map($array, $function);
        }
        return false;
    }

    function iterator_search_callback(\Iterator $array, \Closure $callback, $defaultValue = false)
    {
        try
        {
            \iterator_apply($array, function($iterator) use (&$callback, &$i)
            {
                $value = $iterator->current();
                $res = $callback($value);
                if ($res)
                {
                    throw new \Hidden\FoundException(null, $value);
                }
                return true;
            }, array($array));
            return $defaultValue;
        } catch (\Hidden\FoundException $ex)
        {
            return $ex->getValue();
        }
    }

    function array_search_key_callback(array $array, \Closure $callback, $defaultValue = false)
    {
        try
        {
            array_walk($array, function($value, $key) use (&$callback, &$i)
            {
                if ($callback($key, $value))
                {
                    throw new \Hidden\FoundException($key, $value);
                }
            });
            return $defaultValue;
        } catch (\Hidden\FoundException $ex)
        {
            return $ex->getKey();
        }
    }

    function array_search_callback(array $array, \Closure $callback, $defaultValue = false)
    {
        try
        {
            array_walk($array, function($value, $key) use (&$callback, &$i)
            {
                if ($callback($key, $value))
                {
                    throw new \Hidden\FoundException($key, $value);
                }
            });
            return $defaultValue;
        } catch (\Hidden\FoundException $ex)
        {
            return $ex->getValue();
        }
    }

}