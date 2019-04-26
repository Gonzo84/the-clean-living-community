/* tslint:disable:max-line-length */
import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {HttpClient} from '@angular/common/http';
import {TokenService} from '../../services/token.service';
import {UserService} from '../../services/user.service';
import ENV from '../../../ENV';

@Component({
    selector: 'app-my-profile',
    templateUrl: './my-profile.component.html',
    styleUrls: ['./my-profile.component.scss'],
})
export class MyProfileComponent implements OnInit {

    profile: any = {};

    constructor(
        private tokenService: TokenService,
        private activatedRoute: ActivatedRoute,
        private http: HttpClient,
        private userService: UserService) {
    }

    updateUser(response) {
        this.profile = response.data;
    }

    // noinspection JSUnusedGlobalSymbols
    ionViewDidEnter() {
        const id = this.activatedRoute.snapshot.paramMap.get('id');
        if (id !== '') {
            this.getUserInfo(id);
        } else {
            this.userService.getLoggedUser().then((userInfo: any) => {
                this.getUserInfo(userInfo.id);
            });
        }
    }

    getUserInfo(id) {
        const accessToken = this.tokenService.getAccessToken();
        this.http.get(`${ENV.SERVER_ADDRESS}/users/${id}/data`, {
            headers: {
                Authorisation: `Bearer ${accessToken}`
            }
        }).subscribe(this.updateUser.bind(this));
    }

    ngOnInit() {
    }

    onChatClick() {
        console.log('open chat');
    }
}
