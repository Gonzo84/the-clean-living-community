<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $guarded = [];
    protected $table = 'survey_answers';

    public function questions()
    {
        return $this->belongsTo(Questions::class, 'question_id', 'id');
    }
}
