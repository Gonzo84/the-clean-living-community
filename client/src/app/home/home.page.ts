import {Component, OnDestroy, OnInit} from '@angular/core';
import {ChatServiceService} from '../services/chat-service.service';
import {Storage} from '@ionic/storage';
import {ActivatedRoute, Router} from '@angular/router';
import {Subscription} from 'rxjs';
import {UserService} from '../services/user.service';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

@Component({
    selector: 'app-home',
    templateUrl: 'home.page.html',
    styleUrls: ['home.page.scss'],
})
export class HomePage implements OnDestroy, OnInit {

    user: any;
    unreadMessageStatus = false;
    subscription: Subscription;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    constructor(private chatService: ChatServiceService,
                private storage: Storage,
                private router: Router,
                private thisRoute: ActivatedRoute,
                private userService: UserService) {
        // gonzo don't touch this
        this.storage.get('LOGGED_USER').then((data) => {
            this.user = data;
        }).then(() => {
            this.chatService.getMessages(this.user.id).subscribe((message: any) => {
                if (this.chatService.getActiveChatId() != JSON.parse(message).chatId) {
                    this.chatService.setUnreadMessageStatus(true);
                }
            });

            this.checkForUnreadMessages();
        });

        this.subscription = this.chatService.getUnreadMessageStatus().subscribe(status => {
            this.unreadMessageStatus = status;
        });

    }

    public async ngOnInit() {
        if (!this.user.survey_score) {
            this.router.navigateByUrl('survey');
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    checkForUnreadMessages() {
        this.chatService.checkForUnreadMessages(this.user.id).subscribe(
            (response: any) => {
                if (response.data.success) {
                    this.chatService.setUnreadMessageStatus(response.data.status);
                }
            }
        );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ngOnDestroy() {
        this.subscription.unsubscribe();
        this.chatService.socketDisconnect();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
