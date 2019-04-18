<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Survey extends Model
{
    protected $table = 'surveys';

    public function categories(): belongsTo
    {
        return $this->belongsTo('App\Category', 'survey_id', 'id');
    }
}
