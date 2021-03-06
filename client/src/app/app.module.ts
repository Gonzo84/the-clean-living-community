import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {RouteReuseStrategy} from '@angular/router';
import {HTTP_INTERCEPTORS} from '@angular/common/http';
import {TokenInterceptor} from './interceptors/token.interceptor';

import {IonicModule, IonicRouteStrategy, NavParams} from '@ionic/angular';
import {SplashScreen} from '@ionic-native/splash-screen/ngx';
import {StatusBar} from '@ionic-native/status-bar/ngx';
import {FontAwesomeModule} from '@fortawesome/angular-fontawesome';
import {library} from '@fortawesome/fontawesome-svg-core';
import {faCoffee} from '@fortawesome/free-solid-svg-icons';
import {fas} from '@fortawesome/free-solid-svg-icons';

import {AppComponent} from './app.component';
import {AppRoutingModule} from './app-routing.module';
import {AuthModule} from './auth/auth.module';

import {SocketIoModule, SocketIoConfig} from 'ng-socket-io';
import {ApiService} from './services/api.service';
import {UserService} from './services/user.service';
import {SurveyPageModule} from './survey/survey.module';
import ENV from '../ENV';
import {Geolocation} from '@ionic-native/geolocation/ngx';
import {GeolocationService} from './services/geolocation.service';

const config: SocketIoConfig = {url: ENV.SOCKET_ADDRESS, options: {}};

@NgModule({
    declarations: [AppComponent],
    entryComponents: [],
    imports: [
        BrowserModule,
        IonicModule.forRoot(),
        AppRoutingModule,
        AuthModule,
        FontAwesomeModule,
        SocketIoModule.forRoot(config),
        SurveyPageModule
    ],
    providers: [
        ApiService,
        StatusBar,
        SplashScreen,
        UserService,
        Geolocation,
        GeolocationService,
        {provide: RouteReuseStrategy, useClass: IonicRouteStrategy},
        {
            provide: HTTP_INTERCEPTORS,
            useClass: TokenInterceptor,
            multi: true
        }
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
    constructor() {
        library.add(faCoffee, fas);
    }
}
