<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    use SoftDeletes;
    protected $table = 'chat_messages';
    protected $fillable = ['from', 'to', 'message', 'read_status'];

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function chats()
    {
        return $this->belongsTo(Chat::class);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
