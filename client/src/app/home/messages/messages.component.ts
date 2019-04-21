import {Component, OnInit} from '@angular/core';
import {ChatServiceService} from '../../services/chat-service.service';
import {Router} from '@angular/router';
import {LoadingController} from '@ionic/angular';

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private chatService: ChatServiceService,
                private router: Router,
                private loadingController: LoadingController) {

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ngOnInit() {
        this.presentLoading();
        this.getConversationsList();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // todo loader
    // ionViewWillEnter() {
    //     console.log('listing');
    // }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    getConversationsList() {
        this.chatService.getConversationsList()
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

    enterChatRoom(message) {
        this.router.navigate(['/home/chat', { chatId: message.chatId, user: message.user, userId: message.userId }]);
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
