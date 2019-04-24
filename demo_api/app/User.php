<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    use Authenticatable, Authorizable, HasApiTokens;

    protected $guarded = [];
    protected $hidden = array('password');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function gatherings()
    {
        return $this->belongsToMany(Gathering::class);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function gathering()
    {
        return $this->hasMany(Gathering::class);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
