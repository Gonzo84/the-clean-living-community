import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import {Socket} from 'ng-socket-io';
import {HttpClient} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class ChatServiceService {

    ///////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private socket: Socket,
                private httpClient: HttpClient) {

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getMessages() {
        const observable = new Observable(observer => {
            this.socket.on('1', (data) => {
                observer.next(data);
            });
        });
        return observable;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    sendMessage(message: string, sendToUserId: number) {
        return this.httpClient.post('http://192.168.10.10/chat/send', {message: message, sendToUserId: sendToUserId});
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getConversationsList() {
        return this.httpClient.get('http://192.168.10.10/chat/listing');
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    getConversationHistory(chatId: number) {
        return this.httpClient.post('http://192.168.10.10/chat/history', {chatId: chatId});
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
}
