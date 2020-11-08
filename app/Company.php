<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id',
    ];

    /**
     * Get the country that owns the company.
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * The users that belong to the company.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'company_user')->withPivot('created_at');
    }
}
