<?php 

namespace Zareismail\Contracts\Concerns;

trait Uniqueness
{    
    /**
     * Bootstrap the trait.
     * 
     * @return void
     */
    public static function bootUniqueness()
    {
        static::saving(function($model) {
            $model->ensureIsUniqueness();
        });
    }

    /**
     * Query where has the given ids.
     * 
     * @return string|array $ids
     */
    public function scopeViaUniquenessId($query, $ids)
    {
        return $query->whereIn($this->getQualifiedUniquenessIdColumn(), (array) $ids);
    }

    /**
     * Fill the "uniqueness id" if not filled.
     * 
     * @return 
     */
    public function ensureIsUniqueness()
    {
        $this->isUniqueness() || $this->fillUniquenessId();

        return $this;
    }

    /**
     * Fill the "uniqueness id" via the new unique code.
     *  
     * @return string        
     */
    public function fillUniquenessId()
    {
        return $this->forceFill([
            $this->getUniquenessIdColumn() => $this->generateUniquenessId()
        ]);  
    }

    /**
     * Fill the "uniqueness id" via the new unique code.
     *  
     * @return string        
     */
    public function isUniqueness()
    {
        return ! empty($this->getUniquenessId());
    }

    /**
     * Get the unique uniqueness id.
     *  
     * @return string
     */
    public function generateUniquenessId()
    { 
        return with($this->generateRandomUniquenessId(), function($code) { 
            return static::whereKeyNot($this->id)->viaUniquenessId($code)->exists() 
                ? $this->generateRandomUniquenessId() : $code;
        }); 
    } 

    /**
     * Get the random uniqueness id.
     *  
     * @return string
     */
    public function generateRandomUniquenessId()
    {
        return rand(9999999, 99999999); 
    }

    /**
     * Get the value of the "uniqueness id" column.
     * 
     * @return string
     */
    public function getUniquenessId()
    { 
        return $this->{$this->getUniquenessIdColumn()};
    }

    /**
     * Get the name of the "uniqueness id" column.
     *
     * @return string
     */
    public function getUniquenessIdColumn()
    {
        return defined('static::UNIQUENESS_ID') ? static::UNIQUENESS_ID : 'uniqueness_id';
    }

    /**
     * Get the fully qualified "uniqueness id" column.
     *
     * @return string
     */
    public function getQualifiedUniquenessIdColumn()
    {
        return $this->qualifyColumn($this->getUniquenessIdColumn());
    }
}