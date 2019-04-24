import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {tap} from 'rxjs/operators';
import {Observable, BehaviorSubject} from 'rxjs';

import {Storage} from '@ionic/storage';
import {User} from './user';
import {AuthResponse} from './auth-response';
import ENV from '../../ENV';

@Injectable({
    providedIn: 'root'
})
export class AuthService {
    authSubject = new BehaviorSubject(false);

    constructor(private  httpClient: HttpClient,
                private  storage: Storage) {
    }

    public getAccessToken() {
        return this.storage.get('ACCESS_TOKEN');
    }

    isLoggedIn() {
        return this.authSubject.value;
    }

    login(user: User): Observable<AuthResponse> {
        return this.httpClient.post(`${ENV.SERVER_ADDRESS}/users/login`, user).pipe(
            tap(async (res: AuthResponse) => {

                if (res.user) {
                    await this.storage.set('ACCESS_TOKEN', res.user.access_token);
                    await this.storage.set('EXPIRES_IN', res.user.expires_in);
                    this.authSubject.next(true);
                }
            })
        );
    }

    async logout() {
        await this.storage.remove('ACCESS_TOKEN');
        await this.storage.remove('EXPIRES_IN');
        this.authSubject.next(false);
    }

    register(user: User): Observable<AuthResponse> {
        return this.httpClient.post<AuthResponse>(`${ENV.SERVER_ADDRESS}/users`, user);
    }
}
