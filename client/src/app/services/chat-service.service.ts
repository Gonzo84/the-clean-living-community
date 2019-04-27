import {Injectable} from '@angular/core';
import {Observable, Subject} from 'rxjs';
import {Socket} from 'ng-socket-io';
import {HttpClient} from '@angular/common/http';
import ENV from '../../ENV';


@Injectable({
    providedIn: 'root'
})
export class ChatServiceService {

    private unreadMessage = new Subject<any>();

    ///////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private socket: Socket,
                private httpClient: HttpClient) {

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getMessages(userId) {
        const observable = new Observable(observer => {
            this.socket.on(userId, (data) => {
                observer.next(data);
            });
        });
        return observable;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    socketDisconnect() {
        this.socket.disconnect();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    sendMessage(sender_id: number, receiver_id: number, message: string) {
        return this.httpClient.post(ENV.SERVER_ADDRESS + '/chat/send', {sender_id: sender_id, receiver_id: receiver_id, message: message, });
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getConversationsList(sender_id: number, lastChatId: number) {
        return this.httpClient.post(ENV.SERVER_ADDRESS + '/chat/listing', {sender_id: sender_id, lastChatId: lastChatId});
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getConversationHistory(chatId: number) {
        return this.httpClient.post(ENV.SERVER_ADDRESS + '/chat/history', {chatId: chatId});
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    setUnreadMessageStatus(condition: boolean) {
        this.unreadMessage.next(condition);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getUnreadMessageStatus(): Observable<any> {
        return this.unreadMessage.asObservable();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    checkForUnreadMessages(user_id) {
        return this.httpClient.post(ENV.SERVER_ADDRESS + '/chat/status', {user_id: user_id});
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    updateUnreadMessageStatus(chatId) {
        return this.httpClient.post(ENV.SERVER_ADDRESS + '/chat/status/update', {chatId: chatId});
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getChatRoomId(sender_id, receiver_id) {
        return this.httpClient.post(ENV.SERVER_ADDRESS + '/chat/room', {sender_id: sender_id, receiver_id: receiver_id});
    }
}
