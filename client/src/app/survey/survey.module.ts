import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {IonicModule} from '@ionic/angular';
import {SurveyPage} from './survey';
import {RouterModule, Routes} from '@angular/router';
import {FormsModule} from '@angular/forms';
import {PersonalDetails} from './personal-details/personal-details'

const routes: Routes = [{
    path: '',
    component: SurveyPage
}
];

@NgModule({
    imports: [
        FormsModule,
        CommonModule,
        IonicModule,
        RouterModule.forChild(routes)
    ],
    declarations: [
        SurveyPage,
        PersonalDetails
    ]
})
export class SurveyPageModule {
}
