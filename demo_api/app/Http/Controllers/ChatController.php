<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    use ApiResponser;
    private $senderId = 1; //todo get user id from token
    private $senderName = 'Vladimir'; //todo get user name from token

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Send message to another user
     * @return JsonResponse
     * @param $request Request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required|max:255',
            'sendToUserId' => 'required|integer'
        ]);

        $user = User::findOrFail($request->input('sendToUserId'));

        $redis = Redis::Connection();

        $arrMessage = array(
            'sender_id' => $this->senderId,
            'user' => $this->senderName,
            'date_created' => time(),
            'channel' => $user->id,
            'message' => $request->input('message')
        );

        if ($redis->publish('chat-message', json_encode($arrMessage))) {

            $this->senderId < $user->id ? $channelName = $this->senderId . '_' . $user->id : $channelName = $user->id . '_' . $this->senderId;
            $chat = new Chat;
            $chatId = $chat::firstOrCreate(['channel' => $channelName])->id;

            $chatMessage = new Message;
            $chatMessage->chat_id = $chatId;
            $chatMessage->from = $this->senderId;
            $chatMessage->to = $user->id;
            $chatMessage->message = $request->input('message');
            $chatMessage->read_status = 0;
            $chatMessage->save();

            return $this->successResponse(array('success' => true));
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get conversations list
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getConversationsList()
    {
        //todo include eloquent belongsTo/hasMany
        //todo include pagination
        $allMessages = Message::where('from', $this->senderId)
                            ->orWhere('to', $this->senderId)
                            ->orderBy('chat_id', 'desc')
                            ->groupBy('chat_id')
                            ->get('chat_id');

        $messageList = array();
        $chatRooms = Chat::all()->keyBy('id')->toArray();
        if (count($allMessages->toArray()) > 0) {
            foreach ($allMessages->toArray() as $chatId) {
                $userId = explode("_",$chatRooms[$chatId['chat_id']]['channel']);
                $messageList[] = array(
                    'chatId' => $chatId['chat_id'],
                    'user' => $userId[0] == $this->senderId ? User::find($userId[1])->name : User::find($userId[0])->name,
                    'userId' => $userId[0] == $this->senderId ? $userId[1] : $userId[0]
                );
            }
        }

        return $this->successResponse(array('success' => true, 'messageList' => $messageList));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get conversations history
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getConversationHistory(Request $request)
    {
        $this->validate($request, [
            'chatId' => 'required'
        ]);

        $chatList = array();
        $chatHistory = Message::where('chat_id', $request->input('chatId'))->get()->toArray();
        if (count($chatHistory) > 0) {
            foreach ($chatHistory as $chat) {
                $chatList[] = array(
                    'sender_id' => $chat['from'],
                    'user' => User::find($chat['from'])->name,
                    'date_created' => time(),
                    'message' => $chat['message']
                );
            }
        }

        return $this->successResponse(array('success' => true, 'chatList' => $chatList));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
