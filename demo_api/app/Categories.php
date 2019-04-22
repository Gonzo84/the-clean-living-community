<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $guarded = [];
    protected $table = 'survey_categories';
    protected $primaryKey = 'id';

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function questions()
    {
        return $this->hasMany(Questions::class, 'category_id', 'id');
    }
}
