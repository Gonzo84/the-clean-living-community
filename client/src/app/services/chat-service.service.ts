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
            this.socket.on('message', (data) => {
                observer.next(data);
            });
        });
        return observable;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    sendMessage(message: string, idAnotherUser: number) {
        const body = this.jsonToURLEncoded({message: message, idAnotherUser: idAnotherUser});
        return this.httpClient.post('http://192.168.10.10/chat/send', body);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////

    private jsonToURLEncoded(jsonString) {
        return Object.keys(jsonString).map(function(key){
            return encodeURIComponent(key) + '=' + encodeURIComponent(jsonString[key]);
        }).join('&');
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
}
