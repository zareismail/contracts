<?php 

namespace Zareismail\Contracts\Concerns;

trait InteractsWithDetails
{   
    /**
     * Configure trait.
     * 
     * @return void
     */
    public function initializeInteractsWithConfigs() 
    {
        $this->casts['details'] = 'array';
    }

    /**
     * Get the details value with the given key.
     * 
     * @param  string $key     
     * @param  mixed $default 
     * @return mixed          
     */
    public function details(string $key, $default = null)
    {
        return data_get($this->details, $key, $default);
    }
}