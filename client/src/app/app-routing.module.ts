import {NgModule} from '@angular/core';
import {PreloadAllModules, RouterModule, Routes} from '@angular/router';
import {AuthGuard} from './services/auth.guard';

const routes: Routes = [
    {path: '', redirectTo: 'home', pathMatch: 'full'},
    {
        path: 'home',
        canActivate: [AuthGuard],
        loadChildren: './home/home.module#HomePageModule'
    },
    {path: 'register', loadChildren: './auth/register/register.module#RegisterPageModule'},
    {path: 'login', loadChildren: './auth/login/login.module#LoginPageModule'},
    {
        path: 'survey',
        canActivate: [AuthGuard],
        loadChildren: './survey/survey.module#SurveyPageModule'
    },
    {
        path: 'complete-profile',
        canActivate: [AuthGuard],
        loadChildren: './complete-profile/complete-profile.module#CompleteProfilePageModule'
    }
];

@NgModule({
    imports: [
        RouterModule.forRoot(routes, {preloadingStrategy: PreloadAllModules})
    ],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
