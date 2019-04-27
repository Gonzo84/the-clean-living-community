import {Component} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {UserService} from '../../services/user.service';
import {ApiService} from '../../services/api.service';
import {ChatServiceService} from '../../services/chat-service.service';

@Component({
    selector: 'app-my-profile',
    templateUrl: './my-profile.component.html',
    styleUrls: ['./my-profile.component.scss'],
})
export class MyProfileComponent {
    private lastRelapseMap = {
        1: 'A day ago',
        3: 'Few days ago',
        7: 'More than a week',
        30: 'More than a month',
        90: 'More than a 3 months',
        180: 'Half a year ago',
        365: 'More than a year',
        1095: 'More than 3 years'
    };

    profile: any = {};
    loggedUser;

    constructor(
        private activatedRoute: ActivatedRoute,
        private userService: UserService,
        private api: ApiService,
        private router: Router,
        private chatService: ChatServiceService) {
    }

    async ionViewDidEnter() {
        this.loggedUser = await this.userService.getLoggedUser();
        const id = this.activatedRoute.snapshot.paramMap.get('id');
        if (id) {
            this.getUserInfo(id);
        } else {
            this.getUserInfo(this.loggedUser.id);
        }
    }

    getUserInfo(id) {
        this.api.getUserInfo(id)
            .subscribe(this.updateUser.bind(this));
    }

    onChatClick(receiver_id, name) {
        this.chatService.getChatRoomId(this.loggedUser.id, receiver_id)
            .subscribe(
                (response: any) => {
                    if (response.data.success) {
                        this.router.navigate(['/home/chat', { chatId: response.data.chatId, receiver_name: name, receiver_id: receiver_id }]);
                    }
                }
            );
    }

    transformLastRelapse(days) {
        return this.lastRelapseMap[days];
    }

    updateUser(response) {
        this.profile = response.data;
    }
}
