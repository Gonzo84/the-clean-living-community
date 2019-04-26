import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../auth.service';
import {ModalController} from "@ionic/angular";
import {RequestNewPasswordPage} from "./request-new-password/request-new-password.page";

@Component({
    selector: 'app-login',
    templateUrl: './login.page.html',
    styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

    constructor(private  authService: AuthService,
                private  router: Router,
                private modalCtrl: ModalController) {
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

    private async onForgotPassword() {

        const modal: HTMLIonModalElement =
            await this.modalCtrl.create({
                component: RequestNewPasswordPage
            });

        await modal.present();
    }

    private onLoginSuccess(data) {
        const route = data.data.age ? 'home/search' : 'complete-profile';
        this.router.navigateByUrl(route);
    }

    private async onLoginFailure(error) {
        console.log('LoginFailure');
    }

}
