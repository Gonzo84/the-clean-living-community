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

    profile: any = {};

    constructor(
        private activatedRoute: ActivatedRoute,
        private userService: UserService,
        private api: ApiService,
        private router: Router) {
    }

    ionViewDidEnter() {
        const id = this.activatedRoute.snapshot.paramMap.get('id');
        if (id) {
            this.getUserInfo(id);
        } else {
            this.userService.getLoggedUser()
                .then((userInfo: any) => {
                    this.getUserInfo(userInfo.id);
                });
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

    updateUser(response) {
        this.profile = response.data;
    }
}
