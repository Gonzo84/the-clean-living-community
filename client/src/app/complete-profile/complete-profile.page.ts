import {Component, OnInit} from '@angular/core';
import {ApiService} from "../services/api.service";
import {UserService} from "../services/user.service";

@Component({
    selector: 'app-complete-profile',
    templateUrl: './complete-profile.page.html',
    styleUrls: ['./complete-profile.page.scss'],
})
export class CompleteProfilePage {
    married = false;
    children = false;
    pet = false;
    smoker = false;
    support_groups = false;

    constructor(private api: ApiService,
                private userService: UserService) {
    }

    async submit(form) {
        const user = await this.userService.getLoggedUser();
        this.api.completeProfile(form.value, user.id)
            .subscribe(this.onProfileCompleteSuccess.bind(this),
                this.onProfileCompleteFailure.bind(this)
            );
    }

    private onProfileCompleteSuccess() {
    }

    private onProfileCompleteFailure() {
    }

}
