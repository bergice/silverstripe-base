<?php

namespace LeKoala\Base\Forms;

trait ConfigurableField
{
    /**
      * Config array
      *
      * @var array
      */
    protected $config = [];

    /**
    * Get a config key value
    *
    * @param string $key
    * @return string
    */
    public function getConfig($key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
    }

    /**
     * Set a config value
     *
     * @param string $key
     * @param string $value
     * @return string
     */
    public function setConfig($key, $value)
    {
        if ($value !== null) {
            $this->config[$key] = $value;
        } else {
            unset($this->config[$key]);
        }
        return $this;
    }
}
