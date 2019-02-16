<?php

namespace Lakeview;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'email_verified_at', 'remember_token', 'created_at','updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function bgColour(){
		$colour = '';
		switch($this->application_status){
			case 0:
				$colour =  '';
				break;
			case 1:
				$colour = 'warning';
				break;
			case 2:
				$colour = 'danger';
				break;
			case 3:
				$colour = 'success';
				break;
		}
		return $colour;
	}
	
	public function txtColour(){
		$colour = '';
		switch($this->application_status){
			case 0:
				$colour =  'dark';
				break;
			case 1:
				$colour = 'dark';
				break;
			case 2:
				$colour = 'light';
				break;
			case 3:
				$colour = 'light';
				break;
		}
		return $colour;
	}
}
