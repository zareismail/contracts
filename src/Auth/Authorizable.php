<?php  

namespace Zareismail\Contracts\Auth;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface Authorizable
{
	/**
	 * Indicate Authenticatable.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function auth() : BelongsTo; 
}