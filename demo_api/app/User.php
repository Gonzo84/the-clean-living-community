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

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function scopeActive($query)
    {
        return $query->where('status', 'regular');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function scopeWithData($query)
    {
        $query->leftjoin('users_data', 'users_data.user_id', '=', 'users.id')
        ->addSelect('*');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function scopeMapSearch($query, $user)
    {
        $query->selectRaw('id, name, (survey_score / ? * 100) AS survey_match, ( 6371 * acos( cos( radians(?) ) *
                               cos( radians( latitude ) )
                               * cos( radians( longitude ) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( latitude ) ) )
                             ) AS distance', [$user->survey_score, $user->latitude, $user->longitude, $user->latitude])
//            ->havingRaw("distance > ?", [1])
                ->where('id' , '!=', $user->id)
            ->groupBy('id')
            ->orderBy('distance');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function scopeWithName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

}
