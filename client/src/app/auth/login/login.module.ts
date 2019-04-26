import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {Routes, RouterModule} from '@angular/router';
import {FontAwesomeModule} from '@fortawesome/angular-fontawesome';

import {IonicModule} from '@ionic/angular';

import {LoginPage} from './login.page';
import {RequestNewPasswordPage} from './request-new-password/request-new-password.page';

const routes: Routes = [
    {
        path: '',
        component: LoginPage
    }
];

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        IonicModule,
        RouterModule.forChild(routes),
        FontAwesomeModule
    ],
    declarations: [LoginPage,
        RequestNewPasswordPage],
    entryComponents: [RequestNewPasswordPage],
})
export class LoginPageModule {
}
