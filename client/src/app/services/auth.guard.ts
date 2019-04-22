import {Injectable} from '@angular/core';
import {CanActivate} from '@angular/router';
import {AuthService} from '../auth/auth.service';

@Injectable({
    providedIn: 'root'
})
export class AuthGuard implements CanActivate {

    constructor(private authService: AuthService) {
    }

    canActivate() {
        return true;
        // return this.authService.isLoggedIn();
    }
}
