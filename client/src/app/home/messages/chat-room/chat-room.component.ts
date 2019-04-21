import {Component, ViewChild} from '@angular/core';
import {Socket} from 'ng-socket-io';
import {Observable} from 'rxjs/Observable';
import {IonContent, LoadingController} from '@ionic/angular';
import {ActivatedRoute} from '@angular/router';
import {ChatServiceService} from '../../../services/chat-service.service';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

@Component({
    selector: 'app-chat-room',
    templateUrl: './chat-room.component.html',
    styleUrls: ['./chat-room.component.scss'],
})
export class ChatRoomComponent {

    @ViewChild(IonContent) content: IonContent;

    idUser = 1; // todo get id from token
    username = 'Vladimir'; // todo get user name from token
    sendToUserId;
    message: string;
    messages: any[] = [];
    user: string;
    chatId;
    loader;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private thisRoute: ActivatedRoute,
                private chatService: ChatServiceService,
                private socket: Socket,
                private loadingController: LoadingController) {
        this.user = this.thisRoute.snapshot.paramMap.get('user');
        this.sendToUserId = this.thisRoute.snapshot.paramMap.get('userId');
        this.chatId = +this.thisRoute.snapshot.paramMap.get('chatId');

        this.chatService.getMessages().subscribe((message: any) => {
            this.messages.push(JSON.parse(message));
            // this.content.scrollToBottom(); todo
        });
        // this.getUsers().subscribe((data: any) => {
        //     const test = JSON.parse(data);
        //     const user = test.user;
        //     if (test.event === 'left') {
        //         this.showToast('User left: ' + user);
        //     } else {
        //         this.showToast('User joined: ' + user);
        //     }
        // });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ionViewWillEnter() {
        this.presentLoading();
        this.getConversationHistory();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    sendMessage() {
        this.chatService.sendMessage(this.message, this.sendToUserId)
            .subscribe(
                (response: any) => {
                    if (response.data.success) {
                        // this.messages.push({
                        //     user: this.username,
                        //     sender_id: this.idUser,
                        //     date_created: new Date(),
                        //     message: this.message
                        // });
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

    async presentLoading() {
        this.loader = await this.loadingController.create({
            message: 'Please wait...',
        });
        await this.loader.present();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // getMessages() {
    //     const observable = new Observable(observer => {
    //         this.socket.on('message', (data) => {
    //             console.log('message ' + data);
    //             observer.next(data);
    //         });
    //     });
    //     return observable;
    // }

    // getUsers() {
    //     const observable = new Observable(observer => {
    //         this.socket.on('users-changed', (data) => {
    //             console.log('users-changed');
    //             observer.next(data);
    //         });
    //     });
    //     return observable;
    // }

    // ionViewWillLeave() {
    //     this.socket.disconnect();
    // }

    // async showToast(msg) {
    //     const toast = await this.toastCtrl.create({
    //         message: msg,
    //         duration: 2000
    //     });
    //     toast.present();
    // }

}
