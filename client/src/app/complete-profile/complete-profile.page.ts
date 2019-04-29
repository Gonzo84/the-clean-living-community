import {Component} from '@angular/core';
import {ApiService} from '../services/api.service';
import {UserService} from '../services/user.service';
import {Router} from '@angular/router';

@Component({
    selector: 'app-complete-profile',
    templateUrl: './complete-profile.page.html',
    styleUrls: ['./complete-profile.page.scss'],
})
export class CompleteProfilePage {
    loggedUser;
    married = false;
    children = false;
    pet = false;
    smoker = false;
    support_groups = false;

    constructor(private api: ApiService,
                private userService: UserService,
                private router: Router) {
    }

    async submit(form) {
        this.loggedUser = await this.userService.getLoggedUser();
        this.api.completeProfile(form.value, this.loggedUser.id)
            .subscribe(this.onProfileCompleteSuccess.bind(this),
                this.onProfileCompleteFailure.bind(this)
            );
    }

    private async onProfileCompleteSuccess(data) {
        const updatedUser = {...this.loggedUser, ...data.data};
        await this.userService.setLoggedUser(updatedUser);
        this.router.navigateByUrl('home/search');
    }

    private onProfileCompleteFailure() {
        console.log('onProfileCompleteFailure');
    }

}
