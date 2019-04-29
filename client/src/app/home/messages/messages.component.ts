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

    messageList = [];
    responseReady = false;
    loader;
    user: any;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private chatService: ChatServiceService,
                private router: Router,
                private loadingController: LoadingController,
                private storage: Storage) {
        this.storage.get('LOGGED_USER').then((data) => {
            this.user = data;
        }).then(() => {
            this.chatService.getMessages(this.user.id).subscribe((message: any) => {
                let lastChatId = 0;
                let update = true;
                if (this.messageList.length > 0) {
                    const chatId = JSON.parse(message).chatId;
                    const chatIndex = this.messageList.findIndex(x => x.chatId == chatId);
                    if (chatIndex >= 0) {
                        if (this.chatService.getActiveChatId() != chatId) {
                            this.messageList[chatIndex].unread = true;
                        }
                        update = false;
                    } else {
                        lastChatId = this.messageList[0].chatId;
                    }
                }
                if (update) {
                    this.getConversationsList(lastChatId);
                }
            });
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ngOnInit() {
        this.presentLoading();
        this.storage.get('LOGGED_USER').then((data) => {
            this.user = data;
        }).then(() => this.getConversationsList(0));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ionViewWillEnter() {
        this.chatService.setActiveChatId(false);
        setTimeout(() => {
            this.checkForUnreadMessages();
        }, 1000);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    getConversationsList(lastChatId) {
        this.chatService.getConversationsList(this.user.id, lastChatId)
            .subscribe(
                (response: any) => {
                    if (response.data.success) {
                        this.messageList.length > 0 ? this.messageList = response.data.messageList.concat(this.messageList) : this.messageList = response.data.messageList;
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
        this.chatService.setActiveChatId(message.chatId)
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
