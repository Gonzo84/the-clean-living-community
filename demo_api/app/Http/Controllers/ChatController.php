<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Send message to another user
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required|max:255',
            'idAnotherUser' => 'required|integer'
        ]);

        $redis = Redis::Connection();
        $arrMessage = array(
            'user_id' => 2,
            'user' => 'Vladimir Glisovic',
            'date_created' => time(),
            'channel' => 'message',
            'message' => 'Hello world!'
        );

        $redis->publish('chat-message', json_encode($arrMessage));

//        $sendMessage = json_encode(['user' => 'Lumen', 'event' => 'joined', 'from' => 'Vlada', 'text' => 'bla bla', 'created' => '21.03.2019', 'channel' => 'message']);
//        $redis->publish('add-message', $sendMessage);
//        $sendMessage = json_encode(['user' => 'Lumen', 'event' => 'joined', 'from' => 'Vlada', 'text' => 'bla bla', 'created' => '21.03.2019', 'channel' => 'users-changed']);
//        $redis->publish('users-changed', $sendMessage);
        print_r([]);
    }
}
