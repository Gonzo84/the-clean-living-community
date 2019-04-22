<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $guarded = [];
    protected $table = 'survey_questions';

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }


}
