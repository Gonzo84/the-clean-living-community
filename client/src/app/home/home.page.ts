import {Component, OnDestroy} from '@angular/core';
import {ChatServiceService} from '../services/chat-service.service';
import {Storage} from '@ionic/storage';
import {ActivatedRoute, Router} from '@angular/router';
import {Subscription} from 'rxjs';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

@Component({
    selector: 'app-home',
    templateUrl: 'home.page.html',
    styleUrls: ['home.page.scss'],
})
export class HomePage implements OnDestroy {

    user: any;
    unreadMessageStatus = false;
    subscription: Subscription;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private chatService: ChatServiceService,
                private storage: Storage,
                private rte: Router,
                private thisRoute: ActivatedRoute) {
        this.storage.get('LOGGED_USER').then((data) => {
            this.user = data;
        }).then(() => {
            this.chatService.getMessages(this.user.id).subscribe((message: any) => {
                this.chatService.setUnreadMessageStatus(true);
                // console.log(message);
                // console.log('root - ' + this.rte.url); // todo not up badge on /home/messages
                // console.log('sender_id - ' + this.thisRoute.snapshot.paramMap.get('receiver_id'));
                // const chatMessage = JSON.parse(message);
                // if ((chatMessage.sender_id) && (this.receiver_id == chatMessage.sender_id)) {
                //     this.messages.push(JSON.parse(message));
                //     // this.content.scrollToBottom(); todo
                // }
            });
        });

        this.subscription = this.chatService.getUnreadMessageStatus().subscribe(status => {
            this.unreadMessageStatus = status;
        });

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ngOnDestroy() {
        this.subscription.unsubscribe();
        this.chatService.socketDisconnect();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
