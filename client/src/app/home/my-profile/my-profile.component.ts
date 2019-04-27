import {Component} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {UserService} from '../../services/user.service';
import {ApiService} from '../../services/api.service';

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
        private router: Router) {
    }

    async ionViewDidEnter() {
        const id = this.activatedRoute.snapshot.paramMap.get('id');
        if (id) {
            this.getUserInfo(id);
        } else {
            this.loggedUser = await this.userService.getLoggedUser();
            this.getUserInfo(this.loggedUser.id);
        }
    }

    getUserInfo(id) {
        this.api.getUserInfo(id)
            .subscribe(this.updateUser.bind(this));
    }

    onChatClick() {
        // this.router.navigateByUrl('chat/id'); uncomment when chat implemented
        console.log('open chat');
    }

    transformLastRelapse(days) {
        return this.lastRelapseMap[days];
    }

    updateUser(response) {
        this.profile = response.data;
    }
}
