<?php

namespace Lakeview\Policies;

use Lakeview\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class userPolicy
{
    use HandlesAuthorization;
	
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	
	public function user(User $user, $requestedID){
		
		return $requestedID == $user->id;
	}
}
