import {Component} from '@angular/core';

import {Platform} from '@ionic/angular';
import {SplashScreen} from '@ionic-native/splash-screen/ngx';
import {StatusBar} from '@ionic-native/status-bar/ngx';
import {Router} from '@angular/router';
import {TokenService} from './services/token.service';
import {AuthService} from './auth/auth.service';

@Component({
    selector: 'app-root',
    templateUrl: 'app.component.html'
})
export class AppComponent {
    constructor(
        private platform: Platform,
        private splashScreen: SplashScreen,
        private statusBar: StatusBar,
        private tokenService: TokenService,
        private authService: AuthService,
        private router: Router
    ) {
        this.initializeApp();
    }

    initializeApp() {
        this.platform.ready().then(() => {
            this.statusBar.styleDefault();
            this.verifyToken();
        });
    }

    /**
     * If token is valid triggers further data requests, else displays login page
     */
    public async verifyToken(): Promise<any> {
        const token = await this.tokenService.getAccessToken();
        let route;
        if (token) {
            this.authService.authSubject.next(true);
            route = '/home/search';
        } else {
            route = '/login';
        }
        this.router.navigateByUrl(route);
        this.splashScreen.hide();
    }
}
