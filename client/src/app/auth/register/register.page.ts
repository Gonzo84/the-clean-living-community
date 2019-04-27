import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../auth.service';
import {ToastController} from '@ionic/angular';

@Component({
    selector: 'app-register',
    templateUrl: './register.page.html',
    styleUrls: ['./register.page.scss'],
})
export class RegisterPage {
    toggleStatus;

    constructor(private  authService: AuthService,
                private  router: Router,
                private toastCtrl: ToastController) {
    }

    private navigateToLogin() {
        this.router.navigateByUrl('login');
    }

    private async onRegisterSuccess(res) {
        const toast = await this.toastCtrl.create({
            message: 'You have successfully registered!',
            duration: 3000,
            position: 'bottom'
        });
        toast.onDidDismiss().then(this.navigateToLogin.bind(this));
        toast.present();
    }

    private register(form) {
        const type = this.toggleStatus ? 'mentor' : 'friend';
        form.value.type = type;
        this.authService.register(form.value).subscribe(this.onRegisterSuccess.bind(this));
    }
}
