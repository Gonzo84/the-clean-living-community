import {Component} from '@angular/core';
import {Socket} from 'ng-socket-io';
import {Router} from '@angular/router';

@Component({
    selector: 'app-chat',
    templateUrl: './chat.page.html',
    styleUrls: ['./chat.page.scss'],
})
export class ChatPage {
    nickname = '';

    constructor(private router: Router,
                private socket: Socket) {
    }

    joinChat() {
        this.socket.connect();
        this.socket.emit('set-nickname', this.nickname);
        this.router.navigate(['/chat-room', { nickname: this.nickname }]);
    }
}

