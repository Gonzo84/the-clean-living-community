import {Component} from '@angular/core';
import {Socket} from 'ng-socket-io';
import {LoadingController} from '@ionic/angular';
import {ActivatedRoute} from '@angular/router';
import {ChatServiceService} from '../../../services/chat-service.service';
import {Storage} from '@ionic/storage';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

@Component({
    selector: 'app-chat-room',
    templateUrl: './chat-room.component.html',
    styleUrls: ['./chat-room.component.scss'],
})
export class ChatRoomComponent {

    receiver_id;
    receiver_name: string;
    message: string;
    messages: any[] = [];
    user: any;
    chatId;
    loader;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private thisRoute: ActivatedRoute,
                private chatService: ChatServiceService,
                private socket: Socket,
                private loadingController: LoadingController,
                private storage: Storage) {

        this.receiver_id = this.thisRoute.snapshot.paramMap.get('receiver_id');
        this.receiver_name = this.thisRoute.snapshot.paramMap.get('receiver_name');
        this.chatId = +this.thisRoute.snapshot.paramMap.get('chatId');

        this.storage.get('LOGGED_USER').then((data) => {
            this.user = data;
        }).then(() => {
            this.chatService.getMessages(this.user.id).subscribe((message: any) => {
                const chatMessage = JSON.parse(message);
                if ((chatMessage.sender_id) && (this.receiver_id == chatMessage.sender_id)) {
                    this.messages.push(JSON.parse(message));
                    // this.content.scrollToBottom(); todo
                }
            });
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ionViewWillEnter() {
        this.presentLoading();
        this.getConversationHistory();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    sendMessage() {
        this.chatService.sendMessage(this.user.id, this.receiver_id, this.message)
            .subscribe(
                (response: any) => {
                    if (response.data.success) {
                        this.messages.push({
                            user: this.user.name,
                            sender_id: this.user.id,
                            date_created: new Date(),
                            message: this.message
                        });
                        this.message = '';
                    }
                },
                err => {
                    console.error(err);
                }
            );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    getConversationHistory() {
        this.chatService.getConversationHistory(this.chatId)
            .subscribe(
                (response: any) => {
                    if (response.data.success) {
                        this.messages = response.data.chatList;
                        this.loader.dismiss();
                    }
                },
                err => {
                    console.error(err);
                }
            );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    updateUnreadMessageStatus() {
        this.chatService.updateUnreadMessageStatus(this.chatId).subscribe();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ionViewWillLeave() {
        this.updateUnreadMessageStatus();
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
