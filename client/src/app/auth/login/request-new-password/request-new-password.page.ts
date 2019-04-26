import {Component} from '@angular/core';
import {ModalController, ToastController} from '@ionic/angular';
import {ApiService} from '../../../services/api.service';

@Component({
    selector: 'app-request-new-password',
    templateUrl: './request-new-password.page.html',
    styleUrls: ['./request-new-password.page.scss'],
})
export class RequestNewPasswordPage {

    constructor(private toastCtrl: ToastController,
                private api: ApiService,
                private modalCtrl: ModalController) {
    }

    dismissModal() {
        this.modalCtrl.dismiss();
    }

    onSubmit(form) {
        this.api.resetPassword(form.value)
            .subscribe(
                this.onPasswordChangedSuccessfully.bind(this)
            );
    }

    private async onPasswordChangedSuccessfully() {
        const toast = await this.toastCtrl.create({
            message: 'A new password has been sent to your e-mail address.',
            duration: 3000,
            position: 'bottom'
        });
        toast.onDidDismiss().then(this.dismissModal.bind(this));
        toast.present();
    }

}
