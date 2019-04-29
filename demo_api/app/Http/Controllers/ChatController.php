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
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
            'message' => 'required|max:255',
        ]);

        if ($request->input('receiver_id') === $request->input('sender_id')) {
            return $this->errorResponse('forbidden', 403);
        }

        $receiver = User::findOrFail($request->input('receiver_id'));
        $sender = User::findOrFail($request->input('sender_id'));

        $redis = Redis::Connection();

        $sender->id < $receiver->id ? $channelName = $sender->id . '_' . $receiver->id : $channelName = $receiver->id . '_' . $sender->id;
        $chat = new Chat;
        $chatId = $chat::firstOrCreate(['channel' => $channelName])->id;

        $arrMessage = array(
            'sender_id' => $sender->id,
            'user' => $sender->name,
            'date_created' => time(),
            'channel' => $receiver->id,
            'message' => $request->input('message'),
            'chatId' => $chatId
        );

        if ($redis->publish('chat-message', json_encode($arrMessage))) {

            $chatMessage = new Message;
            $chatMessage->chat_id = $chatId;
            $chatMessage->from = $sender->id;
            $chatMessage->to = $receiver->id;
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
    public function getConversationsList(Request $request)
    {
        //todo include eloquent belongsTo/hasMany
        //todo include pagination

        $this->validate($request, [
            'sender_id' => 'required|integer',
            'lastChatId' => 'required|integer'
        ]);

        $sender = User::findOrFail($request->input('sender_id'));

        $allMessages = Message::where('from', $sender->id)
                            ->orWhere('to', $sender->id)
                            ->orderBy('chat_id', 'desc')
                            ->groupBy('chat_id')
                            ->get('chat_id');

        $messageList = array();
        $chatRooms = Chat::all()->keyBy('id')->toArray();
        if (count($allMessages->toArray()) > 0) {
            foreach ($allMessages->toArray() as $chatId) {
                $userId = explode("_",$chatRooms[$chatId['chat_id']]['channel']);
                $unreadMessages = Message::where(['to' => $sender->id, 'read_status' => 0, 'chat_id' => $chatId['chat_id']])->get();
                $count = $unreadMessages->count();
                if ($chatId['chat_id'] > $request->input('lastChatId')) {
                    $messageList[] = array(
                        'chatId' => $chatId['chat_id'],
                        'user' => $userId[0] == $sender->id ? User::find($userId[1])->name : User::find($userId[0])->name,
                        'userId' => $userId[0] == $sender->id ? $userId[1] : $userId[0],
                        'unread' => $count > 0 ? true : false
                    );
                }
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

        Message::where('chat_id', '=', $request->input('chatId'))->update(['read_status' => 1]);
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

    /**
     * Check if exist some unread message
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkForUnreadMessages(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required'
        ]);

        $unreadMessages = Message::where(['to' => $request->input('user_id'), 'read_status' => 0])->get();
        $count = $unreadMessages->count();

        return $this->successResponse(array('success' => true, 'status' => $count > 0 ? true : false));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Update all messages status to read for particular chat room and number of unread messages
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateUnreadMessageStatus(Request $request)
    {
        $this->validate($request, [
            'chatId' => 'required',
            'user_id' => 'required'
        ]);

        Message::where('chat_id', '=', $request->input('chatId'))->update(['read_status' => 1]);

        $unreadMessages = Message::where(['to' => $request->input('user_id'), 'read_status' => 0])->get();
        $count = $unreadMessages->count();

        return $this->successResponse(array('success' => true, 'status' => $count > 0 ? true : false));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get chat room id or create new one
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getChatRoomId(Request $request)
    {
        $this->validate($request, [
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
        ]);

        $receiver = User::findOrFail($request->input('receiver_id'));
        $sender = User::findOrFail($request->input('sender_id'));

        $sender->id < $receiver->id ? $channelName = $sender->id . '_' . $receiver->id : $channelName = $receiver->id . '_' . $sender->id;
        $chat = new Chat;
        $chatId = $chat::firstOrCreate(['channel' => $channelName])->id;

        return $this->successResponse(array('success' => true, 'chatId' => $chatId));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
