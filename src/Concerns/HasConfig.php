<?php 

namespace Zareismail\Contracts\Concerns;

trait HasConfig
{   
    /**
     * Configure trait.
     * 
     * @return void
     */
    public function initializeHasConfig() 
    {
        $this->casts['config'] = 'array';
    }

    /**
     * Get the config value with the given key.
     * 
     * @param  string $key     
     * @param  mixed $default 
     * @return mixed          
     */
    public function getConfig(string $key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Set the config value for the given key.
     * 
     * @param  string $key     
     * @param  mixed $value 
     * @return mixed          
     */
    public function setConfig(string $key, $value)
    { 
        return $this->fillJsonAttribute("config->{$key}", $value);
    }
}