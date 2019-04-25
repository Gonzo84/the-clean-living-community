import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {tap} from 'rxjs/operators';
import {Observable, BehaviorSubject} from 'rxjs';
import {Storage} from '@ionic/storage';
import {UserInterface} from "../interfaces/user";
import {AuthResponseInterface} from '../interfaces/auth-response';
import ENV from '../../ENV';
import {UserService} from "../services/user.service";
import {TokenService} from "../services/token.service";

@Injectable({
    providedIn: 'root'
})
export class AuthService {
    authSubject = new BehaviorSubject(false);

    constructor(private  httpClient: HttpClient,
                private  storage: Storage,
                private userService: UserService,
                private tokenService: TokenService) {
    }

    public getAccessToken() {
        return this.storage.get('ACCESS_TOKEN');
    }

    isLoggedIn() {
        return this.authSubject.value;
    }

    login(user: UserInterface): Observable<AuthResponseInterface> {
        return this.httpClient.post(`${ENV.SERVER_ADDRESS}/users/login`, user).pipe(
            tap(async (res: AuthResponseInterface) => {
                if (res.data) {
                    await this.tokenService.setAccessToken(res.data.token.access_token);
                    await this.userService.setLoggedUser(res.data);
                    this.authSubject.next(true);
                }
            })
        );
    }

    async logout() {
        await this.tokenService.removeAccessToken();
        await this.userService.removeLoggedUser();
        this.authSubject.next(false);
    }

    register(user: UserInterface): Observable<AuthResponseInterface> {
        return this.httpClient.post<AuthResponseInterface>(`${ENV.SERVER_ADDRESS}/users`, user);
    }
}
