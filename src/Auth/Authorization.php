<?php 

namespace Zareismail\Contracts\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zareismail\Contracts\User;

trait Authorization
{   
	public static function bootAuthorization()
	{
		static::saving(function($model) {
			if(is_null($model->{$model->getAuthIdColumn()}) && request()->user()) {
				$model->auth()->associate(request()->user());
			} 
		});

		static::saved(function($model) {
			$relation = $model->getAuthRelation();

			$model->relationLoaded($relation) || $model->load($relation);

			if(! $model->{$relation} instanceof Authenticatable) {
				$model->$relation()->associate(request()->user());
				$model->save();
			}
		});
	}

	/**
	 * Indicate Authenticatable.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function auth() : BelongsTo 
    {
        return $this->belongsTo(config('zareismail.user', User::class));
    }

	/**
	 * Indicate Authenticatable.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	protected function authenticatable(string $foreignKey) : BelongsTo 
    {
        return $this->belongsTo(config('zareismail.user', User::class), $foreignKey);
    }

    public function scopeAuthenticate($query, Authenticatable $user = null)
    { 
    	return $query
				->where($query->getQualifiedAuthIdColumn(), optional($user ?? request()->user())->getKey())
				->orWhereNull($query->getQualifiedAuthIdColumn());
    } 

    /**
     * Get the name of the "auth id" column.
     *
     * @return string
     */
    public function getAuthRelation()
    {
        return defined('static::AUTH_RELATION') ? static::AUTH_RELATION : 'auth';
    } 

    /**
     * Get the name of the "auth id" column.
     *
     * @return string
     */
    public function getAuthIdColumn()
    {
        return defined('static::AUTH_ID') ? static::AUTH_ID : 'auth_id';
    } 

    /**
     * Get the fully qualified "auth id" column.
     *
     * @return string
     */
    public function getQualifiedAuthIdColumn()
    {
        return $this->qualifyColumn($this->getAuthIdColumn());
    }
}