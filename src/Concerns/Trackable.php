<?php 

namespace Zareismail\Contracts\Concerns;

trait Trackable
{    
    /**
     * Bootstrap the trait.
     * 
     * @return void
     */
    public static function bootTrackable()
    {
        static::saving(function($model) {
            $model->ensureIsTrackable();
        });
    }

    /**
     * Query where has the given tracking codes.
     * 
     * @return string|array $trackingCodes
     */
    public function scopeViaTrackingCode($query, $trackingCodes)
    {
        return $query->whereIn($this->getQualifiedTrackingCodeColumn(), (array) $trackingCodes);
    }

    /**
     * Fill the "tracking code" if not filled.
     * 
     * @return 
     */
    public function ensureIsTrackable()
    {
        $this->isTrackable() || $this->fillTrackingCode();

        return $this;
    }

    /**
     * Fill the "tracking code" via the new unique code.
     *  
     * @return string        
     */
    public function fillTrackingCode()
    {
        return $this->forceFill([
            $this->getTrackingCodeColumn() => $this->generateTrackingCode()
        ]);  
    }

    /**
     * Fill the "tracking code" via the new unique code.
     *  
     * @return string        
     */
    public function isTrackable()
    {
        return ! empty($this->getTrackingCode());
    }

    /**
     * Get the unique tracking code.
     *  
     * @return string
     */
    public function generateTrackingCode()
    { 
        return with($this->generateRandomTrackingCode(), function($code) { 
            return static::whereKeyNot($this->id)->viaTrackingCode($code)->exists() 
                ? $this->generateRandomTrackingCode() : $code;
        }); 
    } 

    /**
     * Get the random tracking code.
     *  
     * @return string
     */
    public function generateRandomTrackingCode()
    {
        return rand(9999999, 99999999); 
    }

    /**
     * Get the value of the "tracking code" column.
     * 
     * @return string
     */
    public function getTrackingCode()
    { 
        return $this->{$this->getTrackingCodeColumn()};
    }

    /**
     * Get the name of the "tracking code" column.
     *
     * @return string
     */
    public function getTrackingCodeColumn()
    {
        return defined('static::TRACKING_CODE') ? static::TRACKING_CODE : 'tracking_code';
    }

    /**
     * Get the fully qualified "tracking code" column.
     *
     * @return string
     */
    public function getQualifiedTrackingCodeColumn()
    {
        return $this->qualifyColumn($this->getTrackingCodeColumn());
    }
}