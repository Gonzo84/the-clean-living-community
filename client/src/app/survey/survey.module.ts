import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {IonicModule} from '@ionic/angular';
import {SurveyPage} from './survey';
import {RouterModule, Routes} from '@angular/router';
import {FormsModule} from '@angular/forms';
import {DebugPipe} from '../pipes/debug';

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
        DebugPipe,
        SurveyPage
    ]
})
export class SurveyPageModule {
}
