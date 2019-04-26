import {Component, OnInit} from '@angular/core';
import {ChatServiceService} from '../../services/chat-service.service';
import {Router} from '@angular/router';
import {LoadingController} from '@ionic/angular';
import {Storage} from '@ionic/storage';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

@Component({
    selector: 'app-messages',
    templateUrl: './messages.component.html',
    styleUrls: ['./messages.component.scss'],
})
export class MessagesComponent implements OnInit {

    messageList: any[] = [];
    responseReady = false;
    loader;
    user: any;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private chatService: ChatServiceService,
                private router: Router,
                private loadingController: LoadingController,
                private storage: Storage) {
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ngOnInit() {
        this.presentLoading();
        this.storage.get('LOGGED_USER').then((data) => {
            this.user = data;
        }).then(() => this.getConversationsList());
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ionViewWillEnter() {
        setTimeout(() => {
            this.checkForUnreadMessages();
        }, 1000);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    getConversationsList() {
        this.chatService.getConversationsList(this.user.id)
            .subscribe(
                (response: any) => {
                    if (response.data.success) {
                        this.messageList = response.data.messageList;
                        this.responseReady = true;
                        this.loader.dismiss();
                    }
                },
                err => {
                    console.error(err);
                }
            );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    enterChatRoom(message, index) {
        this.messageList[index].unread = false;
        this.router.navigate(['/home/chat', { chatId: message.chatId, receiver_name: message.user, receiver_id: message.userId }]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    checkForUnreadMessages() {
        if (this.user) {
            this.chatService.checkForUnreadMessages(this.user.id)
                .subscribe(
                    (response: any) => {
                        if (response.data.success) {
                            this.chatService.setUnreadMessageStatus(response.data.status);
                        }
                    },
                    err => console.error(err)
                );
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    async presentLoading() {
        this.loader = await this.loadingController.create({
            message: 'Please wait...',
        });
        await this.loader.present();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
