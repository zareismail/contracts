<?php 

namespace Zareismail\Contracts\Concerns;

trait HasDetails
{   
    /**
     * Initilize trait.
     * 
     * @return void
     */
    public function initializeHasDetails() 
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
    public function getDetails(string $key, $default = null)
    {
        return data_get($this->details, $key, $default);
    }

    /**
     * Set the details value for the given key.
     * 
     * @param  string $key     
     * @param  mixed $value 
     * @return mixed          
     */
    public function setDetails(string $key, $value)
    { 
        return $this->fillJsonAttribute("details->{$key}", $value);
    }
}