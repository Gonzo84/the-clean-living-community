import {Component} from '@angular/core';
import {Socket} from 'ng-socket-io';
import {Observable} from 'rxjs/Observable';
import {NavParams, ToastController} from '@ionic/angular';
import {ActivatedRoute} from '@angular/router';
import {ChatServiceService} from '../services/chat-service.service';


@Component({
    selector: 'app-chat-room',
    templateUrl: './chat-room.page.html',
    styleUrls: ['./chat-room.page.scss'],
})
export class ChatRoomPage {
    idUser = 1;
    idAnotherUser = 2;
    messages: any[] = [];
    // nickname = '';
    // message = '';

    constructor(private thisRoute: ActivatedRoute,
                private chatService: ChatServiceService,
                private socket: Socket,
                private toastCtrl: ToastController) {
        // this.nickname = this.thisRoute.snapshot.paramMap.get('nickname');

        this.chatService.getMessages().subscribe((message: any) => {
            console.log(message);
            this.messages.push(JSON.parse(message));
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

    sendMessage(message: string) {

        this.chatService.sendMessage(message, this.idAnotherUser)
            .subscribe(
                (response: any) => {

                },
                err => {

                }
            );
        // this.socket.emit('add-message', {text: this.message});
        // this.message = '';
    }

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
