import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {IonicModule} from '@ionic/angular';
import {SurveyPage} from './survey';
import {RouterModule, Routes} from '@angular/router';

const routes: Routes = [{
    path: '',
    component: SurveyPage
}
];

@NgModule({
    imports: [
        CommonModule,
        IonicModule,
        RouterModule.forChild(routes)
    ],
    declarations: [
        SurveyPage
    ]
})
export class SurveyPageModule {
}
