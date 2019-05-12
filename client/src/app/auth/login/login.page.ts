import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../auth.service';
import {ModalController} from '@ionic/angular';
import {RequestNewPasswordPage} from './request-new-password/request-new-password.page';
import {TokenService} from '../../services/token.service';
import {UserService} from '../../services/user.service';
import {GeolocationService} from '../../services/geolocation.service';

@Component({
    selector: 'app-login',
    templateUrl: './login.page.html',
    styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

    constructor(private  authService: AuthService,
                private  router: Router,
                private modalCtrl: ModalController,
                private tokenService: TokenService,
                private userService: UserService,
                private geolocationService: GeolocationService) {
    }

    ngOnInit() {
    }

    login(form) {
        this.authService.login(form.value)
            .subscribe(
                this.onLoginSuccess.bind(this),
                this.onLoginFailure.bind(this)
            );
    }

    public async onForgotPassword() {

        const modal: HTMLIonModalElement =
            await this.modalCtrl.create({
                component: RequestNewPasswordPage
            });

        await modal.present();
    }

    private async onLoginSuccess(data) {
        await this.tokenService.setAccessToken(data.data.token.access_token);
        await this.userService.setLoggedUser(data.data);
        this.authService.authSubject.next(true);
        this.geolocationService.watchLocation();
        const route = data.data.age ? 'home/search' : 'complete-profile';
        this.router.navigateByUrl(route);
    }

    private async onLoginFailure(error) {
        console.log('LoginFailure');
    }

}
