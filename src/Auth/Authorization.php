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
			if($model->isClean('auth_id')) {
				$model->auth()->associate(request()->user());
			} 
		});

		static::saved(function($model) {
			$model->relationLoaded('auth') || $model->load('auth');
 

			if(! ($model->auth instanceof Authenticatable)) {
				$model->auth()->associate(request()->user());
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
				->whereAuthId(optional($user ?? request()->user())->getKey())
				->orWhereNull('auth_id');
    }
}